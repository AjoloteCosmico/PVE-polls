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
    <!-- <a href="{{ route('empresas.create') }}" class="btn btn-primary mb-3">Agregar Nueva Empresa</a> -->

    <!-- Formulario de búsqueda -->
    <form method="GET" action="{{ route('empresas.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar empresa..." value="{{ request()->query('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        </div>
    </form>

    <!-- Tabla de Empresas -->
    <table class="table table-bordered" id="myTable">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Clave Giro</th>
                <th>Giro</th>
                <th>Giro Específico</th>
                <th>Sector</th>
                <th>Nota</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empresas as $empresa)
                <tr>
                    <td>
                        @if($empresa->usuario==104)	Ivan @endif
                        @if($empresa->usuario==0)	malu @endif
                        @if($empresa->usuario==20)	MALU @endif
                        @if($empresa->usuario==22)	Sandra Elizabeth Vázquez Abundes @endif
                        @if($empresa->usuario==12)	Monica Juárez Espino @endif
                        @if($empresa->usuario==17)	Eréndira Jímenez Jímenez @endif
                        @if($empresa->usuario==15)	CESAR VELAZQUEZ @endif
                        @if($empresa->usuario==21)	IVONNE JAZMIN MEZA CASTAÑEDA @endif
                        @if($empresa->usuario==23)	Sandra Pérez Jiménez @endif
                        @if($empresa->usuario==24)	Miguel Angel Herrera Ortiz @endif
                        @if($empresa->usuario==25)	Amanda Vega García @endif
                        @if($empresa->usuario==100)	Isaac Celis Vargas @endif
                    </td>
                    <td>{{ $empresa->nombre }}</td>
                    <td>{{ $empresa->clave_giro }}</td>
                    <td>
                        @if($empresa->clave_giro==1) Agricultura, ganadería, aprovechamiento forestal, caza y pesca @endif
                        @if($empresa->clave_giro==19) Asociaciones y agrupaciones @endif
                        @if($empresa->clave_giro==20) Actividades de gobierno, organismos internacionales y extraterritoriales @endif
                        @if($empresa->clave_giro==4) Construcción @endif
                        @if($empresa->clave_giro==6) Comercio al por mayor @endif
                        @if($empresa->clave_giro==7) Comercio al por menor @endif
                        @if($empresa->clave_giro==13) Dirección de corporativos y empresas @endif
                        @if($empresa->clave_giro==23) Editorial @endif
                        @if($empresa->clave_giro==3) Electricidad, agua y suministro de gas @endif
                        @if($empresa->clave_giro==5) Industrias manufactureras o de la transformación @endif
                        @if($empresa->clave_giro==9) Información en medios masivos @endif
                        @if($empresa->clave_giro==2) Minería @endif
                        @if($empresa->clave_giro==10) Servicios financieros y de seguros @endif
                        @if($empresa->clave_giro==11) Servicio inmobiliario y de alquiler de bienes muebles e intangibles @endif
                        @if($empresa->clave_giro==12) Servicios profesionales, científicos y técnicos @endif
                        @if($empresa->clave_giro==14) Servicios de apoyo a los negocios, manejo de desecho y servicios de remediación @endif
                        @if($empresa->clave_giro==15) Servicios de salud @endif
                        @if($empresa->clave_giro==16) Servicios educativos @endif
                        @if($empresa->clave_giro==17) Servicios de esparcimiento, cultural, deportivos y otros centros recreativos< @endif
                        @if($empresa->clave_giro==18) Servicios de alojamiento temporal, de preparación de alimentos y bebidas (hotel, restaurant, bar) @endif
                        @if($empresa->clave_giro==8) Transporte, correos y almacenamiento @endif
                        @if($empresa->clave_giro==22) Telecomunicaciones @endif
                        @if($empresa->clave_giro==24) Servicios Personales @endif
                        @if($empresa->clave_giro==25) Servicios  de reparacion y mantenimiento @endif
                        @if($empresa->clave_giro==21) Otro (Especifíque) @endif
                    </td>
                    <td>{{ $empresa->giro_especifico }}</td>
                    <td>
                        @if($empresa->sector==1) Público @endif
                        @if($empresa->sector==2) Privado @endif
                        @if($empresa->sector==3) Social @endif
                    </td>
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
        $(document).ready(function() {
        $('#myTable').DataTable();
        } );
    </script>
@endpush