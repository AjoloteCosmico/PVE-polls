@extends('layouts.app')

@section('content')

@php
    // 1. Normalizacion
    $egresadoActual = $Egresado ?? $EgresadoPos;
    
    // 2. Identificamos si es licenciatura o posgrado para la ruta
    $identificador = isset($egresadoActual->carrera) ? $egresadoActual->carrera : $egresadoActual->programa;
    
    $rutaDestino = isset($egresadoActual->carrera) ? 'guardar_telefono' : 'guardar_telefono_pos';
@endphp



<div class="numero_telefonico">
    Estas en una llamada con el numero: {{$TelefonoEnLlamada->telefono}}
  </div>
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div class="padding div" >
    <h1>Agregar otro telefono para {{ $egresadoActual->nombre }} </h1>

    <h1></h1>
    </div>
    <br><br>

    <center>
        <form action="{{ route($rutaDestino, [$egresadoActual->cuenta, $identificador, $encuesta, $TelefonoEnLlamada->id])}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1" style="color:white">Ingrese el nuevo teléfono (10 dígitos solo números)</label>
                <br> <br>
                <input  style="width:50%" type="tel" pattern="[0-9]{10}" class="form-control" name="telefono" aria-describedby="emailHelp" placeholder="Ingrese el telefono 10 digitos">
            </div>
            
            <div class="form-group">
                <label style="color:white" for="exampleInputEmail1">Descripcion o notas (telefono de trabajo, lada, extencion)</label>
                <br> <br>
                <input  style="width:50%" class="form-control" name="description" aria-describedby="emailHelp" placeholder="Descripcion, lada extención">
            </div>
            <br>
            <button type="submit" style="color:rgb({{Auth::user()->color}})" class="btn btn-primary btn-lg">  <i class="fas fa-store"></i> Guardar</button>
            </form>
        </div>
    </center>
    <br><br>
    
    @if ($errors->any())
        <div class="alert alert-danger">

            <ul>

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif
@endsection
