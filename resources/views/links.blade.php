
@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div class="padding div">
    <h1 class="text-white-50">Hola  {{Auth::user()->name }} {{Auth::user()->emojis }}</h1>
        <h1 class="text-white-50"> Links Actualizados al</h1>
    </div>
    <center >
   
<div>
        <div class="col" > 
            <div class="row link-card"> 
                <div class="col">
                 Actualizacion 2014 internet
                </div>
                <div class="col">
                 <a href="https://www.pveaju.unam.mx/encuesta/01/act_14/encuesta_actualizacion.php">https://www.pveaju.unam.mx/encuesta/01/act_14/encuesta_actualizacion.php</a>
                </div>
            </div>
            <br>
            <div class="row link-card"> 
                <div class="col">
                 Actualizacion 2014 Telefonica
                </div>
                <div class="col">
                 <a href="https://www.pveaju.unam.mx/encuesta/01/act_14/tel_act1_6.php">https://www.pveaju.unam.mx/encuesta/01/act_14/tel_act1_6.php</a>
                </div>
            </div>
            <br>
            <div class="row link-card"> 
                <div class="col">
                 Página del seguimiento
                </div>
                <div class="col">
                 <a href="https://www.pveaju.unam.mx/encuesta/01/seguimiento2024/">https://www.pveaju.unam.mx/encuesta/01/seguimiento2024/</a>
                </div>
            </div>

            <a href="https://encuestas.pveaju.unam.mx/encuesta_generacion/2020">
            <div class="row link-card" > 
                <div class="col title">
                 Encuesta por Internet Gen 2020
                </div>
                <div class="col link">
                 https://encuestas.pveaju.unam.mx/encuesta_generacion/2020
                </div>
            </div></a>
            <div class="row link-card"> 
                <div class="col">
                 Encuesta por Internet Todas la carreras y generaciones
                </div>
                <div class="col">
                 <a href="https://encuestas.pveaju.unam.mx/encuesta_generacion/general">https://encuestas.pveaju.unam.mx/encuesta_generacion/general</a>
                </div>
            </div>
        </div>
</div>

   </center>
    </div>
@endsection


@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

@endpush

