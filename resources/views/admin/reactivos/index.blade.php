@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
<div style="padding:2.6vw">
            
                @if(Auth::user()->confidential>=2)
                <a href="{{ route('reactivos.create')}}">
                  <button style="background-color:{{Auth::user()->color}} ; color:white; font-size:2.0vw; border-radius: 1.1vw">
                    <i class="fas fa-plus-circle"></i>&nbsp; Nuevo</button>
                </a>
                @endif
            </div>
<div class="table-div">
        <table class="table text-xl tablex" id="myTable">
          <thead>
            <tr>
            <th>Seccion </th>  
            <th>Orden </th>
            <th>Clave</th>
            <th>Descripcion</th>

            <th>Tipo </th>
            <th>Arquetipo </th>
            <th>Etiqueta</th>

            <th>Pequeño</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
            @foreach($Reactivos as $r)
            <tr>
                
                <td>{{$r->section}} </td>
                <td>{{$r->orden}} </td>
                <td>{{$r->clave}} </td>
                <td>{{$r->description}} </td>

                <td>{{$r->type}} </td>
                <td>{{$r->archtype}} </td>
                <td>{{$r->extra_label}} </td>
               
                <td>@if($r->child==1) Si @else No @endif </td>
                <td><a href="{{route('reactivos.edit',$r->id)}}"> <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white;">Editar </button></a></td>
           
              </tr>
            @endforeach
          </tbody>
        </table>
    </div>
    <center >
   

   </center>
    </div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

<style>
    @if(Auth::user()->dark_mode ==0) 
  .table-div{
    background-color: white;
    color:black;
     } 

    .tablex{
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

    .tablex{
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
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script>
  console.log('script jalando ¿?');
  $(document).ready(function() {
    $('#myTable').DataTable();
} );
 </script>
@endpush