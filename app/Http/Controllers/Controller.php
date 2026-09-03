<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


use App\Mail\InvMail;
use App\Mail\EspMail;
use App\Mail\PosMail;
use App\Mail\AvisoPrivacidadMail;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, DispatchesJobs;

    /**
     * Metodo que se va a heredar para hacer uso de el al momento de enviar el aviso de privacidad a los egresados.
     */
    // protected function enviarAviso($emailId, $recipientEmail, $nombreEgresado, $scriptName = 'aviso.py'){
    //     $tracking_id = (string) Str::uuid();
    //     $ahora = now();

    //     DB::table('email_tracking')->insert([
    //         'email_id' => $emailId,
    //         'recipient_email' => $recipientEmail,
    //         'tracking_uuid' => $tracking_id,
    //         'type' => 'aviso',
    //         'created_at' => $ahora,
    //         'sended_at' => $ahora,
    //         'updated_at' => $ahora,
    //     ]);
    //     $caminoalpoder=public_path();
    //     $process =new Process([
    //         env('PY_COMAND'),
    //         $caminoalpoder . '/' . $scriptName,
    //         $nombreEgresado,
    //         $recipientEmail,
    //         $tracking_id
    //     ]);
    //     $process->run();
    //     if (!$process->isSuccessful()) {
    //         throw new ProcessFailedException($process);
    //     }
    //     $data = $process->getOutput();
    //     return redirect()->route('aviso');
    // }


    protected function enviarAviso($emailId, $recipientEmail, $nombreEgresado, $cuenta){
       $intereses = [
            ['text' => 'Trámita tu credencial de egresado', 'link' => 'https://www.pveaju.unam.mx/credencial/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/credencial.png'],
            ['text' => 'Bolsa de trabajo UNAM', 'link' => 'https://but.unam.mx/siiabut/public/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/entrevista.png'],
            ['text' => '¿Problemas para titularte? Primer Feria de titulación 2026', 'link' => 'https://titulacion.unam.mx/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/feria_tit.png'],
            ['text' => 'Apoyanos en el ranking internacional! encuesta de empleabilidad verde', 'link' => 'https://encuestas.pveaju.unam.mx/encuesta_verde/inicio/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/emp_verde.png'],
        ];
        $data = [
                'correo' => $recipientEmail, 
                'correo_id'=>$emailId,
                'nombre' => $nombreEgresado,
                'cuenta' => $cuenta,
                'extra_items' => $intereses // Aquí ahorita es una constante, pero habra q hacer un algoritomo ->getIntereses()
            ];

        Mail::to($recipientEmail)->queue(new AvisoPrivacidadMail($data));
        
        }

}
