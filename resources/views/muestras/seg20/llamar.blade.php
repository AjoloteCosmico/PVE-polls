@extends('layouts.app')

@section('content')

<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div style="padding:30px;">
    <table>
        <tr>
            <td >
            <span class="badge badge-pill badge-primary" style="background-color: transparent" id="pildora"><h1 class="text-back-50">{{$Egresado->nombre}} {{$Egresado->paterno}} {{$Egresado->materno}}  </h1></span>
            </td><td>
            <h1 class="text-white-35" style="font-color: white">{{$Egresado->cuenta}}  </h1>
            </td>
        </tr>
        <tr>
            <td>   
                <h1 class="text-white-35" style="font-color: white">{{$Carrera->carrera}}  </h1> 
                <h1 class="text-white-35" style="font-color: white">{{$Carrera->plantel}}  </h1> 
            </td>
            <td><a href="{{route('muestras20.show',[$Egresado->carrera,$Egresado->plantel])}}"><button type="button" style="color:rgb({{Auth::user()->color}})" class="btn btn-success btn-lg">  <i class="fas fa-table"></i> Ir a muestra Carrera </button></a>
    </td>
        </tr>
        <tr> <td>  </td>
     <td><a href="{{route('muestras20.show',[0,$Egresado->plantel])}}"><button type="button" style="color:rgb({{Auth::user()->color}})" class="btn btn-success btn-lg">  <i class="fas fa-table"></i> Ir a muestra Plantel </button></a></td></tr>
     @if($Encuesta)
     @if($Encuesta->status==10)
    <tr><td colspan="2"><a href="{{route('edit_20',[$Encuesta_id,'SEARCH'])}}"> <button class="btn  btn-lg btn-block" style="background-color:{{Auth::user()->color}} ; color:white; margin: 0.1vw"> <i class="fas fa-arrow" aria-hidden="true"> </i> &nbsp; Continuar encuesta Inconclusa</button></a>
             </td></tr>@endif @endif
    </table>
  
   

        <h1 class="text-white-35" id="layer"> NUMEROS DE TELEFONO </h1>
 
   
    </div>

    <div class='col'>
        @foreach($Telefonos as $telefono)
        <div class="container">
  
  <button type="button" class="btn btn-info" id="{{'tel_button'.$telefono->id}}"data-toggle="collapse" style="background-color: {{$telefono->color_rgb}}"  data-target="{{'#demo'.$telefono->id}}">   <h1 class="text-white-35"> {{$telefono->telefono}}  </h1></button>
  <div id="{{'demo'.$telefono->id}}" class="collapse" style="background-color: rgba(0,0,0,0.2)">
  
      
<br><h1 class="text-white-40" id="layer"> RECADOS ANTERIORES </h1><br>
@if($Recados->count()==0)
<p> Aún no hay recados para mostrar </p>
@else

<table class="table text-xl ">
    <thead>
        <tr>
            <th>Recado</th>
            <th>tipo</th>
            <th>Fecha</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($Recados as $r)
        @if($r->tel_id == $telefono->id)
        <tr style="background-color: {{$r->color_rgb}};">
            <td> {{$r->recado}} </td>
            <td> {{$r->description}} </td>
            <td> {{$r->fecha}} </td>
            <td> 
            <form method="POST" action="{{ route('recados.destroy', $r->id) }}">
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">

                            <button type="submit" class="btn btn-xs btn-danger btn-flat show_confirm" data-toggle="tooltip" title='Delete'>BORRAR!</button>
                        </form>  </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>
@endif
  <form action="/encuestas/2020/marcar/{{$telefono->id}}/{{$Egresado->id}}" method="POST" enctype="multipart/form-data">
        @csrf
    

  <div class="form-group">
    <label for="exampleInputEmail1">Deja un recado</label>
    <div class="form-group">
    <label for="exampleInputEmail1">Selecciona un código de color</label>
    <select name="code" id="{{'code'.$telefono->id}}" class="select" style="color: #E0E0E0; background-color: black;" onchange="codigo({{$telefono->id}})">
        <option value=""> </option>
        @foreach($Codigos as $code)
        <option style="background-color: {{$code->color_rgb}}" value="{{$code->code}}" @if($telefono->status == $code->code) selected @endif>{{$code->description}}</option>
        
        @endforeach
       
    </select>
   </div>
    <input  style="width:70%" type="text" name="recado" class="form-control texto" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Escribe informacion util para localizar a este egresado" >
  </div>
  <br>
  <div class='row'>
    <div class='col'>
    <button type="submit" style="color:rgb({{Auth::user()->color}})" class="btn btn-primary btn-lg">  <i class="fas fa-paper-plane"></i> Marcar y guardar recado</button>
    </div>    
    <div class='col'>
        <a href="{{route('encuesta20.act_data',[$Egresado->cuenta,$Egresado->carrera])}}">
    <button type="button" style="color:rgb({{Auth::user()->color}})" class="btn btn-success btn-lg">  <i class="fas fa-file"></i> Contestar Encuesta</button></a>
    </div> 
    <div class='col'>
        <a href="{{route('muestras20.show',[$Egresado->carrera,$Egresado->plantel])}}">
    <button type="button" style="color:rgb({{Auth::user()->color}})" class="btn btn-success btn-lg">  <i class="fas fa-arrow-left"></i> Regresar a al muestra</button></a>
    </div>
  </div>
  
  </form></div>
</div>
        <br>
        @endforeach
    </div>

</div>
@stop

@section('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  
@stop

@push('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
function change_color(color,tel_id){
    document.getElementById('pildora').style.backgroundColor=color;
    document.getElementById('code'+tel_id).style.backgroundColor=color;
    document.getElementById('tel_button'+tel_id).style.backgroundColor=color;
    document.getElementById('pildora').style.color='white';
    document.getElementById('layer').style.color=color;
    document.getElementById('info').style.color=color;
}
function codigo(tel_id){
    id_codigo='code'+(tel_id);
    console.log(id_codigo)
    valor=document.getElementById(id_codigo).value;
    console.log(valor,tel_id);
    switch (valor) {
        @foreach($Codigos as $code)
  case '{{$code->code}}':
    change_color('{{$code->color_rgb}}',tel_id);
    break;
   @endforeach
  
 
}

}
</script>
<script>

  console.log('script jalando ¿?');
 
 </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">
 
     $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete this record?`,
              text: "If you delete this, it will be gone forever.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });
  
</script>
@endpush