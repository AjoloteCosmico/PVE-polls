@extends('layouts.app')
@section('content')
<div class="numero_telefonico">
  Estas en una llamada con el numero: {{$TelefonoEnLlamada->telefono}}
</div>
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
  <div >
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
      <a href="{{route('llamar_20',[$Egresado->cuenta])}}">
        <button type="button" style="color:rgb({{Auth::user()->color}})" class="btn btn-success btn-lg">
          <i class="fas fa-arrow-left"></i>Regresar
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
      <a href="{{ route('agregar_telefono',[$Egresado->cuenta,$Egresado->carrera, $muestra, $TelefonoEnLlamada->id])}}">
        <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 2.3vw">
          <i class="fas fa-plus-circle"></i>&nbsp; Nuevo telefono 
        </button>
      </a>
    </div>
    <table class="table text-xl " style="table-layout:fixed;">
      <thead>
        <tr>
          <th>Num. cuenta</th>
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
            <td> <a href="{{route('editar_telefono',[$t->id,$Egresado->carrera,$muestra,$TelefonoEnLlamada->id])}}"> <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw"> <i class="fa fa-edit" aria-hidden="true"> </i> &nbsp; EDITAR </button></a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
    <h1> CORREOS DEL EGRESADO</h1>
    <div class="col-sm-12 text-right">
        <a href="{{ route('agregar_correo',[$Egresado->cuenta,$Egresado->carrera,$muestra,$TelefonoEnLlamada->id])}}">
          <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.9vw;"> 
            <i class="fas fa-plus-circle"></i>&nbsp; Nuevo Correo </button>
        </a>
    </div>
    <table class="table text-xl " style="table-layout:fixed;">
      <thead>
        <tr>
          <th>Num. cuenta</th>
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
          <td>{{$c->description}} </td>
          <td>
            <a href="{{route('editar_correo',[$c->id,$Egresado->carrera,$muestra,$TelefonoEnLlamada->id])}}"> 
              <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw"> 
                <i class="fa fa-edit" aria-hidden="true"> </i> &nbsp; EDITAR 
              </button>
            </a>
          </td>
          <td>
            <a href="{{route('enviar_encuesta',[$c->id,$Egresado->id,$TelefonoEnLlamada->id])}}"> <!-- Definir ruta para selección y envio de encuesta -->
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

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<style>
  /* Estilos del rectángulo */
  .numero_telefonico {
    position: fixed;          /* Posición fija en la pantalla */
    top: 50px;                /* Separación de la parte superior */
    z-index: 2;
    right: 30px;              /* Separación de la parte derecha */
    padding: 10px 20px;       /* Relleno interno */
    background-color: {{Auth::user()->color}};   /* Fondo oscuro */
    color: white;             /* Texto en blanco */
    border-radius: 8px;       /* Bordes redondeados */
    font-size: 1.5vw;          /* Tamaño del texto */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra */
  }
</style>
@endpush

@push('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script>
  console.log('script jalando ¿?');
  $(document).ready(function() {
    $('#myTable').DataTable();
} );
 </script>
@endpush