{{--
    Vista de la pestaña Seguimiento.

    Objetivo final:
    - Mostrar la actividad de seguimiento por encuestador, recado y avance del estudio.
    - Consumir un payload generado por ActivityReportService y/o SurveyReportService.

    Contrato documentado:
    - Se espera recibir $reportSeguimiento.
    - Debe incluir: title, period, totals, by_user, by_type, chart, table.
    - Se visualizará como tabla y como gráfico de comparación encuestas vs recados.
--}}

@php
    $report = $reportSeguimiento ?? ['title' => 'Seguimiento', 'period' => ['start' => null, 'end' => null], 'totals' => [], 'summary' => [], 'by_user' => [], 'chart' => [], 'table' => [], 'recados_by_user' => []];
    $totals = $report['totals'] ?? [];
    $byUser = $report['by_user'] ?? [];
    $chart = $report['chart'] ?? [];
    $recadosByUser = $report['recados_by_user'] ?? [];

    $comparisonLabels = [];
    $comparisonEncuestas = [];
    $comparisonRecados = [];

    foreach ($byUser as $row) {
        $userName = $row['user'] ?? $row['usuario'] ?? '-';
        $clave = $row['clave'] ?? null;
        $telefonicas = $row['telefonicas'] ?? $row['total'] ?? 0;

        $comparisonLabels[] = $userName;
        $comparisonEncuestas[] = (int) $telefonicas;

        $recadoTotal = 0;
        if (!empty($recadosByUser)) {
            foreach ($recadosByUser as $recadoRow) {
                $matchUser = $recadoRow['user'] ?? $recadoRow['usuario'] ?? null;
                $matchClave = $recadoRow['clave'] ?? $recadoRow['user_id'] ?? null;

                if (($matchClave !== null && $clave !== null && (string) $matchClave === (string) $clave)
                    || ($matchUser !== null && $matchUser === $userName)) {
                    $recadoTotal = (int) ($recadoRow['total'] ?? $recadoRow['recados'] ?? 0);
                    break;
                }
            }
        }

        $comparisonRecados[] = $recadoTotal;
    }
@endphp

<style>
    .stats-seguimiento-shell {
        background: linear-gradient(135deg, #ffffff 0%, #eef6ff 32%, #ebf2f8 100%);
        border: 1px solid rgba(148, 163, 184, 0.30);
        border-radius: 18px;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .stats-seguimiento-header {
        background: linear-gradient(90deg, rgba(2, 79, 150, 0.95), rgba(13, 102, 164, 0.85));
        color: #fff;
        padding: 20px 24px;
        border-bottom: 1px solid rgba(255,255,255,0.15);
    }

    .stats-seguimiento-header h3 {
        margin: 0;
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    .stats-seguimiento-body {
        padding: 22px 24px 28px;
    }

    .stats-kpis {
        display: grid;
        grid-template-columns: repeat(4, minmax(170px, 1fr));
        gap: 16px;
        margin-bottom: 22px;
    }

    .stats-kpi-card {
        background: rgba(255,255,255,0.72);
        border: 1px solid rgba(148, 163, 184, 0.35);
        border-radius: 16px;
        padding: 18px 16px;
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.5);
    }

    .stats-kpi-card .label {
        display: block;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #53657c;
        margin-bottom: 8px;
        font-weight: 700;
    }

    .stats-kpi-card .value {
        display: block;
        font-size: 28px;
        line-height: 1.1;
        font-weight: 800;
        color: #122a43;
    }

    .stats-kpi-card.primary .value { color: #0a4d8a; }
    .stats-kpi-card.success .value { color: #147d3b; }
    .stats-kpi-card.warning .value { color: #b86d00; }
    .stats-kpi-card.info .value { color: #0a6c87; }

    .stats-seguimiento-grid,
    .stats-comparison-grid {
        display: grid;
        grid-template-columns: 1.1fr 1.5fr;
        gap: 20px;
        align-items: stretch;
    }

    .stats-panel {
        background: rgba(255,255,255,0.88);
        border: 1px solid rgba(148, 163, 184, 0.3);
        border-radius: 16px;
        padding: 18px;
    }

    .stats-panel h5 {
        margin: 0 0 14px;
        color: #12365e;
        font-weight: 700;
        font-size: 16px;
    }

    .stats-table-wrap {
        overflow-x: auto;
    }

    .stats-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        background: #fff;
    }

    .stats-table thead th {
        background: linear-gradient(90deg, #0e497d, #254f7a);
        color: #fff;
        padding: 10px 12px;
        text-align: left;
        font-weight: 700;
    }

    .stats-table tbody td {
        padding: 10px 12px;
        border-bottom: 1px solid #e5ecf5;
        color: #24364a;
    }

    .stats-table tbody tr:nth-child(even) td {
        background: rgba(240, 246, 252, 0.6);
    }

    .stats-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        background: #edf8ff;
        color: #0d5e9d;
    }

    .stats-badge.warning {
        background: #fff4df;
        color: #b86d00;
    }

    .stats-badge.success {
        background: #eafaf1;
        color: #147d3b;
    }

    @media (max-width: 991px) {
        .stats-kpis,
        .stats-seguimiento-grid,
        .stats-comparison-grid {
            grid-template-columns: 1fr;
        }
    }
</style> 

<div class="stats-seguimiento-shell">
    <div class="stats-seguimiento-header">
        <h3>{{ $report['title'] ?? 'Seguimiento' }}</h3>
        <div style="margin-top:8px; font-size:13px; opacity:0.9;">
            @if(!empty($report['period']['start']) || !empty($report['period']['end']))
                {{ $report['period']['start'] ?? '' }} - {{ $report['period']['end'] ?? '' }}
            @else
                Periodo no definido
            @endif
        </div> 
    </div>

    <div class="stats-seguimiento-body">
        <div class="stats-kpis">
            <div class="stats-kpi-card primary">
                <span class="label">Realizadas</span>
                <span class="value">{{ $totals['general'] ?? 0 }}</span>
            </div>
            <div class="stats-kpi-card success">
                <span class="label">Internet</span>
                <span class="value">{{ $totals['internet'] ?? 0 }}</span>
            </div>
            <div class="stats-kpi-card info">
                <span class="label">Telefónicas</span>
                <span class="value">{{ $totals['telefonicas'] ?? 0 }}</span>
            </div>
            <div class="stats-kpi-card warning">
                <span class="label">Faltantes</span>
                <span class="value">{{ $totals['faltantes'] ?? 0 }}</span>
            </div>
        </div>

        <div class="stats-seguimiento-grid">
            <div class="stats-panel">
                <h5>Avance del seguimiento</h5>
                @php
                    $chartData = $chart['datasets'][0]['data'] ?? [0, 0, 0];
                    $chartColors = $chart['datasets'][0]['backgroundColor'] ?? ['#0a4d8a', '#4ea3d8', '#d8922b'];
                    $chartLabels = $chart['labels'] ?? ['Internet', 'Telefónicas', 'Faltantes'];
                @endphp

                <div style="max-width: 260px; margin: 0 auto;">
                    <x-chart-js
                        id="seguimiento-summary-donut"
                        type="doughnut"
                        title="Avance del seguimiento licenciatura"
                        :labels="$chartLabels"
                        :data="$chartData"
                        :colors="$chartColors"
                    />
                </div>
            </div>

            <div class="stats-panel">
                <h5>Conteo por aplicador / usuario</h5>
                <div class="stats-table-wrap">
                    <table class="stats-table">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Clave</th>
                                <th>Encuestas</th>
                                <th>Participación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($byUser))
                                @php
                                    $maxUserTotal = !empty($byUser) ? max(array_map(fn($row) => (int) ($row['telefonicas'] ?? $row['total'] ?? 0), $byUser)) : 0;
                                @endphp
                                @foreach($byUser as $row)
                                    @php
                                        $total = (int) ($row['telefonicas'] ?? $row['total'] ?? 0);
                                        $participacion = $maxUserTotal > 0 ? round(($total / $maxUserTotal) * 100, 1) : 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $row['user'] ?? $row['usuario'] ?? '-' }}</td>
                                        <td>{{ $row['clave'] ?? '-' }}</td>
                                        <td>{{ $total }}</td>
                                        <td>
                                            <span class="stats-badge {{ $participacion >= 70 ? 'success' : 'warning' }}">
                                                {{ $participacion }}%
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">Sin datos por aplicador.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="stats-comparison-grid" style="margin-top: 22px;">
            <div class="stats-panel">
                <h5>Encuestas telefónicas vs recados seg</h5>
                @if(!empty($comparisonLabels))
                    <x-chart-js
                        id="seguimiento-comparison"
                        type="bar"
                        title="Encuestas telefónicas por usuario vs recados seg"
                        :labels="$comparisonLabels"
                        :data="[
                            ['label' => 'Encuestas telefónicas', 'data' => $comparisonEncuestas, 'backgroundColor' => '#0a4d8a'],
                            ['label' => 'Recados seg', 'data' => $comparisonRecados, 'backgroundColor' => '#f0a500']
                        ]"
                        :stacked="true"
                    />
                @else
                    <p class="text-muted">Sin datos para comparar encuestas telefónicas y recados.</p>
                @endif
            </div>

            <div class="stats-panel">
                <h5>Recados tipo seg por usuario</h5>
                <div class="stats-table-wrap">
                    <table class="stats-table">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Clave / user_id</th>
                                <th>Recados</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($recadosByUser))
                                @foreach($recadosByUser as $row)
                                    <tr>
                                        <td>{{ $row['user'] ?? $row['usuario'] ?? '-' }}</td>
                                        <td>{{ $row['clave'] ?? $row['user_id'] ?? '-' }}</td>
                                        <td>{{ $row['total'] ?? $row['recados'] ?? 0 }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">Sin recados tipo seg.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
