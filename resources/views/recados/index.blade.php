@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
<div class='row'>
      <div class='col'> </div>
      <div class='col'></div>
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
<div class="col-6 col-lg-12 table-responsive">
        <table class="table text-xl " id="myTable">
        <thead>
        <tr>
          <th>cuenta</th>
          <th>telefono</th>
            <th>Recado</th>
            <th>tipo</th>
            <th>Fecha</th>
            @can('recados_global')
                <th>Hecho por</th>
            @endcan
            <th>Muestra</th>
        </tr>
    </thead>
    <tbody>
        @foreach($Recados as $r)
        <tr style="background-color: {{$r->color_rgb}};">
            <td> {{$r->cuenta}} </td>
            <td> {{$r->telefono}} </td>
            <td> {{$r->recado}} </td>
            <td> {{$r->description}} </td>
            <td> {{$r->fecha}} </td>
            @can('recados_global')
            @if(isset($r->encuestador))
            <td>{{ $r->encuestador }}</td>
            @endif
            @endcan
            <td> {{$r->type}} </td>
            
        </tr>
        @endforeach
    </tbody>
        </table>
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
  new DataTable('#myTable', {
    fixedHeader: true,
    pageLength: 25,
    scroller: true,
    responsive: true,
    order: [[4, 'desc'], [0, 'asc'], [1, 'asc']],
    });
    
  
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