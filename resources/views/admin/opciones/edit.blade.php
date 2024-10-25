@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div class="padding div" >
     <h1 class="text-white-50" style="color:white"> EDITAR Opcion </h1>
    </div>
    <center >
    <br><br>
        <form action="{{ route('options.update_re',$Opcion->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        
       <div class="form-group">
            <label for="exampleInputEmail1">Redaccion de la pregunta</label>
            <input  style="width:50%" type="text" class="form-control myinput" name="description" value= "{{$Opcion->descripcion}}">
       </div>
       
  <br>
  <button type="submit" style="color:rgb({{Auth::user()->color}})" class="btn btn-primary btn-lg">  <i class="fas fa-paper-plane"></i> Enviar</button>
 
  </form>
   </center>
    </div>
@endsection


@push('css')
<!--
<style>
table{
    font-size:2.1vw;
}

    .selecter{
        color:black;
        background-color:white;
        font-size:1.4vw;
    }

    .myinput{
        color:black !important;
        background-color:white;
        font-size:1.4vw !important;
    }
</style>
-->
@endpush