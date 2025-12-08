@extends('layouts.app')

@section('content')
<div class="container-fluid" background="{{asset('img/Fondo2.jpg')}}">
  <h1>{{$programa}} </h1>
<div class="col-6 col-lg-12 table-responsive">
        <table class="table text-xl tabla_muestra" id="myTable">
          <thead>
            <tr>
            <th>Plan</th>
            <th>Realizadas Telefonica</th>
            <th>Realizadas Internet</th>
            <th>Requeridas </th>
            <th>Porcentaje</th>
            <th>Número de vuelta</th>
            <th> </th>
          </tr>
          </thead>
          <tbody>
            @foreach($planes as $p)
            @if($p->plan)
            <tr style="background-color: rgba({{ 255 * (1 - (($p->requeridas > 0) ? ($p->nencuestas_tel + $p->nencuestas_int) / $p->requeridas : 0)) }},{{ 255 * (($p->requeridas > 0) ? ($p->nencuestas_tel + $p->nencuestas_int) / $p->requeridas : 0) }},0,0.4)">
                <td> {{$p->plan}} </td>
                <td> {{$p->nencuestas_tel}} </td>
                <td> {{$p->nencuestas_int}} </td>
                <td> {{$p->requeridas}} </td>
                <td> {{ $p->requeridas > 0 ? number_format((($p->nencuestas_tel + $p->nencuestas_int) * 100) / $p->requeridas, 2) : '0.00' }} %</td>
                <th> - </th>
               
                <td><a href="{{ route('muestrasposgrado.show', [$programa, $p->plan]) }}"> <button class="boton-oscuro" >Ver Muestra </button></a></td>
              
              </tr>
              @endif
            @endforeach
          </tbody>
        </table>
        <a href="{{route('posgrado.programas_index')}}">
          <button class="boton-volver">
            <i class="fa-sharp fa-solid fa-rotate-left"></i>
          </button>
        </a>
    </div>
    <center >
   
   </center>
    </div>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.1/css/buttons.dataTables.css"/>
@stop

@push('js')
<script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.1/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.print.min.js"></script>

<!-- <script src=""></script>
<script src=""></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.html5.min.js"></script>
<script>
  new DataTable('#myTable', {
    paging: false,
    layout: {
        topStart: {
            buttons: ['print','csv','excel','copy']
        }
    }
        
});
 </script>
@endpush