@extends('layouts.app')

@section('content')

<div class="container-fluid cuadro-azul">
    <div>
        <table class="cuadro-azul">
            <tr>
                <td>
                    <h3>{{$Egresado->nombre}} {{$Egresado->paterno}} {{$Egresado->materno}}</h3>
                </td>
                <td>
                    <h3>{{$Egresado->cuenta}}  </h3>
                </td>
            </tr>
            <tr>
                <td>   
                    <h3>{{$Carrera->carrera}}  </h3> 
                    <h4>{{$Carrera->plantel}}  </h4> 
                </td>
                <td>
                    @if($gen==2020)
                    <a href="{{route('muestras20.show',[$Egresado->carrera,$Egresado->plantel])}}">
                        <button type="button"  class="boton-oscuro">
                            <i class="fas fa-table"></i> Ir a muestra Carrera 
                        </button>
                    </a>
                    @endif
                    @if($gen==2016)
                    <a href="{{route('muestras16.show',[$Egresado->carrera,$Egresado->plantel])}}">
                        <button type="button"  class="boton-oscuro">
                            <i class="fas fa-table"></i> Ir a muestra Carrera 
                        </button>
                    </a>
                    @endif
                    @if($gen==2022)
                    <a href="{{route('muestras22.show22',[$Egresado->carrera,$Egresado->plantel])}}">
                        <button type="button"  class="boton-oscuro">
                            <i class="fas fa-table"></i> Ir a muestra Carrera 
                        </button>
                    </a>
                    @endif

                </td>
            </tr>
            <tr>
                <td>
                    <h5>Status: {{$Codigos_all->where('code',$Egresado->status)->first()->description}}  </h5> 
                </td>
                
                <td>
                   
                </td>
            </tr>
            @if($gen==2016)
                @php  
                   $fecha=new DateTime(substr($Egresado->actualized,0,10))
                @endphp
            <td>Fecha en que se encuestó al egresado:</td>    
            <td> {{$fecha->format('j \d\e F \d\e Y')}}</td>

            @endif
            @if($Encuesta)
            @if($Encuesta->completed==0)
            <tr>
                <td colspan="2">
                 Hay una encuesta inconclusa  
                </td>
            </tr>
            @endif
            @endif
        </table>   
    </div>

    <div>
        <div class="elementos-centrados titulos">
            <h3 class="text-white-35" id="layer"> NUMEROS DE TELEFONO </h3>
        </div>
        @foreach($Telefonos as $telefono)
        <center>
        <div class="elementos-centrados">
            <button type="button" 
                class="btn btn-info" 
                id="{{'tel_button'.$telefono->id}}"
                data-toggle="collapse" 
                style="background-color: {{$telefono->color_rgb}}"  
                data-target="{{'#demo'.$telefono->id}}">

                <h3 class="text-white-40"> {{$telefono->telefono}}</h3>
            </button>
            <div id="{{'demo'.$telefono->id}}" class="collapse elementos-centrados">
                <br>
                <h3 class="text-white-40" id="layer"> RECADOS ANTERIORES</h3>
                <br>
                dd.{{ $Recados }}]
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

                                        <button type="submit" class="btn btn-danger btn-lg" data-toggle="tooltip" title='Delete'> <i class="fa fa-trash" aria-hidden="true"></i> BORRAR</button>
                                    </form>  
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                @endif
                <form action="/encuestas/2020/marcar/{{$telefono->id}}/{{$Egresado->id}}" method="POST" enctype="multipart/form-data" id="myform{{$telefono->id}}">
                @csrf
                    <div class="form-group titulos">
                        <h3 for="exampleInputEmail1">Deja un recado</h3>
                        <br>
                        <div class="form-group">
                            <h6 for="exampleInputEmail1">Selecciona un código de color</h6>
                            <br>
                            <select name="code" id="{{'code'.$telefono->id}}" class="select input"  onchange="codigo({{$telefono->id}})">
                                <option value=""> </option>
                                @foreach($Codigos as $code)
                                    <option style="background-color: {{$code->color_rgb}}" value="{{$code->code}}" @if($telefono->status == $code->code) selected @endif>{{$code->description}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="text" name="recado" class="form-control input" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Escribe informacion util para localizar a este egresado" >
                    </div>
                    <br>
                    <div class='tabla'>
                        <button type="button" onclick='check_form({{$telefono->id}})'  class="boton-dorado">
                            <i class="fas fa-paper-plane"></i> Marcar y guardar recado
                        </button>

                        <br><br><br>

                        <a href="{{route('act_data',[ $Egresado->cuenta, $Egresado->carrera,$gen,$telefono->id])}}">
                            <button type="button" class="boton-dorado">
                                <i class="fas fa-phone"></i> Actualizar datos de contacto <br>(Llamando a este numero)
                            </button>
                        </a>
                        <br><br><br>
                        <!-- TODO: hacer una ruta llamada completar encuesta -->
                    @if($Encuesta)
                        @if($gen==2020)
                        <a href="{{route('edit_20',[$Encuesta->registro,'SEARCH'])}}">
                            <button class="boton-dorado" type="button" >
                                Continuar encuesta Inconclusa
                            </button>
                        </a>
                        @endif
                        @if($gen==2022)
                        <a href="{{route('edit_22',[$Encuesta->registro,'SEARCH'])}}">
                            <button class="boton-dorado" type="button" >
                                Continuar encuesta Inconclusa
                            </button>
                        </a>
                        @endif
                        @if($gen==2016)
                        <a href="{{route('edit_16',[$Encuesta->registro,'SEARCH'])}}">
                            <button class="boton-dorado" type="button" >
                                Continuar encuesta Inconclusa
                            </button>
                        </a>
                        @endif
                    @endif
                    </div> 
                </form>
            </div>
        </div>
        </center>
        <br> 
        @endforeach
    </div>
    
    <div class='row'>
        <div class='col'>
            @if($gen==2020)
            <a href="{{route('muestras20.show',[$Egresado->carrera,$Egresado->plantel])}}">
                <button type="button"  class="boton-oscuro">
                    <i class="fas fa-table"></i> Ir a muestra Carrera 
                </button>
            </a>
            @endif
            @if($gen==2022)
                    <a href="{{route('muestras22.show22',[$Egresado->carrera,$Egresado->plantel])}}">
                        <button type="button"  class="boton-oscuro">
                            <i class="fas fa-table"></i> Ir a muestra Carrera 
                        </button>
                    </a>
            @endif
            @if($gen==2016)
            <a href="{{route('muestras16.show',[$Egresado->carrera,$Egresado->plantel])}}">
                <button type="button"  class="boton-oscuro">
                    <i class="fas fa-table"></i> Ir a muestra Carrera 
                </button>
            </a>
            @endif
        </div>
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
    console.log('tel_id:', tel_id)
    //document.getElementById('pildora').style.backgroundColor=color;
    document.getElementById('code'+tel_id).style.backgroundColor=color;
    document.getElementById('tel_button'+tel_id).style.backgroundColor=color;
    document.getElementById('layer').style.color=color;
    // document.getElementById('info').style.color=color;
}
function codigo(tel_id){
    id_codigo='code'+(tel_id);
    console.log(id_codigo);
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

<script>
    function check_form(tel_id){
        val= document.getElementById('code'+tel_id);
        console.log(val,parseInt(val));
        if(parseInt(val.value)>0){
            document.getElementById('myform'+tel_id).submit();
        }else{
            swal({
              title: `Por favor selecciona un Código`,
              text: "no detectamos que hallas seleccionado un codigo, si lo hicisté por favor selecciona otro y vuelve a seleccionar el mismo",
              icon: "warning",
              buttons: false,
          })
        }
    }
</script>
@endpush