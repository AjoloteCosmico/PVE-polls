@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div class="padding div" >
        <h1 class="text-white-50">ENVIAR ENCUESTA POR CORREO</h1>
        <h1 class="text-white-50"> {{$Egresado->nombre}} {{$Egresado->paterno}} {{$Egresado->materno}}</h1>
    </div>
    <div >
        <table class="text-white-50" >
            <th class="text-white-50" colspan="2">Datos Personales</th>
            <tr>
                <td>cuenta</td>
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
        <input   type="email" class="form-control" name="correo" aria-describedby="emailHelp" placeholder="Enter email" value="{{$Correo->correo}}" readonly="readonly">
        <input  type="text" name="nombre" class="form-control" hidden value="{{$Egresado->nombre}} {{$Egresado->paterno}} {{$Egresado->materno}}">
        <input  type="text" name="cuenta" class="form-control" hidden value="{{$Egresado->cuenta}}">
        <input  type="text" name="carrera" class="form-control" hidden value="{{$Carrera->carrera}}">
        <input  type="text" name="carrera_clave" class="form-control" hidden value="{{$Egresado->carrera}}">
        <input  type="text" name="plantel" class="form-control" hidden value="{{$Carrera->plantel}}">
        <input  type="number" name="anio" class="form-control" hidden value="{{$Egresado->anio_egreso}}">
        <input  type="text" name="telefono" class="form-control" hidden value="{{$telefono}}">
        <br>
        <button type="submit" class="btn btn-primary btn-lg">  <i class="fas fa-paper-plane"></i> Enviar</button>
    </form>
</center>

@endsection
