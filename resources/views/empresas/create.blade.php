@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nueva Empresa</h1>

    <form action="{{ route('empresas.store') }}" method="POST">
        @csrf
        <div class="form-group" hidden>
            <label for="usuario">Usuario:</label>
            <input type="text" class="form-control" id="usuario" name="usuario" value="{{Auth::user()->clave}}">
        </div>

        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="clave_giro">Giro:</label>
            <select id="clave_giro" name="clave_giro">
                <option value=1 selected > Agricultura, ganadería, aprovechamiento forestal, caza y pesca</option>
                <option value=19 selected >Asociaciones y agrupaciones</option>
                <option value=20 selected >Actividades de gobierno, organismos internacionales y extraterritoriales</option>
                <option value=4 selected >Construcción</option>
                <option value=6 selected >Comercio al por mayor</option>
                <option value=7 selected >Comercio al por menor</option> 
                <option value=13 selected >Dirección de corporativos y empresas</option>
                <option value=23 selected >Editorial</option>
                <option value=3 selected >Electricidad, agua y suministro de gas</option>
                <option value=5 selected >Industrias manufactureras o de la transformación</option>
                <option value=9 selected >Información en medios masivos</option>
                <option value=2 selected >Minería</option>
                <option value=10 selected >Servicios financieros y de seguros</option>
                <option value=11 selected >Servicio inmobiliario y de alquiler de bienes muebles e intangibles</option>
                <option value=12 selected >Servicios profesionales, científicos y técnicos</option>
                <option value=14 selected >Servicios de apoyo a los negocios, manejo de desecho y servicios de remediación</option>
                <option value=15 selected >Servicios de salud</option>
                <option value=16 selected >Servicios educativos</option>
                <option value=17 selected >Servicios de esparcimiento, cultural, deportivos y otros centros recreativos</option>
                <option value=18 selected >Servicios de alojamiento temporal, de preparación de alimentos y bebidas (hotel, restaurant, bar) </option>
                <option value=8 selected >Transporte, correos y almacenamiento</option>
                <option value=22 selected >Telecomunicaciones </option>
                <option value=24 selected >Servicios Personales </option>
                <option value=25 selected >Servicios  de reparacion y mantenimiento </option>
                <option value=21 selected >Otro (Especifíque)</option>
             </select>
        </div>

        <div class="form-group">
            <label for="giro_especifico">Giro Específico:</label>
            <input type="text" class="form-control" id="giro_especifico" name="giro_especifico" required>
        </div>

        <div class="form-group">
            <label for="sector">Sector:</label>
            <select id="sector" name="sector">
                <option value=1>Público</option>
                <option value=2>Privado</option>
                <option value=3>Social</option>
             </select>
        </div>

        <div class="form-group" hidden>
            <input type="text" class="form-control" id="registro" name="registro" value="-1">
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
@endpush