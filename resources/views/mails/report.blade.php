@extends('mails.base_mail', [
    'encabezado' => 'Reporte Semanal',
    'remitente' => 'Reportes Automatizados Seguimiento a Egresados UNAM',
    'header_image' => 'header_pos.png',
    'footer_image' => 'footer_pos.png',
    'intereses' => $payload['extra_items'] // Array dinámico de 0 a 10
])

@section('content')
    <p> &nbsp;&nbsp;Buen día <span style="color: #B7812C; font-weight: 700;">{{ $payload['nombre'] }}</span>, te compartimos un resumen de la semana</p>
 
  <div class="container">
        <h1>{{ $data['title'] }}</h1>
        <p class="periodo">del {{ $data['start'] }} al {{ $data['end'] }}</p>

        <!-- Tarjetas -->
        <div class="cards">
            <div class="card card-blue">
                <div class="card-number">{{ $data['totalGeneral'] }}</div>
                <div class="card-label">Total encuestas</div>
            </div>
            <div class="card card-green">
                <div class="card-number">{{ $data['totalTelefonicas'] }}</div>
                <div class="card-label">Telefónicas</div>
            </div>
            <div class="card card-orange">
                <div class="card-number">{{ $data['totalInternet'] }}</div>
                <div class="card-label">Internet</div>
            </div>
        </div>

        <!-- Tabla -->
        <table>
            <thead>
                <tr>
                    <th>Generación</th>
                    <th>Telefónicas</th>
                    <th>Internet</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['rows'] as $row)
                    <tr>
                        <td>{{ $row['generacion'] }}</td>
                        <td>{{ $row['telefonicas'] }}</td>
                        <td>{{ $row['internet'] }}</td>
                        <td>{{ $row['total'] }}</td>
                    </tr>
                @endforeach
                <tr class="footer-row">
                    <td><strong>Totales</strong></td>
                    <td>{{ $data['totalTelefonicas'] }}</td>
                    <td>{{ $data['totalInternet'] }}</td>
                    <td>{{ $data['totalGeneral'] }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Gráfico de barras (totales por tipo) -->
        <div class="chart-container">
            <h3 style="text-align:center;">Distribución por tipo de encuesta</h3>
            @php
                $maxTotal = max(array_column($data['rows'], 'total'));
                $maxTotal = $maxTotal > 0 ? $maxTotal : 1;
            @endphp
            @foreach($data['rows'] as $row)
                @php $width = ($row['total'] / $maxTotal) * 100; @endphp
                <div class="chart-bar">
                    <span class="chart-label">{{ $row['generacion'] }}</span>
                    <div class="chart-bar-bg">
                        <div class="chart-bar-fill" style="width: {{ $width }}%;"></div>
                    </div>
                    <span class="chart-value">{{ $row['total'] }}</span>
                </div>
            @endforeach
        </div>

        <p style="margin-top: 40px; color: #999; font-size: 12px; text-align:center;">
            Reporte generado automáticamente por {{ config('app.name') }}
        </p>
    </div>   
    <div style="text-align: center; margin: 30px 0 24px 0;">
        <a href="http://encuestas.pve.unam.local/stats" style="display: inline-block; background-color: #015190; color: #ffffff; padding: 15px 28px; text-decoration: none; border-radius: 8px; font-weight: bold; text-align: center; min-width: 250px; box-shadow: 0 4px 10px rgba(1, 81, 144, 0.22);">
            Ver dashboard (se requiere conexion ethernet)
        </a>
    </div>
    <p> <strong> Encuestas realizadas: </strong> por tipo de estudio </p>
    <table></table>
    <br>

    <a href="http://encuestas.pve.unam.local/muestras22/index/0">👉🏾 Revisa el avance de muestras 2022 </a>
    <a href="http://encuestas.pve.unam.local/muestras18/planteles">👉🏾 Revisa el avance de muestras 2018 </a>
    <a href="http://encuestas.pve.unam.local/muestra_posgrado/programas">👉🏾 Revisa el avance de muestras posgrado </a>
    
@endsection