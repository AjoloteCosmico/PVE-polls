@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="padding div" >
        <h1>ENVIAR ENCUESTA POR CORREO</h1>
        <h1> {{$Egresado->nombre}} {{$Egresado->paterno}} {{$Egresado->materno}}</h1>
    </div>
    @if($posgrado=='posgrado')
     <div >
        <table class="text-white-50" >
            <th style="color: white;"  colspan="2">Datos Personales</th>
            <tr style="background-color: rgb(0, 43, 122);">
                <td>Cuenta</td>
                <td>{{$Egresado->cuenta}}</td>
            </tr>
            <tr style="background-color: rgb(0, 43, 122);">
                <td>Plan</td>
                <td>{{$Egresado->plan}} </td>
            </tr>
            <tr style="background-color: rgb(0, 43, 122);">
                <td>Programa</td>
                <td>{{$Egresado->plan}}</td>
            </tr>
            <tr style="background-color: rgb(0, 43, 122);">
                <td>Generacion</td>
                <td>{{$Egresado->anio_egreso}}</td>
            </tr>
        </table>
    </div>

</div>
<center>
    <br><br>
    <form action="{{route('enviar_invitacion_posgrado')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group" style="color:rgb(22, 24, 112);">
        <label style="color: rgb(231, 231, 231);" for="exampleInputEmail1">Email address</label>
        <input  style="background-color: rgb(22, 24, 112), color: rgb(171, 171, 196);" type="email" class="form-control" name="correo" aria-describedby="emailHelp" placeholder="Enter email" value="{{$Correo->correo}}" readonly="readonly">
        <input  type="text" name="nombre" class="form-control" value="{{$Egresado->nombre}} {{$Egresado->paterno}} {{$Egresado->materno}}">
        <input  type="text" name="cuenta" class="form-control"  value="{{$Egresado->cuenta}}">
        <input  type="text" name="plan" class="form-control" value="{{$Egresado->plan}}">
        <input  type="text" name="programa" class="form-control"  value="{{$Egresado->programa}}">
        <input  type="number" name="anio" class="form-control" value="{{$Egresado->anio_egreso}}">
        <input  type="text" name="telefono" class="form-control" hidden value="{{$telefono}}">
        <br>
        <button type="submit" class="btn btn-primary btn-lg">  <i class="fas fa-paper-plane"></i> Enviar</button>
    </form>
</center>
    @else
     <div >
        <table class="text-white-50" >
            <th style="color: white;"  colspan="2">Datos Personales</th>
            <tr style="background-color: rgb(0, 43, 122);">
                <td>Cuenta</td>
                <td>{{$Egresado->cuenta}}</td>
            </tr>
            <tr style="background-color: rgb(0, 43, 122);">
                <td>Carrera</td>
                <td>{{$Carrera->carrera}} </td>
            </tr>
            <tr style="background-color: rgb(0, 43, 122);">
                <td>Plantel</td>
                <td>{{$Carrera->plantel}}</td>
            </tr>
            <tr style="background-color: rgb(0, 43, 122);">
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
        <div class="form-group" style="color:rgb(22, 24, 112);">
        <label style="color: rgb(231, 231, 231);" for="exampleInputEmail1">Email address</label>
        <input  style="background-color: rgb(22, 24, 112), color: rgb(171, 171, 196);" type="email" class="form-control" name="correo" aria-describedby="emailHelp" placeholder="Enter email" value="{{$Correo->correo}}" readonly="readonly">
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
    @endif




@endsection

@push('js')
    @if(session('swal_warning'))
        <script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Año no valido para enviar la invitación",
                customClass: {
                    popup: 'mi-popup',
                    title: 'mi-titulo',
                    confirmButton: 'mi-boton'
                }
            });
        </script>
    @endif
@endpush