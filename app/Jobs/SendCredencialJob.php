<?php

namespace App\Jobs;

use App\Mail\EncuestaCredencialMail;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class SendCredencialJob extends AbstractEgresadoMailJob
{
    protected function buildQuery(): Builder
    {
        return DB::table('credenciales_pagas')
            ->join('correos', function ($join) {
                $join->on(
                    DB::raw("CAST(NULLIF(SUBSTRING(BTRIM(CAST(correos.cuenta AS TEXT)) FROM '^[0-9]+'), '') AS BIGINT)"),
                    '=',
                    DB::raw("CAST(NULLIF(SUBSTRING(BTRIM(CAST(credenciales_pagas.exa_cuenta AS TEXT)) FROM '^[0-9]+'), '') AS BIGINT)")
                );
            })
            ->whereRaw("SUBSTRING(BTRIM(CAST(credenciales_pagas.exa_cuenta AS TEXT)) FROM '^[0-9]+') IS NOT NULL")
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('respuestas_credencial')
                    ->whereNotNull('cred1')
                    ->whereRaw("CAST(NULLIF(SUBSTRING(BTRIM(CAST(respuestas_credencial.cuenta AS TEXT)) FROM '^[0-9]+'), '') AS BIGINT) = CAST(NULLIF(SUBSTRING(BTRIM(CAST(credenciales_pagas.exa_cuenta AS TEXT)) FROM '^[0-9]+'), '') AS BIGINT)");
            })
            ->select(
                'credenciales_pagas.exa_cuenta',
                'correos.id as correo_id',
                'correos.correo',
                DB::raw("TRIM(CONCAT_WS(' ', credenciales_pagas.nombre, credenciales_pagas.primer_apellido, credenciales_pagas.segundo_apellido)) as nombre_completo"),
                DB::raw("CAST(NULLIF(SUBSTRING(BTRIM(CAST(credenciales_pagas.exa_cuenta AS TEXT)) FROM '^[0-9]+'), '') AS BIGINT) as cuenta")
            )
            ->distinct()
            ->orderByDesc(DB::raw("CAST(NULLIF(SUBSTRING(BTRIM(CAST(credenciales_pagas.exa_cuenta AS TEXT)) FROM '^[0-9]+'), '') AS BIGINT)"));
    }

    protected function getMailClass(): string
    {
        return EncuestaCredencialMail::class;
    }

    protected function getDefaultIntereses(): array
    {
        return [
            ['text' => 'Trámite de credencial de egresado', 'link' => 'https://www.pveaju.unam.mx/credencial/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/credencial.png'],
            ['text' => 'Bolsa de trabajo UNAM', 'link' => 'https://but.unam.mx/siiabut/public/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/entrevista.png'],
            ['text' => 'No te pierdas el periódico virtual Egresados UNAM', 'link' => 'https://www.flipsnack.com/editorialpveu/54', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/periodico.png'],
            ['text' => 'Apóyanos en la encuesta de empleabilidad verde', 'link' => 'https://encuestas.pveaju.unam.mx/encuesta_verde/inicio/', 'image' => 'https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/img/mail_sources/emp_verde.png'],
        ];
    }
}
