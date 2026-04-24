@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div class="padding div">
        <h1>Hola  {{Auth::user()->name }} {{Auth::user()->emojis }}</h1>
       
    </div>


    <center >
    {{-- SECCIÓN: EGRESADOS (LICENCIATURA)--}}
    
    <h1>Egresados</h1>
    <br>
    <h3>¿Deseas hacer una nueva encuesta? </h3>
    <br>
    <div class="col-6 col-sm-12 table-responsive">

        <livewire:egresados-table :nc="$nc" :nombre_completo="$nombre_completo" />

        
    </div>
    

    <hr> {{-- Separador visual --}}


    {{-- SECCIÓN: EGRESADOS (POSGRADO)--}}
    @if($egresados_posgrado->count())
    <h1>Egresados de Posgrado</h1>
    <br>
    <h3>¿Deseas hacer una nueva encuesta? </h3>
    <br>
    <div class="col-6 col-sm-12 table-responsive">
        <table class="table  text-xl" id="myTablePosgrado">
            <thead>
                <tr>
                <th>Egresado</th>
                <th>Cuenta</th>
                <th>Generación</th>
                <th>Programa</th>
                <th>Plan</th>
                <th>Status</th>
                <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($egresados_posgrado as $egp)
                <tr>
                    <td>{{$egp->nombre}}  {{  $egp->paterno}}  {{  $egp->materno }}   </td>
                    <td> {{$egp->cuenta}} </td>
                    <td> {{$egp->anio_egreso}} </td>
                    <td>{{$egp->programa}}</td>     
                    <td>{{$egp->plan}}</td>
                    <td style="background-color: {{$egp->color_codigo}};">{{$egp->estado}}<br>
                    <td>
                        @if(in_array($egp->status,[null,0,3,4,5,6,7,8,9,10,6,11,12], false))
                        <a href="{{route('llamar_posgrado',[$egp->cuenta,$egp->plan,$egp->programa])}}">
                            @can('ver_muestra_posgrado')
                            <button class="boton-oscuro">
                                <i class="fa fa-phone" aria-hidden="true"> </i> &nbsp; LLAMAR 
                            </button>
                            @endcan
                        </a>
                        <br>
                            <small><strong>Fecha:</strong> {{ $egp->fecha_posgrado ?? 'N/A' }}</small><br>
                            <small><strong>Aplicador:</strong> {{ $egp->aplicador_posgrado ?? 'N/A' }}</small>
                            <br>
                            <!-- checa si el egresado tiene una encuesta inconclusa y lo muestra -->
                          
                        @endif
                        <!-- si esta encuestado por llamada o internet solo muestra datos del encuestador -->
                        @if(in_array($egp->status,[1,2], false))
                            <small><strong>Fecha:</strong> {{ $egp->fechaFinal_posgrado ?? 'N/A' }}</small><br>
                            <small><strong>Aplicador:</strong> {{ $egp->aplicador_posgrado ?? 'N/A' }}</small>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @else
        No hay egresados que mostrar

    @endif
   </center>
    </div>
@endsection

@push('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        $('#myTablePosgrado').DataTable();
    } );
</script>
@endpush