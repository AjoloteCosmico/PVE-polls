@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
<div class="col-6 col-lg-12 table-responsive">
        <table class="table text-xl tabla_muestra" id="myTable">
          <thead>
            <tr>
            <th>Carrera</th>
            <th>Plantel</th>
            @if($id==0)
            <th>Poblacion</th>
            @endif
            <th>Realizadas Telefonica</th>
            <th>Realizadas Internet</th>
            <th>Requeridas </th>
            <th>Porcentaje</th>
            <th>Número de vuelta</th>
            <th> </th>
            <th> </th>
          </tr>
          </thead>
          <tbody>
            @foreach($carreras as $c)
            <tr style="background-color:rgba({{255*(1-($c->nencuestas_tel+$c->nencuestas_int)/$c->requeridas_5)}},{{255*(($c->nencuestas_tel+$c->nencuestas_int)/$c->requeridas_5)}},0,0.4)">
                <td>{{$c->carrera}} </td>
                <td>{{$c->plantel}} </td>
                @if($id==0)
                 <td>{{$c->pob}}</td> 
                @endif
                <td> {{$c->nencuestas_tel}}</td>
                <td> {{$c->nencuestas_int}}</td>
                <td> {{$c->requeridas_5}}</td>
                <td> {{number_format((($c->nencuestas_tel+$c->nencuestas_int) *100)/$c->requeridas_5,2)}} %</td>
                <th> - </th>
                <td><a href="{{route('muestras20.show',[$c->c,$c->p])}}"> <button class="boton-oscuro" >Ver Muestra </button></a></td>
                <td></td>
           
              </tr>
            @endforeach
          </tbody>
        </table>
        <a href="{{route('muestras20.plantel_index')}}">
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