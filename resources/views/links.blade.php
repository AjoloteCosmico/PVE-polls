
@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div class="padding div">
        <h1>Bienvenid@ {{Auth::user()->name }}</h1>
        <h1> Links </h1>
    </div>
    <center >
    <div class="cuadro-azul">
        <div class="row link-card cuadro-amarillo"> 
            <div class="col cuadro-amarillo">
                <h3>Actualizacion 2014 internet</h3><br>
                <a href="https://www.pveaju.unam.mx/encuesta/01/act_14/encuesta_actualizacion.php">https://www.pveaju.unam.mx/encuesta/01/act_14/encuesta_actualizacion.php</a>
            </div>
        </div>
        <div class="row link-card cuadro-amarillo"> 
            <div class="col cuadro-amarillo">
                <h3>Actualizacion 2014 Telefonica</h3><br>
                <a href="https://www.pveaju.unam.mx/encuesta/01/act_14/tel_act1_6.php">https://www.pveaju.unam.mx/encuesta/01/act_14/tel_act1_6.php</a>
            </div>
        </div>
        <div class="row link-card cuadro-amarillo"> 
            <div class="col cuadro-amarillo">
                <h3>Página del seguimiento</h3><br>
                <a href="https://www.pveaju.unam.mx/encuesta/01/seguimiento2024/">https://www.pveaju.unam.mx/encuesta/01/seguimiento2024/</a>
            </div>
        </div>
        <div class="row link-card cuadro-amarillo"> 
            <div class="col cuadro-amarillo">
                <h3>Encuesta por Internet General 2020</h3><br>
                <a href="https://encuestas.pveaju.unam.mx/encuesta_generacion/2020"> https://encuestas.pveaju.unam.mx/encuesta_generacion/2020</a>
            </div>
        </div>
        <div class="row link-card cuadro-amarillo"> 
            <div class="col cuadro-amarillo">
                <h3>Encuesta por Internet General 2022</h3><br>
                <a href="https://encuestas.pveaju.unam.mx/encuesta_generacion/2022"> https://encuestas.pveaju.unam.mx/encuesta_generacion/2022</a>
            </div>
        </div>
        <div class="row link-card cuadro-amarillo"> 
            <div class="col cuadro-amarillo">
                <h3>Encuesta por Internet de actualización 2016</h3><br>
                <a href="https://encuestas.pveaju.unam.mx/encuesta_actualizacion/2016"> https://encuestas.pveaju.unam.mx/encuesta_actualizacion/2016</a>
            </div>
        </div>
        <div class="row link-card cuadro-amarillo"> 
            <div class="col cuadro-amarillo">
                <h3>Encuesta por Internet Todas la carreras y generaciones</h3><br>
                <a href="https://encuestas.pveaju.unam.mx/encuesta_generacion/general">https://encuestas.pveaju.unam.mx/encuesta_generacion/general</a>
            </div>
        </div>
    </div>
    </center>
</div>
@endsection


@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

@endpush

