@extends('layouts.app')

@section('content')

<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div >
    <span class="badge badge-pill badge-primary" id="pildora"><h1 class="text-back-50">{{$Egresado->nombre}} {{$Egresado->paterno}} {{$Egresado->materno}}  </h1>
    </span>
    <h1 class="text-white-40" id="info">{{$Egresado->carrera}} {{$Egresado->plantel}}  </h1>
        <h1 class="text-white-40" id="layer"> Dejar un recado </h1>
    </div>
    <form action="{{ route('marcar_14',$Egresado->registro)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
    <label for="exampleInputEmail1">Selecciona un código de color</label>
    <select name="code" id="code" class="select"  onchange="codigo()">
        <option value=""> </option>
        <option style="background-color: #f54242" value="3" @if($Egresado->status == 3) selected @endif>Llamar en un horario específico </option>
        <option style="background-color: #9342f5" value="4" @if($Egresado->status == 4) selected @endif>Ya no quiere que le llamemos</option>
        <option style="background-color: #404040" value="5"@if($Egresado->status == 5) selected @endif>Egresado fallecido  </option>
        <option style="background-color: #3badc4" value="6"@if($Egresado->status == 6) selected @endif>Equivocado/No existe </option>
        <option style="background-color: #db8560" value="7"@if($Egresado->status == 6) selected @endif>No contesta </option>
        
    </select>
   </div>
<br><h1 class="text-white-40" id="layer"> RECADOS ANTERIORES </h1><br>
@if($Recados->count()==0)
<p> Aún no hay recados para mostrar </p>
@else

<table class="table text-xl ">
    <thead>
        <tr>
            <th>Recado</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach($Recados as $r)
        <tr style="background-color: {{$r->color}};">
            <td> {{$r->recado}} </td>
            <td> {{$r->fecha}} </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

  <div class="form-group">
    <label for="exampleInputEmail1">Deja un recado</label>
    <input  type="text" name="recado" class="form-control texto" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Escribe informacion util para localizar a este egresado" >
  </div>
  <br>
  <div class='row'>
    <div class='col'>
    <button type="submit"  class="btn btn-primary btn-lg">  <i class="fas fa-paper-plane"></i> Marcar y guardar recado</button>
    </div>
    <div class='col'>
    <button type="button" class="btn btn-danger btn-lg">  <i class="fas fa-times"></i> Cancelar</button>
    </div>
  </div>
  
  </form>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
@stop

@push('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

<script>
function change_color(color){
    document.getElementById('pildora').style.backgroundColor=color;
    document.getElementById('code').style.backgroundColor=color;
    document.getElementById('pildora').style.color='white';
    document.getElementById('layer').style.color=color;
    document.getElementById('info').style.color=color;
}
function codigo(){
    valor=document.getElementById('code').value;
    console.log(valor);
    switch (valor) {
  case '3':
    change_color('#f54242');
    break;
    case '4':
    change_color('#9342f5');
    break;
    case '5':
    change_color('#6c6b6b');
    break;
    case '6':
    change_color('#3badc4');
    break;
    case '7':
    change_color('#db8560');
    break;
  
 
}

}
codigo();
</script>
<script>
 
  console.log('script jalando ¿?');
  $(document).ready(function() {
    $('#myTable').DataTable();
} );
 </script>
@endpush