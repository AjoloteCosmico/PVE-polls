@extends('layouts.app')

@section('content')

<div class="container-fluid">  
    <div class="col-6 col-lg-12 table-responsive table-div">
      
        <table class="table text-xl" id="myTable">
          <thead>
            <tr>
            <th>Nombre</th>
            <th>Num. Cuenta</th>
            <th>Aplicador</th>
            <th>fecha</th>
            <th>programa</th>
            <th>plan</th>
            <th> </th>
          </tr>
          </thead>
          <tbody>
            @foreach($Encuestas as $e)
            <tr>
                <td>{{$e->nombre}} {{$e->paterno}} {{$e->materno}}</td> 
                <td>{{$e->cuenta}} </td>
                <td>{{$e->aplicador_nombre}}  </td>
                <td>{{$e->updated_at}} </td>
                <td> {{$e->programa_nombre}}</td>
                <td> {{$e->plan}}</td>
                
                <td><a href="{{route('posgrado.show',['SEARCH',$e->registro])}}"> <button class="boton-oscuro"> <i class="fa fa-eye" aria-hidden="true"> </i> &nbsp; Revisar </button></a>
              </td>
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
    $('#myTable').DataTable(
      @if(Auth::user()->id==10)
      {paging: false}
      @endif
    );
} );
 </script>
@endpush