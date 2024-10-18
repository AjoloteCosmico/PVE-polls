@extends('layouts.app')

@section('content')

<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div style="padding:30px;">
     <div class='row'>
      <div class='col'><h1 class="text-white-25" style="font-color: white; font-weight: bold;">  @if($carrera>0) {{$Carrera->carrera}} @endif </h1> 
    <h1 class="text-white-25" style="font-color: white">{{$Carrera->plantel}}  </h1> 
    </div>
      <div class='col' style="display: flex;justify-content: center;align-items:flex-end;">
          <a href="{{route('muestras20.index',$plantel)}}">
            <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; height: 100px; width:300px;font-size: xx-large;"><i class="fas fa-arrow-left" ></i>Regresar</button>
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
                <td> 
                <p style="color:rgba(255,255,255,0.5); font-size:1px"> {{$e->orden}}</p>
                <a href="{{route('llamar_20',$e->cuenta)}}"> <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw"> <i class="fa fa-phone" aria-hidden="true"> </i> &nbsp; LLAMAR </button></a>
             
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

<style>

    @if(Auth::user()->dark_mode ==0) 
  .table-div{
    background-color: white;
    color:black;
     } 

    .muestra{
        th{
            border: 1px solid;
        }
        td{
            border: 0.05vw solid;
            color:black;
        }
    }
    @else 
    .table-div{
    background-color: black;
    color:white;
    }

    .muestra{
        th{
            border: 1px solid;
        }
        td{
            border: 0.05vw solid;
            color:white;
        }
    }

    @endif


    
</style>
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
    sorting: [[6, 'asc'],[1, 'asc']],
    
});
</script>

 
@endpush