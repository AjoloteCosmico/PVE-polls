@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="padding div" >
     <h1 style="color:white"> EDITAR PREGUNTA: <br><br> {{$Reactivo->clave}}</h1>
    </div>
    <center >
    <br><br>
        <form action="{{ route('reactivos.update_re',$Reactivo->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1" class="label-cuenta">Seccion</label>
            <input  style="width:50%" type="text" class="form-control myinput" name="section" value= "{{$Reactivo->section}}">
       </div>
        <div class="form-group">
            <label for="exampleInputEmail1" class="label-cuenta">Orden</label>
            <input  style="width:50%" type="number" step="0.001" class="form-control myinput" name="orden" value= "{{$Reactivo->orden}}">
       </div>
       <div class="form-group">
            <label for="exampleInputEmail1" class="label-cuenta">Clave</label>
            <input  style="width:50%" type="text" class="form-control myinput" name="clave" value= "{{$Reactivo->clave}}" disabled>
       </div>
       <div class="form-group">
            <label for="exampleInputEmail1" class="label-cuenta">Redaccion de la pregunta</label>
            <input  style="width:50%" type="text" class="form-control myinput" name="description" value= "{{$Reactivo->description}}">
       </div>
       <div class="form-group">
            <label for="exampleInputEmail1" class="label-cuenta">Tipo</label><br>
        <select name="type" class="selecter" >

        <option value="option" @if($Reactivo->type=='option') selected @endif>opcion </option>
        <option value="text" @if($Reactivo->type=='text') selected @endif>texto</option>
        <option value="number" @if($Reactivo->type=='number') selected @endif>numero </option>
        <option value="label" @if($Reactivo->type=='label') selected @endif>etiqueta (no cuenta como pregunta)</option>

        </select>  
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1" class="label-cuenta">Sub-tipo (si tiene opciones que se repiten)</label><br>
        <select name="archtype" class="selecter" >
        <option value=""></option>
        <option value="binaria" @if($Reactivo->archtype=='binaria') selected @endif>binaria</option>
        <option value="escala" @if($Reactivo->archtype=='escala') selected @endif>escala</option>
        <option value="ocupacion" @if($Reactivo->archtype=='ocupacion') selected @endif>ocupacion </option>
        <option value="educacion" @if($Reactivo->archtype=='educacion') selected @endif>educacion </option>

        </select>  
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1" class="label-cuenta">Hijo (se ve un poco mas pequeña indicando que es una pregunta secundaria)</label><br>
        <select name="child" class="selecter" >

        <option value="0" @if($Reactivo->type=='0') selected @endif>No </option>
        <option value="1" @if($Reactivo->type=='1') selected @endif>Si</option>
   
        </select>  
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1" class="label-cuenta">Leyenda (aparece debajo y mas pequeña)</label>
            <input  style="width:50%" type="text" class="form-control myinput" name="extra_label" value= "{{$Reactivo->extra_label}}">
       </div>
  <br>
  <button type="submit" class="btn btn-primary btn-lg boton-buscar">  <i class="fas fa-paper-plane"></i> Enviar</button>
 
  </form>
@if($Opciones->count()>0)
  <br>
  <h1> Lista de Opciones</h1>
  <table>
<thead>
    <tr>
        <th>Clave</th>
        <th>Opcion</th>
        <th></th>
    </tr>
</thead>
@foreach($Opciones as $o)
<tr>
    <td>{{$o->clave}} </td>
    <td>{{$o->descripcion}} </td>
    <td><a href="{{route('options.edit',$o->id)}}"> <button class="btn" >Editar </button></a></td>
           
</tr>
@endforeach
  </table>
  @endif
   </center>
    </div>
@endsection


@push('css')
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
@endpush