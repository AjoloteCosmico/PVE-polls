@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles de la Empresa</h1>

    <div class="card">
        <div class="card-header">
            Empresa: {{ $empresa->nombre }}
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $empresa->id }}</p>
            <p><strong>Usuario:</strong> {{ $empresa->usuario }}</p>
            <p><strong>Nombre:</strong> {{ $empresa->nombre }}</p>
            <p><strong>Giro:</strong> {{ $empresa->giro }}</p>
            <p><strong>Clave Giro:</strong> {{ $empresa->clave_giro }}</p>
            <p><strong>Giro Específico:</strong> {{ $empresa->giro_especfico }}</p>
            <p><strong>Nota:</strong> {{ $empresa->nota }}</p>
            <p><strong>Fecha de Creación:</strong> {{ $empresa->created_at->format('d/m/Y H:i:s') }}</p>
            <p><strong>Última Actualización:</strong> {{ $empresa->updated_at->format('d/m/Y H:i:s') }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('empresas.edit', $empresa->id) }}" class="btn btn-warning">Editar</a>
            <form action="{{ route('empresas.destroy', $empresa->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta empresa?')">Eliminar</button>
            </form>
            <a href="{{ route('empresas.index') }}" class="btn btn-secondary">Volver a la lista</a>
        </div>
    </div>
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