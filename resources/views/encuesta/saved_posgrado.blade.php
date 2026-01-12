@extends('layouts.app')

@section('content')
<div class="container-fluid"  >
    <div class="padding div" style="padding:30px;">
    <h1>Hola  {{Auth::user()->name }} </h1>   
    </div>
    <center>
    <br><br>
       <h1> Encuesta guardada con exito </h1>
<a href="{{route('encuestas.json',$Encuesta->cuenta)}}">
       <button class="btn "  type="button"  style="background-color:{{Auth::user()->color}} ; color:white; display: flex;">
    <i class="fas fa-download fa-lg"></i> &nbsp; DESCARGAR JSON
  </button></a>
<br>

<a href="{{route('posgrado.show',['SEARCH',$Encuesta->registro])}}">
       <button class="btn "  type="button"  style="background-color:{{Auth::user()->color}} ; color:white; display: flex;">
    <i class="fas fa-eye fa-lg"></i> &nbsp; Revisar
  </button></a>
  <br>
<a href="{{route('muestrasposgrado.show', [$Egresado->programa,$Encuesta->plan])}}"><button type="button"style="background-color:{{Auth::user()->color}} ; color:white; display: flex;">  <i class="fas fa-arrow-left"></i> Regresar a la muestra</button></a>
   </center>
    </div>
@endsection

@push('js')
<script>
    setTimeout(
  function() {
    window.location.replace("{{route('encuestas.json',$Encuesta->cuenta)}}");
  }, 10);
  </script>
@endpush