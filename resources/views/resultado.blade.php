@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div class="padding div">
        <h1>Hola  {{Auth::user()->name }} {{Auth::user()->emojis }}</h1>
       
    </div>


    <center >
    {{-- SECCIÓN: EGRESADOS (LICENCIATURA)--}}
    
    <h1>Egresados</h1>
    <br>
    <h3>Buscar un nombre o numero de cuenta </h3>
    <br>
    <div class="col-6 col-sm-12 table-responsive">

        <livewire:egresados-table :nc="$nc" :nombre_completo="$nombre_completo" />

        
    </div>
    

    <hr> {{-- Separador visual --}}


    {{-- SECCIÓN: EGRESADOS (POSGRADO)--}}
    @if($egresados_posgrado->count())
    <h1>Egresados de Posgrado</h1>
    <br>
    <h3>¿Deseas hacer una nueva encuesta? </h3>
    <br>
    <div class="col-6 col-sm-12 table-responsive">


        <livewire:posgrado-table :nc="$nc" :nombre_completo="$nombre_completo" />


    </div>

    @else
        No hay egresados que mostrar

    @endif
   </center>
    </div>
@endsection

