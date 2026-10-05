<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\PosMail;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;



class SendPosgradojob extends AbstractEgresadoMailJob
{

    protected function buildQuery(): Builder
    {

        $planes = [
            'MAESTRÍA EN INGENIERÍA EN EXPLORACIÓN Y EXPLOTACIÓN DE RECURSOS NATURALES',
            'MAESTRÍA EN CINE DOCUMENTAL',
            'DOCTORADO EN GEOGRAFÍA',
            'MAESTRÍA EN MÚSICA (COMPOSICIÓN MUSICAL)',
            'DOCTORADO EN CIENCIAS BIOMÉDICAS',
            'DOCTORADO EN INGENIERÍA CIVIL',
            'MAESTRÍA EN ECONOMÍA',
            'MAESTRÍA EN CIENCIA E INGENIERÍA DE LA COMPUTACIÓN',
            'DOCTORADO EN INGENIERÍA AMBIENTAL',
            'DOCTORADO EN INGENIERÍA QUÍMICA',
            'MAESTRÍA EN DOCENCIA PARA LA EDUCACIÓN MEDIA SUPERIOR (INGLÉS)',
            'MAESTRÍA EN DOCENCIA PARA LA EDUCACIÓN MEDIA SUPERIOR (PSICOLOGÍA)',
            'MAESTRÍA EN ARQUITECTURA',
            'MAESTRÍA EN CIENCIAS DE LA SALUD',
            'DOCTORADO EN CIENCIAS DE LA SALUD',
            'MAESTRÍA EN GEOGRAFÍA',
            'DOCTORADO EN CIENCIAS POLÍTICAS Y SOCIALES',
            'MAESTRÍA EN INGENIERÍA AMBIENTAL',
            'MAESTRÍA EN HISTORIA DEL ARTE',
            'MAESTRÍA EN CIENCIAS SOCIOMÉDICAS', 
            'MAESTRÍA EN PSICOLOGÍA',
            'MAESTRÍA EN CIENCIAS ODONTOLÓGICAS BÁSICAS',
            'MAESTRÍA EN ESTUDIOS POLÍTICOS Y SOCIALES',
            'MAESTRÍA EN MÚSICA (COGNICIÓN MUSICAL)',
            'DOCTORADO EN PEDAGOGÍA',
            'MAESTRÍA EN PEDAGOGÍA', 
            'MAESTRÍA EN INGENIERÍA CIVIL',
            'MAESTRÍA EN BIBLIOTECOLOGÍA Y ESTUDIOS DE LA INFORMACIÓN',
            'MAESTRÍA EN CIENCIAS DE LA TIERRA',
            'MAESTRÍA EN ANTROPOLOGÍA',
            'MAESTRÍA EN ESTUDIOS MESOAMERICANOS',
            'MAESTRÍA EN LINGÜÍSTICA APLICADA',
            'DOCTORADO EN URBANISMO',
            'MAESTRÍA EN GOBIERNO Y ASUNTOS PÚBLICOS',
            'MAESTRÍA EN CIENCIAS BIOQUÍMICAS',
        ];

        return DB::table('egresados_posgrado as pos')
            ->join('correos as c', 'pos.cuenta', '=', 'c.cuenta')
            ->leftJoin('respuestas_posgrado as rp', 'pos.cuenta', '=', 'rp.cuenta')
            ->whereNotNull('c.correo')
            ->whereNotNull('pos.cuenta')
            ->where('pos.cuenta', '!=', '')
            ->where(function ($query) {
                $query->whereNull('rp.completed')
                    ->orWhere('rp.completed', '!=', '1');
            })
            ->whereIn('pos.anio_egreso', [2019, 2020, 2021, 2022])
            ->where('c.fuente', '=', 'base original')
            ->whereIn('pos.plan', $planes)
            ->select(
                'c.correo',
                'c.id as correo_id',
                'pos.cuenta',
                DB::raw("CONCAT(pos.nombre, ' ', pos.paterno, ' ', pos.materno) AS nombre_completo"),
                'pos.programa as prog_acad'
            );
    }

    protected function getMailClass(): string
    {
        return PosMail::class;
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
