@extends('layouts.app')

@section('content')

<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div >
     <div class='row'>
      <div class='col'><h1 class="text-white-25" >  @if($carrera>0) {{$Carrera->carrera}} @endif </h1> 
    <h1 class="text-white-25" >{{$Carrera->plantel}}  </h1> 
    </div>
      <div class='col'>
          <a href="{{route('muestras22.index',$plantel)}}">
            <button class="boton-volver">
            <i class="fa-sharp fa-solid fa-rotate-left"></i>
          </button>
          </a>
      </div>
      <div class='col'>
        <table>
          <thead> 
            <tr> 
              <th>Codigos</th>
            </tr>         
          </thead>
          <tbody>
            @foreach($Codigos as $c)
            <tr>
            <td style="background-color:{{$c->color_rgb}}"> {{$c->description}}</td>
            </tr> @endforeach
          </tbody>
        </table>
      </div>
     </div>
    </div>
    <div class="table-div"   >
    <table class="table text-lg muestra" id="myTable">
          <thead >
            <tr >
            <th >Nombre</th>
            <th>Paterno </th>
            <th>Materno</th>
            <th>Num. Cuenta</th>
            @if($carrera==0)
            <th> Carrera</th>
            @endif
            <th>llamadas</th>
            <th>status</th>
            @if($carrera==136)
            <th>Año egreso</th>
            @endif
            <th> </th>
          </tr>
          </thead>
          <tbody>
            @foreach($muestra as $e)
            <tr style="background-color: {{$e->color_rgb}}; ">
                <td>{{$e->nombre}} </td>
                <td> {{$e->paterno}} </td>
                <td> {{$e->materno}}</td>
                <td>{{$e->cuenta}} </td>
                @if($carrera==0)
            <td> {{$e->name_carrera}} </td>
            @endif
               <td>{{$e->llamadas}} </td>
               <td @if($e->description=='') class='focoso' @endif> {{$e->description}}</td>
                  @if($carrera==136)
                <td>{{$e->anio_egreso}}</td>
                  @endif
                <td> 
                <p hidden> {{$e->orden}}</p>
                <a href="{{route('llamar',[2022,$e->cuenta,$e->carrera])}}"> <button class="boton-oscuro"> <i class="fa fa-phone" aria-hidden="true"> </i> &nbsp; LLAMAR </button></a> 
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
        <div class='col'>
        <table>
          <thead> 
            <tr> 
              <th>Codigos</th>
            </tr>         
          </thead>
          <tbody>
            @foreach($Codigos as $c)
            <tr>
            <td style="background-color:{{$c->color_rgb}}"> {{$c->description}}</td>
            </tr> @endforeach
          </tbody>
        </table>
      </div>
    
</div>
@stop

@push('css')

@endpush


@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.0/js/responsive.dataTables.js"></script>
<script src="https://cdn.datatables.net/fixedheader/4.0.0/js/dataTables.fixedHeader.js"></script>
<script src="https://cdn.datatables.net/fixedheader/4.0.0/js/fixedHeader.dataTables.js"></script>

<script>
  new DataTable('#myTable', {
    fixedHeader: true,
    @if($carrera>0)
    paging: false,
    @else
    pageLength: 300,
    @endif
    responsive: true,
    sorting: [[6, 'asc'],[1, 'asc'],[2,'asc']],
    });
</script>

 
@endpush