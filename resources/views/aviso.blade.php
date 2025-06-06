@extends('layouts.app')

@section('content')
<div class="elementos-centrados">
    <div class="padding div">
    <h1>Hola  {{Auth::user()->name }} {{Auth::user()->emojis }}</h1><br>
        <h1> Deseas Enviar un aviso de privacidad?</h1>
    </div>
    <center >
    <br><br><br>
    <br><br><br><br>
        <form action="{{ route('enviar_aviso')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
    <label for="exampleInputEmail1" class="label-correo">Email address</label>
    <input type="email" class="input" name="correo" aria-describedby="emailHelp" placeholder="Enter email">
   </div>
   <br><br> <br>
    <br><br><br><br>
  <div class="form-group">
    <label for="exampleInputEmail1" class="label-nombrecompleto">Nombre del Egresado</label>
    <input  type="text" class="input" name="nombre" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nombre">
  </div>
  <br><br><br>
  <br>
  <button type="submit" class="btn btn-primary btn-lg boton-buscar">  <i class="fas fa-paper-plane"></i> Enviar</button>
 
  </form>
   </center>
    </div>
@endsection
