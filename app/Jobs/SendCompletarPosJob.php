<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\CompletarPosgradoMail;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;



class SendCompletarPosJob extends AbstractEgresadoMailJob
{

    protected function buildQuery(): Builder
    {

        return DB::table('egresados_posgrado as pos')
            ->join('correos as c', 'pos.cuenta', '=', 'c.cuenta')
            ->join('respuestas_posgrado as rp', 'pos.cuenta', '=', 'rp.cuenta')
            ->whereNotNull('c.correo')
            ->whereNotNull('pos.cuenta')
            ->where('pos.cuenta', '!=', '')
            ->where(function ($query) {
                $query->whereNull('rp.completed')
                    ->orWhere('rp.completed', '!=', '1');
            })
            ->whereIn('pos.anio_egreso', [2019, 2020, 2021, 2022])
            ->where('pos.fuente', '=', 'base original')
            ->select(
                'c.correo',
                'c.id as correo_id',
                'pos.cuenta',
                DB::raw("CONCAT(pos.nombre, ' ', pos.paterno, ' ', pos.materno) AS nombre_completo"),
                'pos.programa as prog_acad'
            )
            ->orderBy('pos.cuenta');
    }

    protected function getMailClass(): string
    {
        return CompletarPosgradoMail::class;
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
