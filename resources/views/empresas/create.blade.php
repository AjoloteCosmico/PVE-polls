@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nueva Empresa</h1>

    <form action="{{ route('empresas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="usuario">Usuario:</label>
            <input type="text" class="form-control" id="usuario" name="usuario" required>
        </div>

        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="giro">Giro:</label>
            <input type="text" class="form-control" id="giro" name="giro" required>
        </div>

        <div class="form-group">
            <label for="clave_giro">Clave de Giro:</label>
            <input type="text" class="form-control" id="clave_giro" name="clave_giro" required>
        </div>

        <div class="form-group">
            <label for="giro_especifico">Giro Específico:</label>
            <input type="text" class="form-control" id="giro_especifico" name="giro_especifico" required>
        </div>

        <div class="form-group">
            <label for="nota">Nota:</label>
            <textarea class="form-control" id="nota" name="nota"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.1/css/buttons.dataTables.css"/>
@stop

@push('js')
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.html5.min.js"></script>
    <script>
        new DataTable('#myTable',{
            paging: false,
            layout: {
                topStart: {
                    buttons: ['print','csv','excel','copy']
                }
            }  
        });
    </script>
@endpush