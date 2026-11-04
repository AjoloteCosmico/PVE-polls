<?php

namespace App\Services\Reports;

use App\Models\Recado;
use App\Models\respuestas20;
use Illuminate\Support\Facades\DB;

/**
 * Servicio de reportes de actividad.
 *
 * Objetivo final:
 * - Centralizar todos los conteos derivados de `events`, `recados`, llamadas y actividad por usuario.
 * - Proveer una salida homogénea para encuestadores, seguimiento, actualización, posgrado, especialidad y sondeo.
 * - Permitir comparar actividad con resultados de encuestas en la misma estructura y estilo.
 *
 * Alcance inicial:
 * - recados por usuario y tipo
 * - eventos por usuario y tipo
 * - seguimiento por encuestador
 * - actualización/paso de fase por encuestador
 * - comparativa encuestas vs recados
 *
 * Contracto esperado:
 * ```php
 * [
 *     'title' => 'Actividad',
 *     'period' => ['start' => '2026-10-01', 'end' => '2026-10-31'],
 *     'totals' => ['recados' => 500, 'eventos' => 1200, 'encuestas' => 89],
 *     'by_user' => [
 *         ['user' => 'Ana', 'recados' => 50, 'eventos' => 80, 'encuestas' => 12],
 *     ],
 *     'by_type' => [
 *         ['type' => 'seg', 'total' => 150],
 *     ],
 *     'chart' => [...],
 *     'table' => [...],
 * ]
 * ```
 *
 * Reglas:
 * - La actividad debe aparecer en un formato que pueda comparar con encuestas y correos.
 * - El servicio debe devolver series ordenadas y categorizadas.
 * - Un usuario puede tener varios tipos de actividad; deben agregarse por `user` + `type`.
 */
class ActivityReportService
{
    protected function normalizeStudy(string $study): string
    {
        $value = strtolower(trim($study));

        $aliases = [
            'seguimiento' => 'seguimiento',
            'licenciatura' => 'seguimiento',
            'seg' => 'seguimiento',
            '2022' => 'seguimiento',
        ];

        return $aliases[$value] ?? 'seguimiento';
    }

    protected function baseSeguimientoQuery()
    {
        return respuestas20::query()
            ->where('completed', 1)
            ->whereNull('aplica2')
            ->where('gen_dgae', 2022);
    }

    /**
     * Devuelve actividad consolidada por usuario.
     *
     * @param array $filters
     * @return array
     */
    public function byUser(array $filters = []): array
    {
        $study = $this->normalizeStudy($filters['study'] ?? 'seguimiento');

        if ($study !== 'seguimiento') {
            return [];
        }

        $surveyRows = (clone $this->baseSeguimientoQuery())
            ->join('users', 'aplica', 'clave')
            ->select(
                'users.id as user_id',
                'users.name as user',
                'users.clave as clave',
                DB::raw('count(*) as total'),
                DB::raw("SUM(CASE WHEN aplica IN ('111','104','20','105') THEN 1 ELSE 0 END) AS internet"),
                DB::raw("SUM(CASE WHEN aplica NOT IN ('111','104','20','105') THEN 1 ELSE 0 END) AS telefonicas")
            )
            ->groupBy('users.id', 'users.name', 'users.clave')
            ->orderByDesc('total')
            ->get();

        return $surveyRows->map(function ($row) {
            return [
                'user' => $row->user ?? $row->clave,
                'user_id' => $row->user_id,
                'clave' => $row->clave,
                'total' => (int) ($row->total ?? 0),
                'internet' => (int) ($row->internet ?? 0),
                'telefonicas' => (int) ($row->telefonicas ?? ($row->total - ($row->internet ?? 0))),
            ];
        })->toArray();
    }

    /**
     * Devuelve actividad por tipo.
     *
     * @param array $filters
     * @return array
     */
    public function byType(array $filters = []): array
    {
        $study = $this->normalizeStudy($filters['study'] ?? 'seguimiento');

        if ($study !== 'seguimiento') {
            return [];
        }

        return Recado::query()
            ->select('type', DB::raw('count(*) as total'))
            ->where('type', 'seg')
            ->groupBy('type')
            ->get()
            ->map(function ($row) {
                return [
                    'type' => $row->type,
                    'total' => (int) $row->total,
                ];
            })
            ->toArray();
    }

    /**
     * Devuelve recados agrupados por usuario para la comparación con encuestas.
     */
    public function recadosByUser(array $filters = []): array
    {
        $study = $this->normalizeStudy($filters['study'] ?? 'seguimiento');

        if ($study !== 'seguimiento') {
            return [];
        }

        return Recado::query()
            ->join('users', 'users.id', 'recados.user_id')
            ->where('recados.type', 'seg')
            ->select(
                'users.id as user_id',
                'users.name as user',
                'users.clave as clave',
                DB::raw('count(*) as total')
            )
            ->groupBy('users.id', 'users.name', 'users.clave')
            ->orderByDesc('total')
            ->get()
            ->map(function ($row) {
                return [
                    'user' => $row->user ?? $row->clave,
                    'user_id' => $row->user_id,
                    'clave' => $row->clave,
                    'total' => (int) $row->total,
                ];
            })
            ->toArray();
    }

    /**
     * Devuelve resumen de actividad para un panel.
     *
     * @param array $filters
     * @return array
     */
    public function summary(array $filters = []): array
    {
        $study = $this->normalizeStudy($filters['study'] ?? 'seguimiento');

        if ($study !== 'seguimiento') {
            return [
                'title' => 'Seguimiento',
                'study' => $study,
                'period' => ['start' => null, 'end' => null],
                'totals' => [],
                'by_user' => [],
                'recados_by_user' => [],
                'chart' => [],
            ];
        }

        $surveyByUser = $this->byUser(['study' => $study]);
        $recadosByUser = $this->recadosByUser(['study' => $study]);
        $query = $this->baseSeguimientoQuery();

        $general = (clone $query)->count();
        $internet = (clone $query)->whereIn('aplica', ['111', '104', '20', '105'])->count();
        $telefonicas = $general - $internet;

        $requeridas = (int) DB::table('muestras')->where('estudio_id', 5)->sum('requeridas_5');
        $requeridas = max(0, $requeridas);
        $faltantes = max(0, $requeridas - $general);

        $chartData = [
            'type' => 'doughnut',
            'labels' => ['Internet', 'Telefónicas', 'Faltantes'],
            'datasets' => [[
                'label' => 'Seguimiento 2022',
                'data' => [$internet, $telefonicas, $faltantes],
                'backgroundColor' => ['#0a4d8a', '#4ea3d8', '#d8922b'],
                'borderColor' => ['#0a4d8a', '#4ea3d8', '#d8922b'],
            ]],
        ];

        return [
            'title' => 'Seguimiento Licenciatura',
            'study' => 'seguimiento',
            'period' => ['start' => null, 'end' => null],
            'totals' => [
                'general' => $general,
                'internet' => $internet,
                'telefonicas' => $telefonicas,
                'requeridas' => $requeridas,
                'faltantes' => $faltantes,
            ],
            'summary' => [[
                'label' => 'Seguimiento 2022',
                'study' => 'seguimiento',
                'telefonicas' => $telefonicas,
                'internet' => $internet,
                'total' => $general,
                'requeridas' => $requeridas,
                'faltantes' => $faltantes,
            ]],
            'by_user' => $surveyByUser,
            'recados_by_user' => $recadosByUser,
            'by_type' => $this->byType(['study' => $study]),
            'chart' => $chartData,
            'table' => [
                'headers' => ['Concepto', 'Valor'],
                'rows' => [
                    ['Total encuestas', $general],
                    ['Telefónicas', $telefonicas],
                    ['Internet', $internet],
                    ['Requeridas', $requeridas],
                    ['Faltantes', $faltantes],
                ],
            ],
        ];
    }
}
