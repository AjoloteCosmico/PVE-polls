@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div  class="padding div">
    <h1>Hola  {{Auth::user()->name }} {{Auth::user()->emojis }}</h1>
    <h1> Estas son tus muestras:</h1>
  </div>
  <center >
    <div style="display:flex; justify-content:space-around; align-content:space-around; align-items: flex-start; margin:4.9vh; padding:5.6vh;flex-wrap: wrap">
  <a href="{{route('muestras20.plantel_index')}}">
  <button class='boton-muestras' >
      <br><br>ENCUESTA DE SEGUIMIENTO 2020 <br><br><br>
      <img src="{{ asset('img/encuesta.png') }}" alt="encuesta" class="icono-boton">
  </button>
</a>
  <a href="{{route('muestras16.plantel_index')}}">
    <button class='boton-muestras' >
      <br><br>ENCUESTA DE ACTUALIZACION 2016 <br><br><br>
      <img src="{{ asset('img/actualizacion.png') }}" alt="actuaizacion" class="icono-boton">
    </button>
  </a>
  <a href="{{route('posgrado.programas_index')}}">
    <button class='boton-muestras' >
      <br><br>ENCUESTA DE POSGRADO <br><br><br>
      <img src="{{ asset('img/posgrado.png') }}" alt="actuaizacion" class="icono-boton">
    </button>
  </a>
  </div>
  </center>
</div>
    @endsection

    @push('css')
    @endpush