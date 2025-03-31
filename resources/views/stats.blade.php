@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div>
        <h1>Bienvenid@!!  {{Auth::user()->name }} {{Auth::user()->emojis }}</h1>
        <div>-----------------------------------------
            <br><br><br> 
            <a href="{{ route('report','reporte_individual')}}">
                <button class="boton-azul">
                    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Reporte Individual 2019
                </button>
            </a>
            <a href="{{ route('report','reporte_individual_act2014')}}">
                <button class="boton-azul">
                    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Reporte Individual 2014
                </button></a>
            <a href="{{ route('report','correos_inconclusas')}}">
                <button class="boton-azul" >
                    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Correos par encuestas inconclusas
                </button>
            </a>
            <a href="{{ route('report','correos_muestra_sin_contestar')}}">
                <button class="boton-azul" >
                    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Correos muestra sin contestar
                </button>
            </a>
            <a href="{{ route('report','correos_contestadas')}}">
                <button class="boton-azul" >
                    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Correos par encuestas completas
                </button></a>
            <a href="{{ route('report','base20')}}">
                <button class="boton-azul" >
                    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; ENCUESTAS 2020 BASE (al dia de hoy)
                </button>
            </a>
            <a href="{{ route('report','estado_muestra_2020')}}">
                <button class="boton-azul">
                    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Estado muestra 2020
                </button>
            </a>
        </div>
    </div>
    <br>
</div>
<div>
    <div class="row"> 
        <div class="col">
            <div class="cuadro-amarillo">
                <h3> Total encuestas 2020:  {{$total20}}</h3>
                <h3> por internet: {{$Internet}} </h3>
            </div>
        </div>
        <div class="col">
            <div class="cuadro-amarillo">
                <h3> Total encuestas 2016:   </h3>
                <h3> por internet: {{$Internet16}} </h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col cuadro-amarillo">
            {!! $aplica_chart->container() !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 cuadro-amarillo">
            {!! $chart->container() !!}
        </div>
        <div class="col-md-5 cuadro-amarillo">
            {!! $chart16->container() !!}
        </div>
    </div>
</div>

@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

@endpush

@push('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script>
 
  console.log('script jalando ¿?');
  $(document).ready(function() {
    $('#myTable').DataTable();
} );
 </script>

<script src="{{ $chart->cdn() }}"></script>
{!! $chart->script() !!}

<script src="{{ $chart16->cdn() }}"></script>
{!! $chart16->script() !!}

<script src="{{ $aplica_chart->cdn() }}"></script>
  
{!! $aplica_chart->script() !!}
 @endpush