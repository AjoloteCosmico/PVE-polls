<?php

namespace App\Jobs;

use App\Mail\InvMail;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CarrerasPequesJob  extends AbstractEgresadoMailJob
{
 
    protected function buildQuery(): Builder
    {
         return DB::table(function ($sub) {
        $sub->from('egresados as e')
            ->whereIn('e.anio_egreso', [2020, 2021, 2022])
            ->whereExists(function ($q) {
                $q->select(DB::raw(1))
                  ->from('carreras as c')
                  ->whereColumn('c.clave_carrera', 'e.carrera')
                  ->whereColumn('c.clave_plantel', 'e.plantel');
            })
            ->select(
                'e.*',
                DB::raw('COUNT(*) OVER (PARTITION BY e.carrera, e.plantel) AS total_generacion')
            );
    }, 't')
    ->where('t.total_generacion', '<', 60)
    ->whereNotExists(function ($q) {
        $q->select(DB::raw(1))
          ->from('respuestas20 as r')
          ->whereColumn('r.cuenta', 't.cuenta')
          ->where('r.completed', '1');
    })
    ->select('t.id', 't.cuenta', 't.nombre', 't.paterno', 't.carrera')
    ->orderByDesc('t.id');
    }

    protected function getMailClass(): string
    {
        return InvMail::class;
    }

    protected function getDefaultIntereses(): array
    {
        return [
            ['text' => 'Trámita tu credencial de egresado', 'link' => 'https://www.pveaju.unam.mx/credencial/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/credencial.png'],
            ['text' => 'No te pierdas el periódico virtual Egresados UNAM ', 'link' => 'https://www.flipsnack.com/editorialpveu/54', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/periodico.png'],
            ['text' => 'Bolsa de trabajo UNAM', 'link' => 'https://but.unam.mx/siiabut/public/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/entrevista.png'],
            ['text' => 'Apoyanos en el ranking internacional! encuesta de empleabilidad verde', 'link' => 'https://encuestas.pveaju.unam.mx/encuesta_verde/inicio/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/emp_verde.png'],
        ];
    }
}
