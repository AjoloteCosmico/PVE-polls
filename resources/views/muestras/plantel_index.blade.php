@extends('layouts.app')

@section('content')
<div class="container-fluid">
  @if($gen == 20)
    <h1>ENCUESTA DE SEGUIMIENTO 2020</h1>
  @elseif($gen == 22)
    <h1>ENCUESTA DE SEGUIMIENTO 2022</h1>
  @elseif($gen == 16)
    <h1>ENCUESTA DE ACTUALIZACIÓN GENERACIÓN 2016</h1>
  @endif
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
              
                <td>
                  @if($gen==20)
                    <a href="{{route('muestras.index_general', ['gen' => 20, $p->clave_plantel])}}">
                      <button class="boton-oscuro">Ver Muestra</button>
                    </a>
                  @elseif($gen==22)
                    <a href="{{route('muestras.index_general', ['gen' => 22, $p->clave_plantel])}}">
                      <button class="boton-oscuro">Ver Muestra</button>
                    </a>
                  @elseif($gen==16)
                    <a href="{{route('muestras.index_general', ['gen' => 16, $p->clave_plantel])}}">
                      <button class="boton-oscuro">Ver Muestra</button>
                    </a>
                  @endif
                </td>
               
              </tr>
            @endforeach
          </tbody>
        </table>
        <a href="{{route('muestras.index')}}">
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