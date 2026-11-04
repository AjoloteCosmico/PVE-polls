<?php

namespace App\Services\Reports;

use App\Models\Egresado;
use App\Models\EgresadoEspecialidad;
use App\Models\EgresadoPosgrado;
use App\Models\respuestas16;
use App\Models\respuestas20;
use App\Models\respuestasEspecialidad;
use App\Models\respuestasPosgrado;
use App\Models\RespuestasContinua;
use Illuminate\Support\Facades\DB;

/**
 * Servicio de reportes de encuestas.
 *
 * Objetivo final:
 * - Centralizar todas las consultas y agregaciones relacionadas con encuestas.
 * - Producir un payload estándar para:
 *   * resumen general por estudio
 *   * conteo por tipo (internet / telefónica / no contestada)
 *   * conteo por encuestador
 *   * conteo por fecha
 *   * avance por estudio
 *   * comparación por generación y por año
 *
 * Alcance inicial:
 * - seguimiento / 2022
 * - actualización / 2016
 * - posgrado
 * - especialidad
 * - sondeo
 */
class SurveyReportService
{
    protected function normalizeStudy(string $study): string
    {
        $value = strtolower(trim($study));

        $aliases = [
            'seguimiento' => 'seguimiento',
            'licenciatura' => 'seguimiento',
            'seg' => 'seguimiento',
            '2022' => 'seguimiento',
            'actualizacion' => 'actualizacion',
            'actualización' => 'actualizacion',
            'act' => 'actualizacion',
            '2016' => 'actualizacion',
            'posgrado' => 'posgrado',
            'especialidad' => 'especialidad',
            'sondeo' => 'sondeo',
            'general' => 'general',
        ];

        return $aliases[$value] ?? 'seguimiento';
    }

    protected function studyTitle(string $study): string
    {
        return match ($study) {
            'seguimiento' => 'Seguimiento Licenciatura',
            'actualizacion' => 'Actualización',
            'posgrado' => 'Posgrado',
            'especialidad' => 'Especialidad',
            'sondeo' => 'Sondeo',
            default => 'General',
        };
    }

    protected function baseQueryForStudy(string $study)
    {
        return match ($study) {
            'seguimiento' => respuestas20::query()
                ->where(function ($query) {
                    $query->where('completed', 1)->orWhere('completed', '1');
                })
                ->whereNull('aplica2')
                ->where('gen_dgae', 2022),
            'actualizacion' => respuestas16::query()
                ->where(function ($query) {
                    $query->where('completed', 1)->orWhere('completed', '1');
                })
                ->whereIn('cuenta', Egresado::whereIn('act_suvery', [1, 2])->pluck('cuenta')),
            'posgrado' => respuestasPosgrado::query()
                ->where(function ($query) {
                    $query->where('completed', 1)->orWhere('completed', '1');
                })
                ->whereIn('anio_egreso', [2019, 2020, 2021, 2022]),
            'especialidad' => respuestasEspecialidad::query()
                ->where(function ($query) {
                    $query->where('completed', 1)->orWhere('completed', '1');
                }),
            'sondeo' => RespuestasContinua::query(),
            default => respuestas20::query()
                ->where(function ($query) {
                    $query->where('completed', 1)->orWhere('completed', '1');
                })
                ->whereNull('aplica2')
                ->where('gen_dgae', 2022),
        };
    }

    protected function requiredTotalForStudy(string $study): int
    {
        return match ($study) {
            'seguimiento' => (int) DB::table('muestras')->where('estudio_id', 5)->sum('requeridas_5'),
            'actualizacion' => (int) Egresado::where('act_suvery', 1)->count(),
            'posgrado' => (int) EgresadoPosgrado::whereIn('anio_egreso', [2019, 2020, 2021, 2022])->count(),
            'especialidad' => (int) EgresadoEspecialidad::count(),
            'sondeo' => 0,
            default => 0,
        };
    }

    protected function dateColumnForStudy(string $study): string
    {
        return match ($study) {
            'sondeo' => 'updated_at',
            default => 'fec_capt',
        };
    }

    public function summary(array $filters = []): array
    {
        $study = $this->normalizeStudy($filters['study'] ?? 'seguimiento');
        $allowed = ['seguimiento', 'actualizacion', 'posgrado', 'especialidad', 'sondeo', 'general'];

        if (!in_array($study, $allowed, true)) {
            $study = 'seguimiento';
        }

        $query = $this->baseQueryForStudy($study);
        $general = (clone $query)->count();
        $internet = (clone $query)->whereIn('aplica', ['111', '104', '20', '105'])->count();
        $telefonicas = max(0, $general - $internet);
        $requeridas = max(0, $this->requiredTotalForStudy($study));
        $faltantes = max(0, $requeridas - $general);

        $summaryRow = [
            'label' => $this->studyTitle($study),
            'study' => $study,
            'telefonicas' => $telefonicas,
            'internet' => $internet,
            'total' => $general,
            'requeridas' => $requeridas,
            'faltantes' => $faltantes,
        ];

        return [
            'title' => $this->studyTitle($study),
            'study' => $study,
            'period' => ['start' => null, 'end' => null],
            'totals' => [
                'general' => $general,
                'telefonicas' => $telefonicas,
                'internet' => $internet,
                'requeridas' => $requeridas,
                'faltantes' => $faltantes,
            ],
            'summary' => [$summaryRow],
            'by_user' => $this->byUser(['study' => $study]),
            'by_date' => $this->byDate(['study' => $study]),
            'chart' => [
                'type' => 'doughnut',
                'labels' => ['Internet', 'Telefónicas', 'Faltantes'],
                'datasets' => [[
                    'label' => $this->studyTitle($study),
                    'data' => [$internet, $telefonicas, $faltantes],
                    'backgroundColor' => ['#002b7a', '#3498db', '#ba800d'],
                    'borderColor' => ['#002b7a', '#3498db', '#ba800d'],
                ]],
            ],
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
            'recados_by_user' => [],
        ];
    }

    public function byUser(array $filters = []): array
    {
        $study = $this->normalizeStudy($filters['study'] ?? 'seguimiento');
        $allowed = ['seguimiento', 'actualizacion', 'posgrado', 'especialidad', 'sondeo'];

        if (!in_array($study, $allowed, true)) {
            return [];
        }

        $query = $this->baseQueryForStudy($study);

        return $query
            ->join('users', function ($join) {
                $join->on(DB::raw('CAST(aplica AS VARCHAR)'), '=', 'users.clave');
            })
            ->select('users.name as user', 'users.clave as clave', DB::raw('count(*) as total'))
            ->groupBy('users.name', 'users.clave')
            ->orderByDesc('total')
            ->get()
            ->map(function ($row) {
                return [
                    'user' => $row->user ?? $row->clave,
                    'clave' => $row->clave,
                    'total' => (int) $row->total,
                    'telefonicas' => (int) $row->total,
                ];
            })
            ->toArray();
    }

    public function byDate(array $filters = []): array
    {
        $study = $this->normalizeStudy($filters['study'] ?? 'seguimiento');
        $allowed = ['seguimiento', 'actualizacion', 'posgrado', 'especialidad', 'sondeo'];

        if (!in_array($study, $allowed, true)) {
            return [];
        }

        $query = $this->baseQueryForStudy($study);
        $dateColumn = $this->dateColumnForStudy($study);

        return $query
            ->select(DB::raw("date({$dateColumn}) as date"), DB::raw('count(*) as total'))
            ->groupBy(DB::raw("date({$dateColumn})"))
            ->orderBy('date')
            ->get()
            ->map(function ($row) {
                return [
                    'date' => $row->date,
                    'total' => (int) $row->total,
                ];
            })
            ->toArray();
    }

    public function byStudy(array $filters = []): array
    {
        return [$this->summary($filters)];
    }

    public function chartPayload(array $filters = []): array
    {
        return $this->summary($filters)['chart'] ?? [];
    }
}
