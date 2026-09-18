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

abstract class AbstractEgresadoMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 0;
    public $tries = 3;

    protected array $intereses;

    public function __construct(?array $intereses = null,$IdempotenceDate)
    {
        $this->intereses = $intereses ?? $this->getDefaultIntereses();
        $this->IdempotenceDate=$IdempotenceDate;
    }

    abstract protected function buildQuery(): Builder;


    abstract protected function getMailClass(): string;

    abstract protected function getDefaultIntereses(): array;

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

    public function handle()
    {
        $this->buildQuery()
            ->lazy(100)
            ->each(function ($eg) {
                try {
                    $correos = Correo::where('cuenta', $eg->cuenta)->get();

                    if ($correos->isEmpty()) {
                        return;
                    }

                    $data = [
                        'nombre' => trim($eg->nombre . ' ' . $eg->paterno),
                        'cuenta' => $eg->cuenta,
                        'extra_items' => $this->intereses,
                    ];

                    foreach ($correos as $correo) {
                        $email = trim(strtolower($correo->correo));

                        if (empty($email) || $email === 'nan' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            Log::warning("Correo inválido omitido para la cuenta {$eg->cuenta}: " . $correo->correo);
                            continue;
                        }

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
                    Log::error('AbstractEgresadoMailJob error cuenta ' . $eg->cuenta . ' : ' . $e->getMessage());
                }
            });
    }
}
