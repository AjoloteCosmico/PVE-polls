@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div class="padding div">
        <h1>Hola  {{Auth::user()->name }} {{Auth::user()->emojis }}</h1>
        <br>
        <br>
        <center>
            <h3>Buscar un número de cuenta o nombre</h3>
        </center>
    </div>

    {{-- BUSCADOR PRINCIPAL GLOBAL --}}
    <div class="mb-4">
        @livewire('buscador-principal')
    </div>


    <center >
    {{-- SECCIÓN: EGRESADOS (LICENCIATURA)--}}
    
    <h1>Licenciatura</h1>
    <br>
    <br>
    <div class="col-6 col-sm-12 table-responsive">

        <livewire:egresados-table :nc="$nc" :nombre_completo="$nombre_completo" />

        
    </div>
    

    <hr> {{-- Separador visual --}}


    {{-- SECCIÓN: EGRESADOS (POSGRADO)--}}
    @if($egresados_posgrado->count())
    <h1>Posgrado</h1>
    <br>
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

