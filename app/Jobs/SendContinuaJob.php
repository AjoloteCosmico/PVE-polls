<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\EdContinuaMail;
use App\Models\Correo;

class SendContinuaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 0; // sin timeout
    public $tries = 3;

    protected $intereses;

    public function __construct(array $intereses = null)
    {
        $this->intereses = $intereses ?? [
            ['text'=>'Trámita tu credencial de egresado','link'=>'https://www.pveaju.unam.mx/credencial/','image'=>'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/credencial.png'],
            ['text'=>'Bolsa de trabajo UNAM','link'=>'https://but.unam.mx/siiabut/public/','image'=>'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/entrevista.png'],
            ['text'=>'¿Problemas para titularte? Primer Feria de titulación 2026','link'=>'https://titulacion.unam.mx/','image'=>'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/feria_tit.png'],
            ['text'=>'Apoyanos en el ranking internacional! encuesta de empleabilidad verde','link'=>'https://encuestas.pveaju.unam.mx/encuesta_verde/inicio/','image'=>'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/emp_verde.png'],
        ];
    }

   
   public function handle()
{
    DB::table('egresados')
        ->join('egresado_muestra', 'egresado_muestra.egresado_id', '=', 'egresados.id')
        ->leftJoin('respuestas_continua', 'respuestas_continua.cuenta', '=', 'egresados.cuenta')
        ->where('egresado_muestra.muestra_id', 897)
        ->whereNotIn('egresado_muestra.status', ['1', '2'])
        ->whereNull('respuestas_continua.edc1')
        ->where('egresados.muestra', '!=', '5')
        ->where(function ($query) {
            $query->whereNull('egresados.act_suvery')
                  ->orWhere('egresados.act_suvery', '!=', '2');
        })
        ->select('egresados.id', 'egresados.cuenta', 'egresados.nombre', 'egresados.paterno')
        ->orderByDesc('egresados.id')
        ->lazy(100)
        ->each(function ($eg) {
            try {
                $correos = Correo::where('cuenta', $eg->cuenta)->get();
                
                if ($correos->isEmpty()) {
                    return;
                }

                $data = [
                    'nombre' => trim($eg->nombre.' '.$eg->paterno),
                    'cuenta' => $eg->cuenta,
                    'url_encuesta' => 'https://encuestas.pveaju.unam.mx/encuesta_generacion/general',
                    'extra_items' => $this->intereses
                ];

                foreach ($correos as $correo) {
                    // 1. Limpiar espacios y pasar a minúsculas por si acaso
                    $email = trim(strtolower($correo->correo));

                    // 2. Validar que no sea nulo, vacío, "nan" y que cumpla el filtro RFC de email válido
                    if (empty($email) || $email === 'nan' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        // Opcional: puedes registrar en el log qué correo malo se omitió para depurar después
                        Log::warning("Correo inválido omitido para la cuenta {$eg->cuenta}: " . $correo->correo);
                        continue;
                    }

                    // Comprobación idempotente
                    $already = DB::table('email_tracking')
                        ->where('recipient_email', $email)
                        ->where('type', 'continua')
                        ->where('created_at', '>=', '2026-09-01')
                        ->exists();

                    if ($already) {
                        continue;
                    }

                    $specific = $data + ['correo' => $email, 'correo_id' => $correo->id];
                    
                    // Encolar de manera segura sabiendo que el correo es 100% válido
                    Mail::to($email)->queue(new EdContinuaMail($specific));
                }
            } catch (\Exception $e) {
                Log::error('SendContinuaJob error cuenta '.$eg->cuenta.' : '.$e->getMessage());
            }
        });
}
    }