@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div class="padding div" style="padding:30px;">
        <h1 class="text-white-50">ENVIAR ENCUESTA POR CORREO</h1>
        <h1 class="text-white-50"> {{$Egresado->nombre}} {{$Egresado->paterno}} {{$Egresado->materno}}</h1>
    </div>
    <div style="display: flex; justify-content:space-between; ">
        <table class="text-white-50" style="width: 45%; border: 5px solid; font-size: 40px;">
            <th class="text-white-50" colspan="2">Datos Personales</th>
            <tr>
                <td>Cuenta</td>
                <td>{{$Egresado->cuenta}}</td>
            </tr>
            <tr>
                <td>Carrera</td>
                <td>{{$Carrera->carrera}} </td>
            </tr>
            <tr>
                <td>Plantel</td>
                <td>{{$Carrera->plantel}}</td>
            </tr>
            <tr>
                <td>Encuesta</td>
                <td>{{$Egresado->anio_egreso}}</td>
            </tr>
        </table>
    </div>

</div>
<center>
    <br><br>
    <form action="{{route('enviar_invitacion')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input  style="width:50%" type="email" class="form-control" name="correo" aria-describedby="emailHelp" placeholder="Enter email" value="{{$Correo->correo}}" readonly="readonly">
        <input  type="text" name="nombre" class="form-control" hidden value="{{$Egresado->nombre}} {{$Egresado->PATERNO}} {{$Egresado->materno}}">
        <input  type="text" name="cuenta" class="form-control" hidden value="{{$Egresado->cuenta}}">
        <input  type="text" name="carrera" class="form-control" hidden value="{{$Egresado->carrera}}">
        <input  type="text" name="plantel" class="form-control" hidden value="{{$Egresado->plantel}}">
        <input  type="number" name="anio" class="form-control" hidden value="{{$Egresado->anio_egreso}}">  
        <br>
        <button type="submit" style="color:rgb({{Auth::user()->color}})" class="btn btn-primary btn-lg">  <i class="fas fa-paper-plane"></i> Enviar</button>
    </form>
</center>
<style>
    th, td {
        border: 5px solid;
        text-align: center;
        }
</style>
@endsection
