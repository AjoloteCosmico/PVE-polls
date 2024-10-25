@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div class="padding div" >
    <h1 class="text-white-50">Hola  {{Auth::user()->name }} {{Auth::user()->emojis }}</h1>
        <h1 class="text-white-50"> Estas son tus muestras:</h1>
    </div>
    <center >
  <a href="{{route('muestras20.plantel_index')}}">
    <button class='boton-muestras' >
       <br><br>ENCUESTA DE SEGUIMIENTO 2020 <br><br><br>
    </button></a>
  <a href="{{route('muestras14.index')}}">
    <button class='boton-muestras' >
       <br><br>ENCUESTA DE ACTUALIZACION 2014 <br><br><br>
    </button></a>
  </center>


    </div>
    @endsection

    @push('css')
    @endpush