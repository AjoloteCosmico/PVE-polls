@extends('layouts.app')

@section('content')

<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div>
    <h1 class="text-white-50">  </h1>
        <h1 class="text-white-50"> </h1>
    </div>
    <div class="col-6 col-lg-12 table-responsive">
        <table class="table text-xl " id="myTable">
          <thead>
            <tr>
            <th>Nombre</th>
            <th>Num. Cuenta</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th> </th>
          </tr>
          </thead>
          <tbody>
            @foreach($Egresados as $e)
            <tr>
                <td>{{$e->nombre}} {{$e->paterno}} {{$e->materno}}</td>
                <td>{{$e->cuenta}} </td>
                <td>{{$e->telefono}} </td>
                <td>{{$e->correo}} </td>
                <td><a href="{{route('encuestas.show',$e->cuenta)}}"> <button class="btn" >Hacer encuesta </button></a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
    </div>
</div>
@stop

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