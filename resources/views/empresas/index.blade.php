@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Listado de Empresas</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Botón para agregar una nueva empresa -->
    <a href="{{ route('empresas.create') }}" class="btn btn-primary mb-3">Agregar Nueva Empresa</a>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="{{ route('empresas.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar empresa..." value="{{ request()->query('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        </div>
    </form>

    <!-- Tabla de Empresas -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Giro</th>
                <th>Clave Giro</th>
                <th>Giro Específico</th>
                <th>Nota</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empresas as $empresa)
                <tr>
                    <td>{{ $empresa->usuario }}</td>
                    <td>{{ $empresa->nombre }}</td>
                    <td>{{ $empresa->giro }}</td>
                    <td>{{ $empresa->clave_giro }}</td>
                    <td>{{ $empresa->giro_especifico }}</td>
                    <td>{{ $empresa->nota }}</td>
                    <td>
                    @if($empresa->usuario == Auth::user()->clave || Auth::user()->confidential >= 2)
                        <a href="{{ route('empresas.edit', $empresa->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('empresas.destroy', $empresa->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar esta empresa?');">Eliminar</button>
                        </form>
                    @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginación -->
    {{ $empresas->links() }}
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
        new DataTable('#myTable', {
            paging: false,
            layout: {
                topStart: {
                    buttons: ['print','csv','excel','copy']
                }
            }
                
        });
    </script>
@endpush