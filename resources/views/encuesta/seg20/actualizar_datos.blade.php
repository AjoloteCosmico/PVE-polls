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
    <h2 style="color:white"> Muestra: {{$Egresado->anio_egreso}} </h2> 
  </div>
  <div class="row">
    <div class="col">
        @if($gen==2020)
        <a href="{{route('muestras20.show',[$Egresado->carrera,$Egresado->plantel])}}">
            <button type="button"  class="boton-oscuro">
                <i class="fas fa-table"></i> Ir a muestra Carrera 
            </button>
        </a>
        @endif
        @if($gen==2022)
        <a href="{{route('muestras22.show22',[$Egresado->carrera,$Egresado->plantel])}}">
            <button type="button"  class="boton-oscuro">
                <i class="fas fa-table"></i> Ir a muestra Carrera 
            </button>
        </a>
        @endif
        @if($gen==2016)
        <a href="{{route('muestras16.show',[$Egresado->carrera,$Egresado->plantel])}}">
            <button type="button"  class="boton-oscuro">
                <i class="fas fa-table"></i> Ir a muestra Carrera 
            </button>
        </a>
        @endif
    </div>
    <div class="col">
    @if($gen==2020)
      <a href="{{route('llamar',[2020, $Egresado->cuenta,$Egresado->carrera])}}">
        <button class="boton-volver">
            <i class="fa-sharp fa-solid fa-rotate-left"></i>
          </button>
      </a>
    @endif
    @if($gen==2022)
      <a href="{{route('llamar',[2022, $Egresado->cuenta,$Egresado->carrera])}}">
        <button class="boton-volver">
            <i class="fa-sharp fa-solid fa-rotate-left"></i>
          </button>
      </a>
    @endif
    @if($gen==2016)
      <a href="{{route('llamar',[2016, $Egresado->cuenta,$Egresado->carrera])}}">
        <button class="boton-volver">
            <i class="fa-sharp fa-solid fa-rotate-left"></i>
          </button>
      </a>
    @endif
    </div>
    <div class="col"> 
    </div>
  </div>
  <div class="col-6 col-lg-12 table-responsive">  
  
  @if($Egresado->status==8)
    
          <a href="{{route('completar_encuesta',$Egresado->id)}}">
              <button type="button"  class="boton-dorado">
                  <i class="fas fa-pen fa-xl"></i> COMPLETAR ENCUESTA INCONCLUSA
              </button>
          </a>
    @endif
    <h1> TELEFONOS DEL EGRESADO </h1> 
    <div class="col-sm-12 text-right">
      <a href="{{ route('agregar_telefono',[$Egresado->cuenta,$Egresado->carrera, $gen, $TelefonoEnLlamada->id])}}">
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
            <td style="width:40%; word-wrap: break-word"> {{$t->telefono}} </td>
            <td>{{$t->descripcion}} </td>
            <td>{{$t->description}} </td>
            <td> <a href="{{route('editar_telefono',[$t->id,$Egresado->carrera,$gen,$TelefonoEnLlamada->id])}}"> <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw"> <i class="fa fa-edit" aria-hidden="true"> </i> &nbsp; EDITAR </button></a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
    <h1> CORREOS DEL EGRESADO</h1>
    <div class="col-sm-12 text-right">
        <a href="{{ route('agregar_correo',[$Egresado->cuenta,$Egresado->carrera,$gen,$TelefonoEnLlamada->id])}}">
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
          @if($gen==2016)
          <td>
            <a href="{{route('editar_correo',[$c->id,$Egresado->carrera,2016,$TelefonoEnLlamada->id])}}"> 
              <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw"> 
                <i class="fa fa-edit" aria-hidden="true"> </i> &nbsp; EDITAR 
              </button>
            </a> 
          </td>
          @endif
          @if($gen==2022)
          <td>
            <a href="{{route('editar_correo',[$c->id,$Egresado->carrera,2022,$TelefonoEnLlamada->id])}}"> 
              <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw"> 
                <i class="fa fa-edit" aria-hidden="true"> </i> &nbsp; EDITAR 
              </button>
            </a>
          </td>
          @endif
          @if($gen==2020)
          <td>
          
            <a href="{{route('editar_correo',[$c->id,$Egresado->carrera,2020,$TelefonoEnLlamada->id])}}"> 
              <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw"> 
                <i class="fa fa-edit" aria-hidden="true"> </i> &nbsp; EDITAR 
              </button>
            </a>
          </td>
          @endif
          @if($gen==2020)
              <td>
                <a href="{{route('enviar_encuesta',[$c->id,$Egresado->id,$TelefonoEnLlamada->id])}}"> <!-- Definir ruta para selección y envio de encuesta -->
                  <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw; align:center;"> 
                    <i class="fas fa-file" aria-hidden="true"> </i> &nbsp; ENVIAR ENCUESTA <br>{{$gen}} POR CORREO
                  </button>
                </a>
              </td>
              <td>
                <a href="{{route('comenzar_encuesta_2020',[$c->id,$Egresado->cuenta,$Egresado->carrera])}}"> 
                  <button class="boton-oscuro" > 
                    <i class="fas fa-paper-plane" aria-hidden="true"> </i> &nbsp; ENVIAR AVISO <br> Y ENCUESTAR
                  </button>
                </a>
              </td>
            @endif
            @if($gen==2022)
              <td>
                <a href="{{route('enviar_encuesta',[$c->id,$Egresado->id,$TelefonoEnLlamada->id])}}"> <!-- Definir ruta para selección y envio de encuesta -->
                  <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw; align:center;"> 
                    <i class="fas fa-file" aria-hidden="true"> </i> &nbsp; ENVIAR ENCUESTA <br>{{$gen}} POR CORREO
                  </button>
                </a>
              </td>
              <td>
                <a href="{{route('comenzar_encuesta_2022',[$c->id,$Egresado->cuenta,$Egresado->carrera])}}"> 
                  <button class="boton-oscuro" > 
                    <i class="fas fa-paper-plane" aria-hidden="true"> </i> &nbsp; ENVIAR AVISO <br> Y ENCUESTAR
                  </button>
                </a>
              </td>
            @endif
            @if($gen==2016)
            <td>
                <a href="{{route('enviar_encuesta',[$c->id,$Egresado->id,$TelefonoEnLlamada->id])}}"> <!-- Definir ruta para selección y envio de encuesta -->
                  <button class="boton-oscuro" > 
                    <i class="fas fa-file" aria-hidden="true"> </i> &nbsp; ENVIAR ENCUESTA <br>{{$gen}} POR CORREO
                  </button>
                </a>
              </td>
              <td>
                <a href="{{route('comenzar_encuesta_2016',[$c->id,$Egresado->cuenta,$Egresado->carrera])}}"> 
                  <button class="boton-oscuro" > 
                    <i class="fas fa-paper-plane" aria-hidden="true"> </i> &nbsp; ENVIAR AVISO <br> Y ENCUESTAR
                  </button>
                </a>
              </td>
            @endif
          
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