@extends('mails.base_mail', [
    'encabezado' => 'Reporte Semanal',
    'remitente' => 'Reportes Automatizados Seguimiento a Egresados UNAM',
    'header_image' => 'header_pos.png',
    'footer_image' => 'footer_pos.png',
    'intereses' => $payload['extra_items'] ?? []
])

@section('content')
    {{-- Estilos específicos para el reporte (conviven con los de base_mail) --}}
    <style>
        /* Contenedor general del reporte */
        .report-container {
            max-width: 560px;
            margin: 0 auto;
            padding: 8px 0;
        }

        /* Títulos y período */
        .report-title {
            color: #015190;
            font-size: 20px;
            text-align: center;
            margin: 10px 0 4px;
        }
        .report-period {
            text-align: center;
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 20px;
        }

        /* Tarjetas (cards) */
        .report-cards {
            text-align: center;
            margin-bottom: 25px;
        }
        .report-card {
            display: inline-block;
            background: #f4f7fa;
            border-radius: 8px;
            padding: 10px 12px;
            min-width: 90px;
            margin: 4px 6px;
            text-align: center;
            vertical-align: top;
        }
        .report-card-number {
            font-size: 26px;
            font-weight: bold;
            color: #2c3e50;
            line-height: 1.2;
        }
        .report-card-label {
            font-size: 12px;
            color: #7f8c8d;
        }
        .report-card-blue .report-card-number { color: #2980b9; }
        .report-card-green .report-card-number { color: #27ae60; }
        .report-card-orange .report-card-number { color: #e67e22; }

        /* Tabla de datos */
        .report-table-wrap {
            overflow-x: auto;
            margin: 15px 0 25px;
        }
        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .report-table th {
            background: #173d83;
            color: #ffffff;
            padding: 8px 6px;
            text-align: center;
        }
        .report-table td {
            border: 1px solid #ddd;
            padding: 6px 4px;
            text-align: center;
        }
        .report-table tr:nth-child(even) td {
            background: #f9f9f9;
        }
        .report-table .footer-row td {
            background: #173d83;
            color: #fff;
            font-weight: bold;
        }

        /* Gráfico de barras horizontal */
        .chart-container {
            margin: 20px 0 10px;
        }
        .chart-title {
            text-align: center;
            font-size: 16px;
            color: #015190;
            margin-bottom: 12px;
        }
        .chart-bar-row {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
            font-size: 12px;
        }
        .chart-label {
            width: 140px;
            text-align: right;
            padding-right: 8px;
            flex-shrink: 0;
            color: #333;
        }
        .chart-bar-track {
            flex: 1;
            background: #e9ecef;
            height: 20px;
            border-radius: 4px;
            overflow: hidden;
        }
        .chart-bar-fill {
            height: 100%;
            background: #2980b9;
            border-radius: 4px;
            width: 0%;
        }
        .chart-value {
            width: 32px;
            text-align: center;
            font-weight: bold;
            margin-left: 4px;
            color: #2c3e50;
        }

        /* Enlaces de acción */
        .report-links {
            text-align: center;
            margin: 20px 0 10px;
        }
        .report-links a {
            display: inline-block;
            background: #015190;
            color: #ffffff;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 4px 2px;
            font-size: 13px;
        }
        .report-links a:hover {
            background: #013a6b;
        }
        .report-footer-note {
            text-align: center;
            color: #999;
            font-size: 11px;
            margin-top: 30px;
        }

        /* Ajustes responsivos para móvil */
        @media only screen and (max-width: 480px) {
            .report-card {
                min-width: 70px;
                padding: 8px 6px;
                margin: 3px 2px;
            }
            .report-card-number {
                font-size: 20px;
            }
            .report-table th,
            .report-table td {
                padding: 4px 3px;
                font-size: 11px;
            }
            .chart-label {
                width: 100px;
                font-size: 11px;
            }
            .chart-bar-track {
                height: 16px;
            }
            .report-links a {
                padding: 10px 14px;
                font-size: 12px;
                display: block;
                margin: 6px 0;
            }
        }
    </style>

    {{-- CONTENIDO DEL REPORTE --}}
    <div class="report-container">
        <h2 class="report-title">{{ $payload['title'] ?? 'Reporte Semanal' }}</h2>
        <p class="report-period">del {{ $payload['start'] }} al {{ $payload['end'] }}</p>

        {{-- Tarjetas --}}
        <div class="report-cards">
            <span class="report-card report-card-blue">
                <div class="report-card-number">{{ $payload['totalGeneral'] }}</div>
                <div class="report-card-label">Total encuestas</div>
            </span>
            <span class="report-card report-card-green">
                <div class="report-card-number">{{ $payload['totalTelefonicas'] }}</div>
                <div class="report-card-label">Telefónicas</div>
            </span>
            <span class="report-card report-card-orange">
                <div class="report-card-number">{{ $payload['totalInternet'] }}</div>
                <div class="report-card-label">Internet</div>
            </span>
        </div>

        {{-- Tabla --}}
        <div class="report-table-wrap">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Generación</th>
                        <th>Telefónicas</th>
                        <th>Internet</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payload['rows'] as $row)
                        <tr>
                            <td>{{ $row['generacion'] }}</td>
                            <td>{{ $row['telefonicas'] }}</td>
                            <td>{{ $row['internet'] }}</td>
                            <td>{{ $row['total'] }}</td>
                        </tr>
                    @endforeach
                    <tr class="footer-row">
                        <td><strong>Totales</strong></td>
                        <td>{{ $payload['totalTelefonicas'] }}</td>
                        <td>{{ $payload['totalInternet'] }}</td>
                        <td>{{ $payload['totalGeneral'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Gráfico de barras --}}
        @php
            $maxTotal = max(array_column($payload['rows'], 'total'));
            $maxTotal = $maxTotal > 0 ? $maxTotal : 1;
        @endphp
        <div class="chart-container">
            <div class="chart-title">Distribución por tipo de encuesta</div>
            @foreach($payload['rows'] as $row)
                @php $width = round(($row['total'] / $maxTotal) * 100, 1); @endphp
                <div class="chart-bar-row">
                    <span class="chart-label">{{ $row['generacion'] }}</span>
                    <div class="chart-bar-track">
                        <div class="chart-bar-fill" style="width: {{ $width }}%;"></div>
                    </div>
                    <span class="chart-value">{{ $row['total'] }}</span>
                </div>
            @endforeach
        </div>

        {{-- Botones de acción --}}
        <div class="report-links">
            <a href="http://encuestas.pve.unam.local/stats" style="display:inline-block; background:#015190; color:#fff; padding:12px 20px; text-decoration:none; border-radius:6px; font-weight:bold;">Ver dashboard</a>
        </div>
        <div style="text-align:center; margin:10px 0;">
            <a href="http://encuestas.pve.unam.local/muestras22/index/0" style="color:#015190; font-size:13px;">👉 Revisa avance muestras 2022</a><br>
            <a href="http://encuestas.pve.unam.local/muestras18/planteles" style="color:#015190; font-size:13px;">👉 Revisa avance muestras 2018</a><br>
            <a href="http://encuestas.pve.unam.local/muestra_posgrado/programas" style="color:#015190; font-size:13px;">👉 Revisa avance muestras posgrado</a>
        </div>

        <div class="report-footer-note">
            Reporte generado automáticamente por {{ config('app.name') }}
        </div>
    </div>
@endsection