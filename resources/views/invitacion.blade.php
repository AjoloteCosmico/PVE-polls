@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div class="padding div" style="padding:30px;">
    <h1 class="text-white-50">ENVIAR ENCUESTA POR INTERNET</h1>
    <h1 class="text-white-50"> {{$Egresado->nombre}} {{$Egresado->paterno}} {{$Egresado->materno}}</h1>
    </div>
    <table>
        <tr>
            <th colspan="2">Datos Personales</th>
        </tr>
        <tr>
            <th>cuenta</th>
            <td>{{$Egresado->cuenta}}</td>
        </tr>
        <tr>
            <th>Carrera</th>
            <td>{{$Egresado->carrera}} </td>
        </tr>
        <tr>
            <th>Plantel</th>
            <td>{{$Egresado->plantel}}</td>
        </tr>
    </table>
    <center >
    <br><br>
        <form action="{{ route('enviar_invitacion')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input  style="width:50%" type="email" class="form-control" name="correo" aria-describedby="emailHelp" placeholder="Enter email" value="{{$Egresado->nar1_a}}">
    <input  type="text" name="nombre" class="form-control" hidden value="{{$Egresado->nombre}} {{$Egresado->paterno}} {{$Egresado->materno}}">
    <input  type="text" name="cuenta" class="form-control" hidden value="{{$Egresado->cuenta}}">
    <input  type="text" name="carrera" class="form-control" hidden value="{{$Egresado->carrera}}">
    <input  type="text" name="plantel" class="form-control" hidden value="{{$Egresado->plantel}}">

    <input  type="number" name="anio" class="form-control" hidden value="14">  
</div>

  <br>
  <button type="submit" style="color:rgb({{Auth::user()->color}})" class="btn btn-primary btn-lg">  <i class="fas fa-paper-plane"></i> Enviar</button>
 
  </form>
   </center>
    </div>
@endsection
