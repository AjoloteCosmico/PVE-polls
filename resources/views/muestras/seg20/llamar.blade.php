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
                 Año: {{$Egresado->anio_egreso}}  
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

    <div id="contaider-telefonos">
        <div class="elementos-centrados titulos">
            <h3 class="text-white-35" id="layer"> NUMEROS DE TELEFONO </h3>
        </div>
        @foreach($Telefonos as $telefono)
        <center>
        <div class="elementos-centrados tel-ind" >
            <button type="button" 
                class="btn btn-info" 
                id="{{'tel_button'.$telefono->id}}"
                data-toggle="collapse" 
                style="background-color: {{$telefono->color_rgb}}"  
                data-target="{{'#demo'.$telefono->id}}">

                <h3 class="text-white-40"> {{$telefono->telefono}}</h3>
            </button>
            <div id="{{'demo'.$telefono->id}}" class="collapse elementos-centrados tel-contorno" >
                <br>
                @include('recados.recados_tabla')
                <form action="/encuestas/2020/marcar/{{$telefono->id}}/{{$Egresado->id}}" method="POST" enctype="multipart/form-data" id="myform{{$telefono->id}}">
                    @csrf
                    @include('recados.recado_form_content')
                </form>
                        <br><br>
                <div class="row  tel-contorno-div">
                    <div class="col tel-contorno-div"> 
                        <a href="{{route('act_data',[ $Egresado->cuenta, $Egresado->carrera,$gen,$telefono->id])}}">
                            <button type="button" class="boton-dorado">
                                <i class="fas fa-phone"></i> Actualizar datos de contacto <br>(Llamando a este numero)
                            </button>
                        </a>
                    </div>
                   <div class="col tel-contorno-div"> 
                         @if($Encuesta)
                        @if($gen==2020)
                        @can('aplicar_encuesta_seguimiento')
                        <a href="{{route('edit_20',[$Encuesta->registro,'SEARCH'])}}">
                            <button class="boton-dorado" type="button" >
                               <i class="fas fa-file-pen"></i>  Continuar encuesta Inconclusa
                            </button>
                        </a>
                        @endcan
                        @endif
                        
                        @if($gen==2022 && $Encuesta->completed==0)
                        @can('aplicar_encuesta_seguimiento')
                        <a href="{{route('edit_22',[$Encuesta->registro,'SEARCH'])}}">
                            <button class="boton-dorado" type="button" >
                              <i class="fas fa-file-pen"></i>   Continuar encuesta Inconclusa
                            </button>
                        </a>
                        @endcan
                        @endif

                        @if($gen==2016)
                        @can('aplicar_encuesta_actualizacion')
                        <a href="{{route('edit_16',[$Encuesta->registro,'SEARCH'])}}">
                            <button class="boton-dorado" type="button" >
                              <i class="fas fa-file-pen"></i>  Continuar encuesta Inconclusa
                            </button>
                        </a>
                        @endcan
                        @endif
                    @endif
                    </div>
                </div>
                        
                        <!-- TODO: hacer una ruta llamada completar encuesta -->
                   
                    </div> 
                
            </div>
        </center>
        <br> 
        @endforeach
    </div>
    
    <div class='row tel-contorno-div'>
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
<script>
    $('.DeleteReg').submit(function(e) {
    e.preventDefault();
    Swal.fire({
        title: '¿Estás seguro de querer eliminar el RECADO?',
        html: " <p style='color: white;'>¡No podrás revertir esto!</p>",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '¡Sí, eliminar Registro!'
    }).then((result) => {
        if (result.isConfirmed) {
            // document.getElementById('loader').style.display = 'flex';
            this.submit();
        }
    })
});
</script>
@endpush