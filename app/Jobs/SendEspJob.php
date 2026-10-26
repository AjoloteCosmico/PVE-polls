<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEspJob  extends AbstractEgresadoMailJob
{

    protected function buildQuery(): Builder
    {

        return DB::table('egresados_especialidad as esp')
            ->join('correos as c', 'esp.cuenta', '=', 'c.cuenta')
            ->leftJoin('respuestas_especialidad as re', 'esp.cuenta', '=', 're.cuenta')
            ->whereNotNull('c.correo')
            ->whereNotNull('esp.cuenta')
            ->where('esp.cuenta', '!=', '')
            ->where(function ($query) {
                $query->whereNull('re.completed')
                    ->orWhere('re.completed', '!=', 1);
            })
            ->whereIn('esp.anio_egreso', [ 2020, 2021, 2022,2023])
            // ->where('pos.fuente', '=', 'base original')
            // ->whereIn('pos.plan', $planes)
            ->select(
                'c.correo',
                'c.id as correo_id',
                'esp.cuenta',
                DB::raw("CONCAT(esp.nombre, ' ', esp.paterno, ' ', esp.materno) AS nombre_completo"),
                'esp.especialidad as prog_acad'
            )
            ->orderBy('esp.cuenta');
    }

    protected function getMailClass(): string
    {
        return EspMail::class;
    }

    protected function getDefaultIntereses(): array
    {
        return [
            ['text' => 'Trámita tu credencial de egresado', 'link' => 'https://www.pveaju.unam.mx/credencial/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/credencial.png'],
            ['text' => 'Responde la encuesta de seguimiento especialidad UNAM', 'link' => 'https://encuestas.pveaju.unam.mx/pveaju/resource/enc_especialidad', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/pos_derecho.png'],
            ['text' => 'Bolsa de trabajo UNAM', 'link' => 'https://but.unam.mx/siiabut/public/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/entrevista.png'],
            ['text' => 'Apoyanos en el ranking internacional! encuesta de empleabilidad verde', 'link' => 'https://encuestas.pveaju.unam.mx/encuesta_verde/inicio/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/emp_verde.png'],
        ];
    }

}
