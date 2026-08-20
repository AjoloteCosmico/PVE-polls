@extends('layouts.app')
@section('content')
@include('components.create_email', [
                        'cuenta'        => $Egresado->cuenta,
                        'respuestasKey'         => 0,
                        'typeStudy'  => 'act',
                        'carrera' => $Egresado->carrera,
                        'EgName'=> $Egresado->nombre.' '.$Egresado->paterno.' '.$Egresado->materno
                    ])
@include('components.edit_email', [
                        'cuenta'        => $Egresado->cuenta,
                        'respuestasKey'         => 0,
                        'typeStudy'  => 'act',
                        'carrera' => $Egresado->carrera,
                        'EgName'=> $Egresado->nombre.' '.$Egresado->paterno.' '.$Egresado->materno
                    ])
@include('components.create_phone', [
                        'cuenta'        => $Egresado->cuenta,
                        'respuestasKey'         => 0,
                        'typeStudy'  => 'act',
                        'carrera' => $Egresado->carrera,
                   ])
@include('components.edit_phone', [
                        'cuenta'        => $Egresado->cuenta,
                        'respuestasKey'         => 0,
                        'typeStudy'  => 'act',
                        'carrera' => $Egresado->carrera,
                   ])
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
        @if($gen==2018)
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
    @if($gen==2018)
      <a href="{{route('llamar',[2018, $Egresado->cuenta,$Egresado->carrera])}}">
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
  
 
    <h1> TELEFONOS DEL EGRESADO </h1> 
    <div class="col-sm-12 text-right">
        <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 2.3vw" data-toggle="modal" data-target="#phoneModal">
          <i class="fas fa-plus-circle"></i>&nbsp; Nuevo telefono 
        </button>
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
            <td> <button class="btn edit-phone-btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw" data-telefono_id="{{$t->id}}" data-telefono="{{ $t->telefono }}" data-description="{{ $t->descripcion }}" >
               <i class="fa fa-edit" aria-hidden="true"> </i> &nbsp; EDITAR </button></td>  
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
    <h1> CORREOS DEL EGRESADO</h1>
    <div class="col-sm-12 text-right">
        
          <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.9vw;" data-toggle="modal" data-target="#emailModal"> 
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
          @if($gen==2018)
          <td>
            <button type="button" class="btn edit-email-btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw" data-id="{{$c->id}}" data-correo="{{ $c->correo }}" data-description="{{ $c->description }}" data-status="{{$c->status}}"> 
                <i class="fa fa-edit" aria-hidden="true"> </i> &nbsp; EDITAR 
              </button>
          </td>
          @endif
          @if($gen==2022)
          <td>
            <button type="button" class="btn edit-email-btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw" data-id="{{$c->id}}" data-correo="{{ $c->correo }}" data-description="{{ $c->description }}" data-status="{{$c->status}}"> 
                <i class="fa fa-edit" aria-hidden="true"> </i> &nbsp; EDITAR 
              </button>
          </td>
          @endif
          @if($gen==2020)
          <td>
            <button type="button" class="btn edit-email-btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw" data-id="{{$c->id}}" data-correo="{{ $c->correo }}" data-description="{{ $c->description }}" data-status="{{$c->status}}"> 
                <i class="fa fa-edit" aria-hidden="true"> </i> &nbsp; EDITAR 
              </button>
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
              @can('aplicar_encuesta_seguimiento')
              <td>
                <a href="{{route('comenzar_encuesta_2020',[$c->id,$Egresado->cuenta,$Egresado->carrera])}}"> 
                  <button class="boton-oscuro" > 
                    <i class="fas fa-paper-plane" aria-hidden="true"> </i> &nbsp; ENVIAR AVISO <br> Y ENCUESTAR
                  </button>
                </a>
              </td>
              @endcan
            @endif
            @if($gen==2022)
              <td>
                <a href="{{route('enviar_encuesta',[$c->id,$Egresado->id,$TelefonoEnLlamada->id])}}"> <!-- Definir ruta para selección y envio de encuesta -->
                  <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw; align:center;"> 
                    <i class="fas fa-file" aria-hidden="true"> </i> &nbsp; ENVIAR ENCUESTA <br>{{$gen}} POR CORREO
                  </button>
                </a>
              </td>
              @can('aplicar_encuesta_seguimiento')
              <td>
                <a href="{{route('comenzar_encuesta_2022',[$c->id,$Egresado->cuenta,$Egresado->carrera])}}"> 
                  <button class="boton-oscuro" > 
                    <i class="fas fa-paper-plane" aria-hidden="true"> </i> &nbsp; ENVIAR AVISO <br> Y ENCUESTAR
                  </button>
                </a>
              </td>
              @endcan
            @endif
            @if($gen==2018)
            <td>
                <a href="{{route('enviar_encuesta',[$c->id,$Egresado->id,$TelefonoEnLlamada->id])}}"> <!-- Definir ruta para selección y envio de encuesta -->
                  <button class="boton-oscuro" > 
                    <i class="fas fa-file" aria-hidden="true"> </i> &nbsp; ENVIAR ENCUESTA <br>{{$gen}} POR CORREO
                  </button>
                </a>
              </td>
              @can('aplicar_encuesta_actualizacion')
              <td>
                <a href="{{route('comenzar_encuesta_2018',[$c->id,$Egresado->cuenta,$Egresado->carrera])}}"> 
                  <button class="boton-oscuro" > 
                    <i class="fas fa-paper-plane" aria-hidden="true"> </i> &nbsp; ENVIAR AVISO <br> Y ENCUESTAR
                  </button>
                </a>
              </td>
              @endcan
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
  console.log('script funcionando');
  $(document).ready(function() {
    $('#myTable').DataTable();
} );
function escapeHtml(text) {
    return String(text)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

$(document).on('phoneAdded', function(event, data) {
   
    location.reload();
});

$(document).on('click', '.edit-email-btn', function() {
    let btn = $(this);
    editEmail(btn.data('id'), btn.data('correo'), btn.data('description'));
});

$(document).on('click', '.edit-phone-btn', function() {
    let btn = $(this);
    editPhone(btn.data('telefono_id'), btn.data('telefono'), btn.data('description'));
});

$(document).on('emailAdded', function(event, data) {
    //Actualizar la pagina mejor 
    location.reload();
});
$(document).on('emailUpdated', function(event, data) {

    location.reload();
});
$(document).on('phoneUpdated', function(event, data) {
    location.reload();
});


</script>
 
@endpush 