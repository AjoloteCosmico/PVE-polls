{{--
    Vista de la pestaña General.

    Objetivo final:
    - Mostrar el resumen general del dashboard sin lógica de negocio.
    - Consumir solo datos ya calculados por SurveyReportService.
    - Servir como plantilla base para reportes tipo dashboard y como referencia para correo.

    Contrato documentado:
    - Se espera recibir $reportGeneral con la estructura estándar del contrato.
    - Debe incluir: title, period, totals, summary, chart, table.
    - Si el dato no existe, se debe mostrar una tarjeta o mensaje vacío en lugar de romper la vista.
--}}

@php
    $report = $reportGeneral ?? ['title' => 'General', 'period' => ['start' => null, 'end' => null], 'totals' => [], 'summary' => [], 'chart' => [], 'table' => []];
    $totals = $report['totals'] ?? [];
    $chart = $report['chart'] ?? [];
    $summary = $report['summary'] ?? [];
@endphp

<style>
    .stats-general-shell {
        background: linear-gradient(135deg, #ffffff 0%, #eef6ff 32%, #e8edf5 100%);
        border: 1px solid rgba(148, 163, 184, 0.30);
        border-radius: 18px;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .stats-general-header {
        background: linear-gradient(90deg, rgba(2, 79, 150, 0.95), rgba(13, 102, 164, 0.85));
        color: #fff;
        padding: 20px 24px;
        border-bottom: 1px solid rgba(255,255,255,0.15);
    }

    .stats-general-header h3 {
        margin: 0;
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    .stats-general-body {
        padding: 22px 24px 28px;
    }

    .stats-general-kpis {
        display: grid;
        grid-template-columns: repeat(4, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stats-kpi {
        background: rgba(255,255,255,0.72);
        border: 1px solid rgba(148, 163, 184, 0.35);
        border-radius: 16px;
        padding: 18px 16px;
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.5);
    }

    .stats-kpi .label {
        display: block;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #53657c;
        margin-bottom: 8px;
        font-weight: 700;
    }

    .stats-kpi .value {
        display: block;
        font-size: 28px;
        line-height: 1.1;
        font-weight: 800;
        color: #122a43;
    }

    .stats-kpi.primary .value { color: #0a4d8a; }
    .stats-kpi.success .value { color: #147d3b; }
    .stats-kpi.warning .value { color: #b86d00; }
    .stats-kpi.info .value { color: #0a6c87; }

    .stats-panel-grid {
        display: grid;
        grid-template-columns: 1.05fr 1.45fr;
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
        border-radius: 12px;
        overflow: hidden;
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

    .stats-pill {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        background: #edf8ff;
        color: #0d5e9d;
    }

    .stats-pill.warning {
        background: #fff4df;
        color: #b86d00;
    }

    .stats-pill.success {
        background: #eafaf1;
        color: #147d3b;
    }

    @media (max-width: 991px) {
        .stats-general-kpis,
        .stats-panel-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="stats-general-shell">
    <div class="stats-general-header">
        <h3>{{ $report['title'] ?? 'General' }}</h3>
        <div style="margin-top:8px; font-size:13px; opacity:0.9;">
            @if(!empty($report['period']['start']) || !empty($report['period']['end']))
                {{ $report['period']['start'] ?? '' }} - {{ $report['period']['end'] ?? '' }}
            @else
                Periodo no definido
            @endif
        </div>
    </div>

    <div class="stats-general-body">
        <div class="stats-general-kpis">
            <div class="stats-kpi primary">
                <span class="label">Realizadas</span>
                <span class="value">{{ $totals['general'] ?? 0 }}</span>
            </div>
            <div class="stats-kpi success">
                <span class="label">Internet</span>
                <span class="value">{{ $totals['internet'] ?? 0 }}</span>
            </div>
            <div class="stats-kpi info">
                <span class="label">Telefónicas</span>
                <span class="value">{{ $totals['telefonicas'] ?? 0 }}</span>
            </div>
            <div class="stats-kpi warning">
                <span class="label">Faltantes</span>
                <span class="value">{{ $totals['faltantes'] ?? 0 }}</span>
            </div>
        </div>

        <div class="stats-panel-grid">
            <div class="stats-panel">
                <h5>Avance del estudio</h5>
                @php
                    $chartData = $chart['datasets'][0]['data'] ?? [0, 0, 0];
                    $chartColors = $chart['datasets'][0]['backgroundColor'] ?? ['#0a4d8a', '#4ea3d8', '#d8922b'];
                    $chartLabels = $chart['labels'] ?? ['Internet', 'Telefónicas', 'Faltantes'];
                @endphp

                <div style="max-width: 260px; margin: 0 auto;">
                    <x-chart-js
                        id="general-summary-donut"
                        type="doughnut"
                        title="Avance del seguimiento 2022"
                        :labels="$chartLabels"
                        :data="$chartData"
                        :colors="$chartColors"
                    />
                </div>
            </div>

            <div class="stats-panel">
                <h5>Resumen por estudio</h5>
                <div class="stats-table-wrap">
                    <table class="stats-table">
                        <thead>
                            <tr>
                                <th>Estudio</th>
                                <th>Realizadas</th>
                                <th>Requeridas</th>
                                <th>Faltantes</th>
                                <th>Avance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($summary as $row)
                                @php
                                    $realizadas = $row['total'] ?? $totals['general'] ?? 0;
                                    $requeridas = $row['requeridas'] ?? $totals['requeridas'] ?? 0;
                                    $faltantes = $row['faltantes'] ?? max(0, $requeridas - $realizadas);
                                    $avance = $requeridas > 0 ? round(($realizadas / $requeridas) * 100, 1) : 0;
                                @endphp
                                <tr>
                                    <td>{{ $row['label'] ?? $row['study'] ?? 'General' }}</td>
                                    <td>{{ $realizadas }}</td>
                                    <td>{{ $requeridas }}</td>
                                    <td>{{ $faltantes }}</td>
                                    <td>
                                        <span class="stats-pill {{ $avance >= 70 ? 'success' : 'warning' }}">
                                            {{ $avance }}%
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
