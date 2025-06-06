@extends('layouts.app')

@section('content')
<div class="elementos-centrados">
    <div class="padding div" >
        <h1>Hola  {{Auth::user()->name }} {{Auth::user()->emojis }}</h1><br>
        <h1> ¿Deseas buscar un numero de cuenta?</h1>
    </div>
    <center>
    <br><br><br>
    <br><br><br><br>
    <form action="{{ route('resultado')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1" class="label-cuenta">Número de cuenta</label> <br>
            <input  type="number" class="input" name="nc" aria-describedby="emailHelp" placeholder="Ingresa el número de cuenta">
        </div>
        <button type="submit" class="btn btn-primary btn-lg boton-buscar">  <i class="fas fa-paper-plane"></i> Buscar</button>
    </form>
    <br><br> <br>
    <br><br><br><br>
    <form action="{{ route('resultado_fonetico')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1" class="label-nombrecompleto">Buscar por nombre</label> <br>
            <input  type="text" class="input" name="nombre_completo" aria-describedby="emailHelp" placeholder="Ingresa el nombre y/o apellido">  
        </div>
        <button type="submit" class="btn btn-primary btn-lg boton-buscar">  <i class="fas fa-paper-plane"></i> Buscar</button>
    </form>
    </center>
</div>
@endsection
