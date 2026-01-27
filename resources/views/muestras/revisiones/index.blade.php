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
    <a href="{{route('muestras.seg20.revision')}}">
    <button class='boton-muestras' >
        <br><br>ENCUESTA DE SEGUIMIENTO 2020 <br><br><br>
        <img src="{{ asset('img/encuesta.png') }}" alt="encuesta" class="icono-boton">
    </button></a>
    </div>
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
  <button class='boton-muestras' >
      <br><br>ENCUESTA DE POSGRADO <br><br><br>
      <img src="{{ asset('img/posgrado.png') }}" alt="encuesta" class="icono-boton">
  </button></a>
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
    </style>
    @endpush