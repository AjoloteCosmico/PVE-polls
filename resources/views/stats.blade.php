@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div>
        <h1>Bienvenid@!!  {{Auth::user()->name }} {{Auth::user()->emojis }}</h1>
        <div>-----------------------------------------
            <br><br><br> 
            <a href="{{ route('report','reporte_individual')}}"  > 
                <button class="boton-azul">
                    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Reporte Individual 2019
                </button>
            </a>
            <a href="{{ route('report','correos_inconclusas')}}" > 
                <button class="boton-azul">
                    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Correos par encuestas inconclusas
                </button>
            </a>
            <a href="{{ route('report','reporte_individual_act2016')}}">
                <button class="boton-azul">
                    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Reporte Individual 2016
                </button>
            </a>
            <br> <br> 
            <a href="{{ route('report','correos_contestadas_2016')}}">
                <button class="boton-azul" >
                    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Correos para encuestas completas 2016
                </button>
            </a>
            <a href="{{ route('report','correos_contestadas22')}}">
                <button class="boton-azul" >
                    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Correos para encuestas completas 2022
                </button>
            </a>
            <br> <br>
             <a href="{{ route('report','base16')}}">
                <button class="boton-azul" >
                    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; ENCUESTAS 2016 BASE (al dia de hoy)
                </button>
            </a>
           
             <a href="{{ route('report','base22')}}">
                <button class="boton-azul" >
                    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; ENCUESTAS 2022 BASE (al dia de hoy)
                </button>
            </a>
            
        </div>
    </div>
    <br>
    <div>
    <div class="row"> 
        <div class="col">
            <div class="cuadro-amarillo">
                <h3> Total encuestas 2022:  {{$total22}}</h3>
                <h3> por internet: {{$Internet}} </h3>
            </div>
        </div>
        <div class="col">
            <div class="cuadro-amarillo">
                <h3> Total encuestas 2016:   {{$total16}} </h3>
                <h3> por internet: {{$Internet16}} </h3>
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-12 col-md-6 mb-4">
        <div class="card card-outline card-warning p-3"> <!-- Usamos las clases nativas de tarjetas de AdminLTE -->
            <div class="chart-wrapper-fixed">
                <x-chart-js 
                    id="pie22" 
                    type="doughnut" 
                    title="Avance del estudio seg 2022" 
                    :labels="['Realizadas Internet','Realizadas telef','No realizadas']" 
                    :data="[$Internet,$telefonicas, $requeridas-$Internet-$telefonicas]" 
                    :colors="['#002b7a', 'rgba(52, 152, 219, 0.7)', '#ba800d']"
                />
            </div>
        </div>
    </div>
     <div class="col-12 col-md-6 mb-4">
        <div class="card card-outline card-warning p-3"> <!-- Usamos las clases nativas de tarjetas de AdminLTE -->
            <div class="chart-wrapper-fixed">
                <x-chart-js 
                    id="pie16" 
                    type="doughnut" 
                    title="Avance del estudio act 2016" 
                    :labels="['Realizadas Internet','Realizadas telef','No realizadas']" 
                    :data="[$Internet16,$telefonicas16, $requeridas16-$Internet16-$telefonicas16]" 
                    :colors="['#002b7a', 'rgba(52, 152, 219, 0.7)', '#ba800d']"
                />
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 mb-4">
        <div class="card card-outline card-warning p-3"> <!-- Usamos las clases nativas de tarjetas de AdminLTE -->
            <div class="chart-wrapper-fixed">
                <x-chart-js 
                    id="name22" 
                    type="bar" 
                    title="Cuestionarios por encuestador 2022" 
                    :labels="$chartName22['labels']" 
                    :data="$chartName22['data']" 
                />
            </div>
        </div>
    </div>
    
     <div class="col-12 col-md-6 mb-4">
        <div class="card card-outline card-warning p-3"> <!-- Usamos las clases nativas de tarjetas de AdminLTE -->
            <div class="chart-wrapper-fixed">
                <x-chart-js 
                    id="stackedEnc" 
                    :labels="$stackedEnc['labels']" 
                    :data="$stackedEnc['datasets']" 
                    type="bar" 
                    title="Encuestadores por periodo"
                    :stacked="true"
                />
            </div>
        </div>
        </div>
        <div class="col-12 col-md-6 mb-4">
        <div class="card card-outline card-warning p-3"> <!-- Usamos las clases nativas de tarjetas de AdminLTE -->
            <div class="chart-wrapper-fixed">
                <x-chart-js 
                    id="weeklyAll" 
                    :labels="$chartWeeklyAll['labels']" 
                    :data="$chartWeeklyAll['datasets']" 
                    type="line" 
                    title="Encuestas semanales por estudio"
                    :stacked="false"
                />
            </div>
        </div>
    </div>

   

</div>

@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

<style>
    /* Forzamos al contenedor a mantener dimensiones rígidas que no rompan el Flexbox de AdminLTE */
    .chart-wrapper-fixed {
        position: relative;
        display: block;
        width: 100% !important;
        height: 500px !important; /* Altura fija para que el canvas no se estire al infinito */
        overflow: hidden;         /* Evita que subelementos desborden el layout principal */
        box-sizing: border-box;
    }

    /* Aseguramos que el componente de Chart.js y su contenedor interno respeten el límite */
    .chart-container-js {
        position: relative;
        height: 100% !important;
        width: 100% !important;
    }

    /* Forzar al Canvas a no romper el bloque */
    .chart-wrapper-fixed canvas {
        display: block;
        width: 100% !important;
        height: 100% !important;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script>
  console.log('script jalando ¿?');
  $(document).ready(function() {
    $('#myTable').DataTable();
  });
</script>

@endpush