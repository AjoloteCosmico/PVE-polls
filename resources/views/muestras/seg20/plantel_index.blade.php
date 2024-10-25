@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
<div class="col-6 col-lg-12 table-responsive">
        <table class="table text-xl " id="myTable">
          <thead>
            <tr>
            <th>Plantel</th>
            
            <th> </th>
          </tr>
          </thead>
          <tbody>
            @foreach($Planteles as $p)
            <tr >
                <td>{{$p->plantel}} </td>
              
                <td><a href="{{route('muestras20.index',$p->clave_plantel)}}"> <button class="btn" >Ver Muestra </button></a></td>
               
              </tr>
            @endforeach
          </tbody>
        </table>
    </div>
    <center >
   

   </center>
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