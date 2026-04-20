@extends('layouts.app')

@section('content')

<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div >
     <div class='row'>
      <div class='col'><h1 class="text-white-25"> {{$programa}} </h1> 
    <h1 class="text-white-25" >{{$plan}}  </h1> 
    </div>
      <div class='col'>
          <a href="{{route('muestrasposgrado.index',$programa)}}">
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
            @if($programa==0)
            <th> Programa</th>
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
                @if($programa==0)
            <td> {{$e->name_programa}} </td>
            @endif
               <td>{{ $e->llamadas ?? 0 }}</td>
               <td @if($e->description=='') class='focoso' @endif> {{$e->description}}</td>
                <td> 
                <p hidden> {{$e->orden}}</p>
                <!-- generalizar el metodo de llamada :O -->
                <a href="{{route('llamar_posgrado',[$e->cuenta,$e->plan,$e->programa])}}"> <button class="boton-oscuro"> <i class="fa fa-phone" aria-hidden="true"> </i> &nbsp; LLAMAR </button></a>             
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
        <div class="row">
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
          <!-- TODO: boton de TERMINÉ LA VUELTA (pide confirmación)  enviará los correos a quienes no contestarón y aumenta el num de vuelta-->
           <!-- <div class="col">
                <button class="boton-oscuro" onclick="confirmarTerminarVuelta()"><i class="fa fa-check" aria-hidden="true"> </i> TERMINÉ LA VUELTA</button>
           </div>
           -->
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
    @if($programa>0)
    paging: false,
    @else
    pageLength: 300,
    @endif
    responsive: true,
    sorting: [[6, 'asc'],[1, 'asc'],[2,'asc']],
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('encuesta') == 'ok')

<script type="text/javascript">
  Swal.fire({
  title: "Encuesta realizada",
  text: "La encuesta se guardo con exito",
  icon: "success",
});
</script>

@endif
 
<script>
  function confirmarTerminarVuelta() {
    Swal.fire({
      title: '¿Estás seguro de que quieres terminar la vuelta?',
      html: " <p style='color: #ffffff;'> Esto enviará correos a quienes no contestaron y aumentará el número de vuelta.</p>",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, terminar la vuelta',
      cancelButtonText: 'No, cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        // Aquí puedes agregar la lógica para enviar los correos y aumentar el número de vuelta
        Swal.fire(
          '¡Vuelta terminada!',
          'Los correos han sido programados y el número de vuelta ha sido actualizado.',
          'success'
        )
      }
    })
  }
</script>
@endpush