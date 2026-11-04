@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h2>Reportes y métricas</h2>
            <p class="text-muted">
                Esta vista actúa como contenedor de tabs. Cada pestaña debe consumir un payload estandarizado
                preparado por un servicio de reportes.
            </p>
        </div>

        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab-general">General</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-seguimiento">Seguimiento</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-actualizacion">Actualización</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-posgrado">Posgrado</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-especialidad">Especialidad</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-sondeo">Sondeo</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-correos">Correos</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-actividad">Actividad</a></li>
        </ul>

        <div class="tab-content mt-4">
            <div id="tab-general" class="tab-pane active">
                @include('stats.tabs.general')
            </div>
            <div id="tab-seguimiento" class="tab-pane fade">
                @include('stats.tabs.seguimiento')
            </div>
            <div id="tab-actualizacion" class="tab-pane fade">
                @include('stats.tabs.actualizacion')
            </div>
            <div id="tab-posgrado" class="tab-pane fade">
                @include('stats.tabs.posgrado')
            </div>
            <div id="tab-especialidad" class="tab-pane fade">
                @include('stats.tabs.especialidad')
            </div>
            <div id="tab-sondeo" class="tab-pane fade">
                @include('stats.tabs.sondeo')
            </div>
            <div id="tab-correos" class="tab-pane fade">
                @include('stats.tabs.correos')
            </div>
            <div id="tab-actividad" class="tab-pane fade">
                @include('stats.tabs.actividad')
            </div>
        </div>
    </div>
@endsection
