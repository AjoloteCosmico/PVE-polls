@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div class="padding div" >
    <h1 class="text-white-50">Editar Correo para {{$Egresado->nombre }} </h1>
    <h1 style="color:white">{{$Egresado->nombre}} {{$Egresado->paterno}} {{$Egresado->materno}}   </h1>
        <h1 style="color:white">{{$Egresado->cuenta}}   </h1>
        <h1 style="color:white">{{$Carrera}} {{$Plantel}}   </h1>
    </div>
    <center>
    <br><br>
    <form action="{{ route('actualizar_correo',[$Correo->id,$Egresado->carrera,$encuesta])}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Correo</label>
            <input  style="width:50%" type="email" class="form-control" value="{{$Correo->correo}}" name="correo" aria-describedby="emailHelp" >
        </div>
        <div class="form-group"> 
            <label for="exampleInputEmail1">Status</label>
            <select style="width:50%" class="form-control" name="status" aria-describedby="emailHelp" placeholder="Enter email">
                <option value="13" @if($Correo->status == '13') selected @endif> En Uso</option>   
                <option value="14" @if($Correo->status == '14') selected @endif> Sin usar</option>   
            </select>
        <br>
        <button type="submit" style="color:rgb({{Auth::user()->color}})" class="btn btn-primary btn-lg">  <i class="fas fa-store"></i> Guardar</button>
    </form>
   </center>
</div>
@endsection
