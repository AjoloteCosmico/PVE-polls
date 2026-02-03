@extends('layouts.app')

@section('content')
<div class="container-fluid ">
  <div  class="padding div">
    <h1>Hola  {{Auth::user()->name }} {{Auth::user()->emojis }}</h1>
    <h1> Estas son tus muestras:</h1>
  </div>
  
  <div class="container-muestras">
    <!-- <div style="display:flex; justify-content:space-around; align-content:space-around; align-items: flex-start; margin:4.9vh; padding:5.6vh;flex-wrap: wrap"> -->
      @can('ver_muestra_actualizacion')
       <div>
        <a href="{{route('muestras.plantel_index', ['gen' => 16]) }}">
          <button class='boton-muestras' >
            <br><br>ENCUESTA DE ACTUALIZACION 2016 <br><br><br>
            <img src="{{ asset('img/actualizacion.png') }}" alt="actuaizacion" class="icono-boton">
          </button>
        </a>
      </div>
      @endcan


      @can('ver_muestra_seguimiento')
      <div>  
        <a href="{{route('muestras.plantel_index', ['gen' => 20]) }}">
        <button class='boton-muestras' >
            <br><br>ENCUESTA DE SEGUIMIENTO 2020 <br><br><br>
            <img src="{{ asset('img/encuesta.png') }}" alt="encuesta" class="icono-boton">
        </button>
      </a>
      </div>
      <div>
        <a href="{{route('muestras.plantel_index', ['gen' => 22]) }}">
          <button class='boton-muestras' >
            <br><br>ENCUESTA DE SEGUIMIENTO 2022 <br><br><br>
            <img src="{{ asset('img/encuesta.png') }}" alt="encuesta" class="icono-boton">
          </button>
        </a>
      </div>
      @endcan


      @can('ver_muestra_posgrado')
    <div>
    <a href="{{route('posgrado.programas_index')}}">
    <button class='boton-muestras' >
      <br><br>ENCUESTA DE POSGRADO <br><br><br>
      <img src="{{ asset('img/posgrado.png') }}" alt="actuaizacion" class="icono-boton">
    </button>
    </a>
    </div>
    @endcan
@can('ver_muestra_ed_continua')
       <div>
        <a href="{{route('ed_continua.planteles') }}">
          <button class='boton-muestras' >
            <br><br>ENCUESTA DE EDUCACIÓN CONTINUA <br><br><br>
            <img src="{{ asset('img/encuesta.png') }}" alt="educacion continua" class="icono-boton">
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
    width: 20vw;
  }
    </style>
@endpush