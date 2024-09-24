@extends('layouts.app')
@section('content')

<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
  <div style="padding:30px;">
    <h1 style="color:white"> DATOS DE CONTACTO PARA EL EGRESADO </h1>
    <h1 style="color:white">{{$Egresado->nombre}} {{$Egresado->paterno}} {{$Egresado->materno}}   </h1>
    <h1 style="color:white">{{$Egresado->cuenta}}   </h1>
    <h1 style="color:white">{{$Carrera}} {{$Plantel}}   </h1>
    <h2 style="color:white"> Muestra: {{$muestra}} </h2> 
  </div>
  <div class="row">
    <div class="col">
      <a href="{{route('muestras20.show',[$Egresado->carrera,$Egresado->plantel])}}">
        <button type="button" style="color:rgb({{Auth::user()->color}})" class="btn btn-success btn-lg">  
          <i class="fas fa-table"></i></i> Ir a muestra carrera
        </button>
      </a>
    </div>
    <div class="col"> 
      <a href="{{route('muestras20.show',[0,$Egresado->plantel])}}">
        <button type="button" style="color:rgb({{Auth::user()->color}})" class="btn btn-success btn-lg">
          <i class="fas fa-table"></i></i>Ir a muestra del plantel
        </button>
      </a>
    </div>
  </div>
  <div class="col-6 col-lg-12 table-responsive">
    <h1> TELEFONOS DEL EGRESADO </h1> 
    <div class="col-sm-12 text-right">
      <a href="{{ route('agregar_telefono',[$Egresado->cuenta,$Egresado->carrera, $muestra])}}">
        <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 2.3vw">
          <i class="fas fa-plus-circle"></i>&nbsp; Nuevo telefono 
        </button>
      </a>
    </div>
    <table class="table text-xl " style="table-layout:fixed;">
      <thead>
        <tr>
          <th>Num. Cuenta</th>
          <th style="width:30%; word-wrap: break-word">Telefono</th>
          <th> Descripcion</th>
          <th>Status</th>
          <th> </th>
        </tr>
      </thead>
      <tbody>
        @foreach($Telefonos as $t)
        <tr>
            <td>{{$t->cuenta}} </td>
            <td style="width:40%; word-wrap: break-word">{{$t->telefono}} </td>
            <td>{{$t->descripcion}} </td>
            <td>{{$t->description}} </td>
            <td> <a href="{{route('editar_telefono',[$t->id,$Egresado->carrera,$muestra])}}"> <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw"> <i class="fa fa-edit" aria-hidden="true"> </i> &nbsp; EDITAR </button></a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
    <h1> CORREOS DEL EGRESADO</h1>
    <div class="col-sm-12 text-right">
        <a href="{{ route('agregar_correo',[$Egresado->cuenta,$Egresado->carrera,$muestra])}}">
          <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.9vw;"> 
            <i class="fas fa-plus-circle"></i>&nbsp; Nuevo Correo </button>
        </a>
    </div>
    <table class="table text-xl " style="table-layout:fixed;">
      <thead>
        <tr>
          <th>Num. Cuenta</th>
          <th style="width:30%; word-wrap: break-word">Correo</th>
          <th>status</th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($Correos as $c)
        <tr>
          <td>{{$c->cuenta}} </td>
          <td style="width:40%; word-wrap: break-word">{{$c->correo}} </td>
          <td>{{$c->status}} </td>
          <td>
            <a href="{{route('editar_correo',[$c->id,$Egresado->carrera,$muestra])}}"> 
              <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw"> 
                <i class="fa fa-edit" aria-hidden="true"> </i> &nbsp; EDITAR 
              </button>
            </a>
          </td>
          <td>
            <a href="{{route('enviar_encuesta',[$c->id,$Egresado->id])}}"> <!-- Definir ruta para selección y envio de encuesta -->
              <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw; align:center;"> 
                <i class="fas fa-file" aria-hidden="true"> </i> &nbsp; ENVIAR ENCUESTA <br>{{$muestra}} POR CORREO
              </button>
            </a>
          </td>
          <td>
            <a href="{{route('comenzar_encuesta_2020',[$c->id,$Egresado->cuenta,$Egresado->carrera])}}"> 
              <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw"> 
                <i class="fas fa-paper-plane" aria-hidden="true"> </i> &nbsp; ENVIAR AVISO <br> Y ENCUESTAR
              </button>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
@stop

@push('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script>
  console.log('script jalando ¿?');
  $(document).ready(function() {
    $('#myTable').DataTable();
} );
 </script>
@endpush