@extends('layouts.app')

@section('content')

<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div >
    <h1 class="text-white-50">  </h1>
        <h1 class="text-white-50"> </h1>
    </div>
    <div class="col-6 col-lg-12 table-responsive">
        <table class="table text-xl " id="myTable">
          <thead>
            <tr>
            <th>Nombre</th>
            <th>Num. cuenta</th>
            <th>Telefono <br> Trabajo</th>
            <th>Telefono <br> Casa</th>
            <th>Correo</th>
            <th>llamadas</th>
            <th> </th>
          </tr>
          </thead>
          <tbody>
            @foreach($muestra as $e)
            <tr style="background-color: {{$e->color}};">
                <td>{{$e->nombre}} {{$e->paterno}} {{$e->materno}}</td>
                <td>{{$e->cuenta}} </td>
                <td>{{$e->teltra}} </td>
                <td>{{$e->telcasa}} </td>
                <td style="word-wrap:break-word;">{{$e->nar1_a}} </td>
                <td>{{$e->llamadas}} </td>
                <td><a href="{{route('encuestas.show_14',$e->registro)}}"> <button class="btn"  ; color:white; margin: 0.1vw">Hacer Encuesta </button></a>
              <br><a href="{{route('encuestas.recado_14',$e->registro)}}"> <button class="btn"  ; color:white;  margin: 0.1vw">Dejar Recado </button></a></td>
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