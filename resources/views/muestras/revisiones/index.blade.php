@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div  class="padding div">
    <h1>Hola  {{Auth::user()->name }} {{Auth::user()->emojis }}</h1>
    <h1> Estas son tus revisiones:</h1>
  </div>
  <div class="container-muestras">
    
  
  @can('ver_muestra_actualizacion')
  <div>
    <a href="{{route('muestras.act16.revision')}}">
      <button class='boton-muestras' >
        <br><br>ENCUESTA DE ACTUALIZACION 2016 <br><br><br>
        <img src="{{ asset('img/actualizacion.png') }}" alt="actuaizacion" class="icono-boton">
      </button>
    </a>
  </div>
  @endcan

    @can('ver_muestra_seguimiento')
    
    <div>
  <a href="{{route('muestras.seg20.revision22')}}">
  <button class='boton-muestras' >
      <br><br>ENCUESTA DE SEGUIMIENTO 2022 <br><br><br>
      <img src="{{ asset('img/encuesta.png') }}" alt="encuesta" class="icono-boton">
  </button></a>
  </div>
  @endcan

  @can('ver_muestra_posgrado')
  <div>
  <a href="{{route('muestras.posgrado.revision_posgrado')}}">
  <button class='boton-muestras' style="background-color:#cc9b39">
      <br><br>ENCUESTA DE POSGRADO <br><br><br>
      <img src="{{ asset('img/posgrado.png') }}" alt="encuesta" class="icono-boton">
  </button></a>
  </div>
  @endcan
  @can('ver_muestra_ed_continua')
       <div>
        <a href="{{route('muestras_ed_continua.revision')}}">
          <button class='boton-muestras' style="background-color:#0F4D0F" >
            <br><br>ENCUESTA DE EDUCACIÓN CONTINUA <br><br><br>
           <i class="fas fa-leaf fa-6x" alt="educacion continua"></i>
          </button>
        </a>
      </div>
      @endcan
  </div>  
</div>
    @endsection

    @push('css')
    <style>
  .container-muestras {
      display: grid;
      grid-template-columns: auto auto auto;
      padding: 10px;
    }

  .container-muestras div { 
    padding: 10px;
    text-align: center;
  }
   .boton-muestras:hover{
    background-color: #ba800d !important;
    /* transponer en y  */
    transform: translateY(-5px);
    transition: all 0.3s ease;
}
    </style>
    @endpush