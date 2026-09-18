<?php

namespace App\Jobs;

use App\Mail\EspecialidadConvocatoriaMail;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class EspecialidadConvocatoriajob extends AbstractEgresadoMailJob
{
    protected function buildQuery(): Builder
    {
        return DB::table('egresados_especialidad')
            ->leftJoin('respuestas_especialidad', 'respuestas_especialidad.cuenta', '=', 'egresados_especialidad.cuenta')
            ->whereIn('egresados_especialidad.anio_egreso', [2020, 2021, 2022, 2023])
            ->where(function ($query) {
                $query->whereNull('respuestas_especialidad.sec_espf')
                    ->orWhere('respuestas_especialidad.sec_espf', '!=', '1')
                    ->orWhere('respuestas_especialidad.espf1', '=', '2');
            })
            ->select('egresados_especialidad.id', 'egresados_especialidad.cuenta', 'egresados_especialidad.nombre', 'egresados_especialidad.paterno')
            ->orderByDesc('egresados_especialidad.id');
    }

   

    protected function getMailClass(): string
    {
        return EspecialidadConvocatoriaMail::class;
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
