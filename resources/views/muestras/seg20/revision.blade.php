@extends('layouts.app')

@section('content')

<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    
    <div class="col-6 col-lg-12 table-responsive table-div">
      
        <table class="table text-xl muestra " id="myTable">
          <thead>
            <tr>
            <th>Nombre</th>
            <th>Num. Cuenta</th>
            <th>Aplicador</th>
            <th>fecha</th>
            <th>carrera</th>
            <th>plantel</th>
            <th> </th>
          </tr>
          </thead>
          <tbody>
            @foreach($Encuestas as $e)
            <tr style="background-color: {{$e->color_rgb}};">
                <td>{{$e->nombre}} {{$e->paterno}} {{$e->materno}}</td> 
                <td>{{$e->cuenta}} </td>
                <td>{{$e->name}}  </td>
                <td>{{$e->fec_capt}} </td>
                <td> {{$e->carrera}}</td>
                <td> {{$e->plantel}}</td>
                <td><a href="{{route('edit_20',[$e->registro,'SEARCH'])}}"> <button class="btn"> <i class="fa fa-eye" aria-hidden="true"> </i> &nbsp; Revisar </button></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
    </div>
</div>
@stop

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

@endpush

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