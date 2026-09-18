<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendLicJob  extends AbstractEgresadoMailJob
{
    protected function buildQuery(): Builder
    {
        return DB::table('egresados')
            ->leftJoin('respuestas20', 'respuestas20', '=', 'egresados.cuenta')
            ->where('egresados.muestra','=','5')
            ->where(function ($query) {
                $query->whereNull('respuestas_especialidad.completed')
                    ->orWhere('respuestas20.completed', '!=', '1');
            })
            ->select('egresados.id', 'egresados.cuenta', 'egresados.nombre', 'egresados.paterno')
            ->orderByDesc('egresados.id');
    }

    protected function getMailClass(): string
    {
        return InvitacionMail::class;
    }

    protected function getDefaultIntereses(): array
    {
        return [
            ['text' => 'Trámita tu credencial de egresado', 'link' => 'https://www.pveaju.unam.mx/credencial/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/credencial.png'],
            ['text' => 'Bolsa de trabajo UNAM', 'link' => 'https://but.unam.mx/siiabut/public/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/entrevista.png'],
            ['text' => 'Apoyanos en el ranking internacional! encuesta de empleabilidad verde', 'link' => 'https://encuestas.pveaju.unam.mx/encuesta_verde/inicio/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/emp_verde.png'],
        ];
    }
}
