<?php

namespace App\Jobs;

use App\Mail\EdContinuaMail;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class SendContinuaJob extends AbstractEgresadoMailJob
{
    protected function buildQuery(): Builder
    {
        return DB::table('egresados')
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
            ->orderByDesc('egresados.id');
    }

   

    protected function getMailClass(): string
    {
        return EdContinuaMail::class;
    }

    protected function getDefaultIntereses(): array
    {
        return [
            ['text' => 'Trámita tu credencial de egresado', 'link' => 'https://www.pveaju.unam.mx/credencial/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/credencial.png'],
            ['text' => 'Bolsa de trabajo UNAM', 'link' => 'https://but.unam.mx/siiabut/public/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/entrevista.png'],
            ['text' => 'No te pierdas el periódico virtual Egresados UNAM ', 'link' => 'https://www.flipsnack.com/editorialpveu/54', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/periodico.png'],
            ['text' => 'Apoyanos en el ranking internacional! encuesta de empleabilidad verde', 'link' => 'https://encuestas.pveaju.unam.mx/encuesta_verde/inicio/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/emp_verde.png'],
        ];
    }
}