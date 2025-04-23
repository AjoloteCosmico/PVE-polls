@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div class="padding div">
        <h1>Hola  {{Auth::user()->name }} {{Auth::user()->emojis }}</h1>
        <h1> ¿Deseas buscar un numero de cuenta?</h1>
    </div>
    <center >
    
    @if($egresados->count() > 0) 
    <h1>Egresados</h1>
    <h3>¿Deseas hacer una nueva encuesta? </h3>
    <div class="col-6 col-sm-12 table-responsive">
        <table class="table  text-xl" id="myTable">
            <thead>
                <tr>
                <th>Egresado</th>
                <th>Cuenta</th>
                <th>Generación</th>
                <th>Carrera</th>
                <th>Plantel</th>
                <th>Status</th>
                <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($egresados as $eg)
                <tr>
                    <td>{{$eg->nombre}}  {{  $eg->paterno}}  {{  $eg->materno }}   </td>
                    <td> {{$eg->cuenta}} </td>
                    <td> {{$eg->anio_egreso}} </td>
                    <td>{{$eg->nombre_carrera}}</td>     
                    <td>{{$eg->nombre_plantel}}</td>
                    <td style="background-color: {{$eg->color_codigo}};">{{$eg->estado}}</td>
                    <td>
                        @if($eg->muestra==3 && in_array($eg->status,[null,0,3,4,5,6,7,8,9,6,11,12], false))
                        <a href="{{route('llamar',['2020',$eg->cuenta,$eg->carrera])}}">
                            <button class="boton-oscuro">
                                <i class="fa fa-phone" aria-hidden="true"> </i> &nbsp; LLAMAR 
                            </button>
                        </a>
                        <a href="{{route('invitacion19',$eg->id)}}">
                            <button class="boton-oscuro">
                                <i class="fa fa-mail" aria-hidden="true"> </i> &nbsp; Enviar por correo
                            </button>
                        </a>
                        @endif
                        @if($eg->act_suvery==1 && in_array($eg->status,[null,0,3,4,5,6,7,8,9,6,11,12], false))
                        <a href="{{route('llamar',['2016',$eg->cuenta,$eg->carrera])}}">
                            <button class="boton-oscuro">
                                <i class="fa fa-phone" aria-hidden="true"> </i> &nbsp; LLAMAR 
                            </button>
                        </a>
                        <a href="{{route('invitacion19',$eg->id)}}">
                            <button class="boton-oscuro">
                                <i class="fa fa-mail" aria-hidden="true"> </i> &nbsp; Enviar por correo
                            </button>
                        </a>
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
    } );
</script>
@endpush