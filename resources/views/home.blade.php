@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div >
    <h1 class="text-white-50">Bienvenid@!!  {{Auth::user()->name }} {{Auth::user()->emojis }}</h1>
    <div>-----------------------------------------
        <br><br><br> 
    <a href="{{ route('report','reporte_individual')}}"  > <button class="btn">
    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Reporte Individual 2019
    </button></a>
    
    <a href="{{ route('report','reporte_individual_act2014')}}"  > <button class="btn">
    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Reporte Individual 2014
    </button></a>
    
    <a href="{{ route('report','correos_inconclusas')}}"  > <button class="btn">
    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Correos par encuestas inconclusas
    </button></a>
    </div>
<br><br><br>
<div>
    <h1><i class="fas fa-exclamation-triangle"></i>  AVISO!! : NUEVOS NUMEROS DE TELEFONO: </h1>
<table  class="table text-lg " id="myTable" >
    <thead> 
        <th>cuenta</th>
        <th>egresado</th>
        <th>carrera</th>
        <th>plantel</th>
        <th></th>

    </thead>
    <tbody>
        @foreach($nuevos_datos as $e)
        <tr style="background-color: {{$e->color_rgb}};">
            <td>{{$e->cuenta}} </td>
            <td>{{$e->nombre}} {{$e->paterno}} {{$e->materno}} </td>
            <td>{{$e->name_carrera}} </td>
            <td>{{$e->name_plantel}} </td>
            <td><a href="{{route('llamar_20',$e->cuenta)}}"> <button class="btn"> <i class="fa fa-phone" aria-hidden="true"> </i> &nbsp; LLAMAR </button></a>
             </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
<br>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
@stop

@push('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script>
 
  console.log('script jalando ¿?');
  $(document).ready(function() {
    $('#myTable').DataTable();
} );
 </script>

 @endpush