<?php

namespace App\Jobs;

use App\Models\Correo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use DateTimeInterface;

abstract class AbstractEgresadoMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    //por defecto sin tiempo limite
    public $timeout = 0;
    //maximo 3 intentos
    public $tries = 3;

    protected array $intereses;
    protected DateTimeInterface $IdempotenceDate;
//al construir, solo cambia el arreglo de intereses y la fecha para validar no duplicidad
    public function __construct(?array $intereses = null,$IdempotenceDate)
    {
        $this->intereses = $intereses ?? $this->getDefaultIntereses();
        $this->IdempotenceDate=$IdempotenceDate;
    }

    abstract protected function buildQuery(): Builder;


    abstract protected function getMailClass(): string;

    abstract protected function getDefaultIntereses(): array;

    /**
     * Permite depurar el resultado final del filtro sin ejecutar el envío real.
     *
     * Ejemplo:
     *   $job = new SendEspJob(null, now());
     *   $job->debugQuery([
     *      'buscar' => '123456',
     *      'tipo' => 'todos',
     *      'cuenta' => '123456',
     *      'correo' => 'juan@ejemplo.com',
     *   ]);
     */
    public function debugQuery(array $filtros = [], bool $dump = true): array
    {
        $query = $this->buildQuery();

        $sql = $query->toSql();
        $bindings = $query->getBindings();
        $resultados = $query->get()->map(function ($row) {
            return (array) $row;
        })->all();

        $filtrados = $this->applyDebugFilters($resultados, $filtros);

        $payload = [
            'sql' => $sql,
            'bindings' => $bindings,
            'total_bruto' => count($resultados),
            'total_filtrado' => count($filtrados),
            'cuentas' => array_values(array_unique(array_filter(array_map(function ($row) {
                $cuenta = $row['cuenta'] ?? $row['numero_cuenta'] ?? null;
                return is_scalar($cuenta) ? (string) $cuenta : null;
            }, $filtrados)))),
            'filtros' => $filtros,
            'rows' => $filtrados,
        ];

        Log::info('Debug filtro egresados', $payload);

        if ($dump) {
            dump($payload);
        }

        return $payload;
    }

    protected function applyDebugFilters(array $rows, array $filtros = []): array
    {
        $buscar = strtolower(trim((string) ($filtros['buscar'] ?? '')));
        $cuenta = trim((string) ($filtros['cuenta'] ?? ''));
        $correo = strtolower(trim((string) ($filtros['correo'] ?? '')));
        $tipo = strtolower(trim((string) ($filtros['tipo'] ?? '')));

        if ($buscar === '' && $cuenta === '' && $correo === '' && ($tipo === '' || $tipo === 'todos')) {
            return $rows;
        }

        return array_values(array_filter($rows, function ($row) use ($buscar, $cuenta, $correo, $tipo) {
            $row = (array) $row;

            $valorCuenta = strtolower((string) ($row['cuenta'] ?? $row['numero_cuenta'] ?? ''));
            $valorCorreo = strtolower((string) ($row['correo'] ?? $row['email'] ?? ''));
            $textoGeneral = strtolower(json_encode($row));

            if ($cuenta !== '' && $valorCuenta !== strtolower($cuenta)) {
                return false;
            }

            if ($correo !== '' && !str_contains($valorCorreo, $correo)) {
                return false;
            }

            if ($tipo !== '' && $tipo !== 'todos') {
                $coincideTipo = str_contains($textoGeneral, $tipo)
                    || str_contains($valorCuenta, $tipo)
                    || str_contains($valorCorreo, $tipo);

                if (!$coincideTipo) {
                    return false;
                }
            }

            if ($buscar !== '' && !str_contains($textoGeneral, $buscar)) {
                return false;
            }

            return true;
        }));
    }

    //todo este rollo solo es para traer de la clase Mail el type que graba en email_Tracking al enviarse
    protected function getTrackingType(): string
    {
        $mailClass = $this->getMailClass();

        if (!class_exists($mailClass)) {
            throw new \InvalidArgumentException("La clase de correo {$mailClass} no existe.");
        }

        $reflectionClass = new \ReflectionClass($mailClass);
        $mailInstance = $reflectionClass->newInstanceWithoutConstructor();

        $reflectionMethod = new \ReflectionMethod($mailClass, 'defineType');
        $reflectionMethod->setAccessible(true);

        return (string) $reflectionMethod->invoke($mailInstance);
    }
//logica en que se procesa el envio
    public function handle()
    {
        //aqui en cada clase especifica se define elq uery para encontrar los egresados
        $this->buildQuery()
            ->lazy(100)
            ->each(function ($eg) {
                try {
                    $correos = Correo::where('cuenta', $eg->cuenta)->get();

                    if ($correos->isEmpty()) {
                        return;
                    }

                    $data = [
                        'nombre' => $eg->nombre_completo ?? trim(($eg->nombre ?? '') . ' ' . ($eg->paterno ?? '')),
                        'cuenta' => $eg->cuenta,
                        'prog_acad' => $eg->prog_acad ?? '',
                        'extra_items' => $this->intereses,
                    ];

                    foreach ($correos as $correo) {
                        $email = trim(strtolower($correo->correo));

                       //validacion de formato, aqui se podria agregar la logica para reparar
                        if (empty($email) || $email === 'nan' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            Log::warning("Correo inválido omitido para la cuenta {$eg->cuenta}: " . $correo->correo);
                            continue;
                        }
                       // chekeo de no duplicidad (idempotencia de la operación)
                        $already = DB::table('email_tracking')
                            ->where('recipient_email', $email)
                            ->where('type', $this->getTrackingType())
                            ->where('created_at', '>=', $this->IdempotenceDate)
                            ->exists();

                        if ($already) {
                            continue;
                        }

                        $specific = $data + ['correo' => $email, 'correo_id' => $correo->id];
                        $mailClass = $this->getMailClass();

                        Mail::to($email)->queue((new $mailClass($specific))->onQueue('emails'));
                    }
                } catch (\Exception $e) {
                    Log::error('AbstractEgresadoMailJob error cuenta ' . $eg->cuenta . ' : ' . $e->getMessage() . $this->getTrackingType());
                }
            });
    }
}
