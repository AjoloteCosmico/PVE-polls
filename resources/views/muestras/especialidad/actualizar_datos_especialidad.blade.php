@extends('layouts.app')
@section('content')
@include('components.create_phone', [
                        'cuenta'        => $EgresadoEsp->cuenta,
                        'respuestasKey'         => 0,
                        'typeStudy'  => 'esp',
                        'carrera' => $EgresadoEsp->carrera,
                   ])
@include('components.create_email', [
                        'cuenta'        => $EgresadoEsp->cuenta,
                        'respuestasKey'         => 0,
                        'typeStudy'  => 'esp',
                        'carrera' => $EgresadoEsp->carrera,
                        'EgName'=> $EgresadoEsp->nombre.' '.$EgresadoEsp->paterno.' '.$EgresadoEsp->materno
                    ])
@include('components.edit_phone', [
                        'cuenta'        => $EgresadoEsp->cuenta,
                        'respuestasKey'         => 0,
                        'typeStudy'  => 'esp',
                        'carrera' => $EgresadoEsp->carrera,
                   ])
@include('components.edit_email', [
                        'cuenta'        => $EgresadoEsp->cuenta,
                        'respuestasKey'         => 0,
                        'typeStudy'  => 'esp',
                        'carrera' => $EgresadoEsp->carrera,
                        'EgName'=> $EgresadoEsp->nombre.' '.$EgresadoEsp->paterno.' '.$EgresadoEsp->materno
                    ])
<div class="numero_telefonico">
  Estas en una llamada con el numero: {{$TelefonoEnLlamada->telefono}}
</div>
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
  <div >
    <h1 style="color:white"> DATOS DE CONTACTO PARA EL EGRESADO </h1>
    <h1 style="color:white">{{$EgresadoEsp->nombre}} {{$EgresadoEsp->paterno}} {{$EgresadoEsp->materno}}   </h1>
    <h1 style="color:white">{{$EgresadoEsp->cuenta}}   </h1>
    <h1 style="color:white">ESP. EN DERECHO {{$especialidad}}  </h1>
  </div>
  <div class="row">
    <div class="col">
        <a href="{{route('muestras.especialidad.show',[$EgresadoEsp->especialidad])}}">
            <button type="button"  class="boton-oscuro">
                <i class="fas fa-table"></i> Ir a muestra Programa 
            </button>
        </a>
    </div>
    <div class="col">
      <a href="{{route('llamar_especialidad',[$EgresadoEsp->cuenta,$EgresadoEsp->especialidad])}}">
        <button class="boton-volver">
            <i class="fa-sharp fa-solid fa-rotate-left"></i>
          </button>
      </a>
    </div>
    <div class="col"> 
    </div>
  </div>
  <div class="col-6 col-lg-12 table-responsive">    
  
  @if($EgresadoEsp->status==8||$EgresadoEsp->status==10)
  
      @if($EncuestaInconclusa )
          <a href="{{route('especialidad.show',['SEARCH',$EncuestaInconclusa->registro])}}">
              <button type="button"  class="boton-dorado">
                  <i class="fas fa-pen fa-xl"></i> COMPLETAR ENCUESTA INCONCLUSA
              </button>
          </a>
          @endif
    @endif
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
      <tbody id="telefonos-tbody">
        @foreach($Telefonos as $t)
        <tr>
            <td>{{$t->cuenta}} </td>
            <td style="width:40%; word-wrap: break-word"> {{$t->telefono}} </td>
            <td>{{$t->descripcion}} </td>
            <td>{{$t->status_description}} </td>
            <td> <button class="btn edit-phone-btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw" data-telefono_id="{{$t->id}}" data-telefono="{{ $t->telefono }}" data-description="{{ $t->descripcion }}" >
               <i class="fa fa-edit" aria-hidden="true"> </i> &nbsp; EDITAR </button></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
    <h1> CORREOS DEL EGRESADO</h1>
    <div class="col-sm-12 text-right">
    
          <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.9vw;" data-toggle="modal" data-target="#emailModal"> 
            <i class="fas fa-plus-circle"></i>&nbsp; Nuevo Correo </button>
   
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
      <tbody id="correos-tbody">
        @foreach($Correos as $c)
        <tr data-id="{{$c->id}}">
          <td>{{$c->cuenta}} </td>
          <td style="width:40%; word-wrap: break-word">{{$c->correo}} </td>
          <td>{{$c->description}} </td>
          <td>
            
              <button type="button" class="btn edit-email-btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw" data-id="{{$c->id}}" data-correo="{{ $c->correo }}" data-description="{{ $c->description }}" data-status="{{$c->status}}"> 
                <i class="fa fa-edit" aria-hidden="true"> </i> &nbsp; EDITAR 
              </button>

          </td>
            <td>
                <a href="{{route('enviar_encuesta',[$c->id,$EgresadoEsp->id,$TelefonoEnLlamada->id,'posgrado'])}}"> <!-- Definir ruta para selección y envio de encuesta -->
                  <button class="boton-oscuro" > 
                    <i class="fas fa-file" aria-hidden="true"> </i> &nbsp; ENVIAR ENCUESTA POR CORREO
                  </button>
                </a>
              </td>
              @can('aplicar_encuesta_posgrado')
              <td>
                <a href="{{route('comenzar_encuesta_especialidad',[$c->id,$EgresadoEsp->cuenta,$EgresadoEsp->especialidad])}}"> <!-- Definir ruta para selección y envio de encuesta -->
                  <button class="boton-oscuro" > 
                    <i class="fas fa-paper-plane" aria-hidden="true"> </i> &nbsp; ENVIAR AVISO <br> Y ENCUESTAR
                  </button>
                </a>
              </td>
              @endcan
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
    // let telefono = data.telefono;
    // let row = `
    //     <tr>
    //         <td>${telefono.cuenta}</td>
    //         <td style="width:40%; word-wrap: break-word">${escapeHtml(telefono.telefono)}</td>
    //         <td>${escapeHtml(telefono.descripcion)}</td>
    //         <td>${escapeHtml(data.status)}</td>
    //         <td> <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw"> <i class="fa fa-edit" aria-hidden="true"> </i> &nbsp; EDITAR </button></td>
    //     </tr>
    // `;
    // $('#telefonos-tbody').append(row);
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
    // let correo = data.correo;
    // let row = `
    //     <tr data-id="${correo.id}">
    //         <td>${escapeHtml(correo.cuenta)}</td>
    //         <td style="width:40%; word-wrap: break-word">${escapeHtml(correo.correo)}</td>
    //         <td>${escapeHtml(correo.description)}</td>
    //         <td>  <button type="button" class="btn edit-email-btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw" data-id="${escapeHtml(correo.id)}" data-correo="${escapeHtml(correo.correo)}" data-description="${escapeHtml(correo.description)}" data-status="${escapeHtml(correo.status || 13)}"> <i class="fa fa-edit" aria-hidden="true"> </i> &nbsp; EDITAR </button></td>
    //     </tr>
    // `;
    // $('#correos-tbody').append(row);

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