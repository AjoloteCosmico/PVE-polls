@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div class="padding div" style="padding:30px;">
    <h1 class="text-white-50">Hola  {{Auth::user()->name }} {{Auth::user()->emojis }}</h1>   
    </div>
    <center >
    <br><br>
       <h1> Encuesta guardada con exito </h1>
<a href="{{route('encuestas.json',$Encuesta->cuenta.$Encuesta->cuenta)}}">
       <button class="btn "  type="button"  style="background-color:{{Auth::user()->color}} ; color:white; display: flex;">
    <i class="fas fa-download fa-lg"></i> &nbsp; DESCARGAR JSON
  </button></a>
<br>
@if($Encuesta->NBR7==2014)
<a href="{{route('encuestas.show_14',$Encuesta->registro)}}">
       <button class="btn "  type="button"  style="background-color:{{Auth::user()->color}} ; color:white; display: flex;">
    <i class="fas fa-eye fa-lg"></i> &nbsp; Revisar
  </button></a>
  <br>
<a href="{{route('muestras14.show',[$Encuesta->carrera,$Encuesta->plantel])}}"><button type="button"style="background-color:{{Auth::user()->color}} ; color:white; display: flex;">  <i class="fas fa-arrow-left"></i> Regresar a la muestra</button></a>
  
@else
  <a href="{{route('edit_20',[$Encuesta->registro,'A'])}}">
       <button class="btn "  type="button"  style="background-color:{{Auth::user()->color}} ; color:white; display: flex;">
    <i class="fas fa-eye fa-lg"></i> &nbsp; Revisar
  </button></a>
  <br>
<a href="{{route('muestras20.show',[$Encuesta->nbr2,$Encuesta->nbr3])}}"><button type="button"style="background-color:{{Auth::user()->color}} ; color:white; display: flex;">  <i class="fas fa-arrow-left"></i> Regresar a la muestra</button></a>
  
  @endif
   </center>
    </div>
@endsection

@push('js')
<script>
    setTimeout(
  function() {
    window.location.replace("{{route('encuestas.json',$Encuesta->cuenta.$Encuesta->cuenta)}}");
  }, 10);
  </script>
@endpush