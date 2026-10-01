<?php

namespace App\Traits;

use App\Models\Correo;
use Illuminate\Support\Facades\Mail;
use App\Mail\AvisoPrivacidadMail;


trait EnviaAvisoPrivacidad
{
    protected function enviarAviso($emailId, $recipientEmail, $nombreEgresado, $cuenta)
    {
        $intereses = [
            ['text' => 'Trámita tu credencial de egresado', 'link' => 'https://www.pveaju.unam.mx/credencial/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/credencial.png'],
            ['text' => 'Bolsa de trabajo UNAM', 'link' => 'https://but.unam.mx/siiabut/public/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/entrevista.png'],
            ['text' => '¿Problemas para titularte? Primer Feria de titulación 2026', 'link' => 'https://titulacion.unam.mx/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/feria_tit.png'],
            ['text' => '¡Apoyanos en el ranking internacional! Encuesta de empleabilidad verde', 'link' => 'https://encuestas.pveaju.unam.mx/encuesta_verde/inicio/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/emp_verde.png'],
        ];

        $data = [
            'correo' => $recipientEmail,
            'correo_id' => $emailId,
            'nombre' => $nombreEgresado,
            'cuenta' => $cuenta,
            'extra_items' => $intereses,
        ];

        Mail::to($recipientEmail)->queue((new AvisoPrivacidadMail($data))->onQueue('high'));
    }
}