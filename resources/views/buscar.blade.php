@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div class="padding div" >
        <h1 class="text-white-50">Hola  {{Auth::user()->name }} {{Auth::user()->emojis }}</h1>
        <h1 class="text-white-50"> ¿Deseas buscar un numero de cuenta?</h1>
    </div>
    <center>
    <br><br>
    <form action="{{ route('resultado')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Numero de cuenta</label>
            <input  type="number" class="form-control" name="nc" aria-describedby="emailHelp" placeholder="Ingresa el numero de cuenta">
        </div>
        <button type="submit" class="btn btn-primary btn-lg">  <i class="fas fa-paper-plane"></i> Buscar</button>
    </form>
    <br><br> <br>
    <form action="{{ route('resultado_fonetico')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Buscar por nombre</label>
            <input  type="text" class="form-control" name="nombre_completo" aria-describedby="emailHelp" placeholder="NOMBRE Y/O APELLIDOS">  
        </div>
        <button type="submit" class="btn btn-primary btn-lg">  <i class="fas fa-paper-plane"></i> Buscar</button>
    </form>
    </center>
</div>
@endsection
