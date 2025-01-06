@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Empresa</h1>

    <form action="{{ route('empresas.update', $empresa->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $empresa->nombre }}" required>
        </div>

        <div class="form-group">
            <label for="clave_giro">Giro:</label>
            <select id="clave_giro" name="clave_giro">
                <option value=1 @if($empresa->clave_giro==1) selected @endif> Agricultura, ganadería, aprovechamiento forestal, caza y pesca</option>
                <option value=19 @if($empresa->clave_giro==19) selected @endif>Asociaciones y agrupaciones</option>
                <option value=20 @if($empresa->clave_giro==20) selected @endif>Actividades de gobierno, organismos internacionales y extraterritoriales</option>
                <option value=4 @if($empresa->clave_giro==4) selected @endif>Construcción</option>
                <option value=6 @if($empresa->clave_giro==6) selected @endif>Comercio al por mayor</option>
                <option value=7 @if($empresa->clave_giro==7) selected @endif>Comercio al por menor</option> 
                <option value=13 @if($empresa->clave_giro==13) selected @endif>Dirección de corporativos y empresas</option>
                <option value=23 @if($empresa->clave_giro==23) selected @endif>Editorial</option>
                <option value=3 @if($empresa->clave_giro==3) selected @endif>Electricidad, agua y suministro de gas</option>
                <option value=5 @if($empresa->clave_giro==5) selected @endif>Industrias manufactureras o de la transformación</option>
                <option value=9 @if($empresa->clave_giro==9) selected @endif>Información en medios masivos</option>
                <option value=2 @if($empresa->clave_giro==2) selected @endif>Minería</option>
                <option value=10 @if($empresa->clave_giro==10) selected @endif>Servicios financieros y de seguros</option>
                <option value=11 @if($empresa->clave_giro==11) selected @endif>Servicio inmobiliario y de alquiler de bienes muebles e intangibles</option>
                <option value=12 @if($empresa->clave_giro==12) selected @endif>Servicios profesionales, científicos y técnicos</option>
                <option value=14 @if($empresa->clave_giro==14) selected @endif>Servicios de apoyo a los negocios, manejo de desecho y servicios de remediación</option>
                <option value=15 @if($empresa->clave_giro==15) selected @endif>Servicios de salud</option>
                <option value=16 @if($empresa->clave_giro==16) selected @endif>Servicios educativos</option>
                <option value=17 @if($empresa->clave_giro==17) selected @endif>Servicios de esparcimiento, cultural, deportivos y otros centros recreativos</option>
                <option value=18 @if($empresa->clave_giro==18) selected @endif>Servicios de alojamiento temporal, de preparación de alimentos y bebidas (hotel, restaurant, bar) </option>
                <option value=8 @if($empresa->clave_giro==8) selected @endif>Transporte, correos y almacenamiento</option>
                <option value=22 @if($empresa->clave_giro==22) selected @endif>Telecomunicaciones </option>
                <option value=24 @if($empresa->clave_giro==24) selected @endif>Servicios Personales </option>
                <option value=25 @if($empresa->clave_giro==25) selected @endif>Servicios  de reparacion y mantenimiento </option>
                <option value=21 @if($empresa->clave_giro==21) selected @endif>Otro (Especifíque)</option>
             </select>
        </div>

        <div class="form-group">
            <label for="giro_especifico">Giro Específico:</label>
            <input type="text" class="form-control" id="giro_especifico" name="giro_especifico" value="{{ $empresa->giro_especifico }}" required>
        </div>

        <div class="form-group">
            <label for="sector">Sector:</label>
            <select id="sector" name="sector">
                <option value=1 @if($empresa->sector==1) selected @endif>Público</option>
                <option value=2 @if($empresa->sector==2) selected @endif>Privado</option>
                <option value=3 @if($empresa->sector==3) selected @endif>Social</option>
             </select>
        </div>

        <div class="form-group">
            <label for="nota">Nota:</label>
            <textarea class="form-control" id="nota" name="nota">{{ $empresa->nota }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <input type="button" class="btn btn-primary" value="Cancelar" onclick="history.back()"/>
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
        $(document).ready(function() {
        $('#myTable').DataTable();
        } );
    </script>
@endpush