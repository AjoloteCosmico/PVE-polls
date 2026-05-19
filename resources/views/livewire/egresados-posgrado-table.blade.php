<div> {{-- ÚNICA ETIQUETA RAÍZ COMPONENTE --}}
    
    {{-- Buscadores locales e indicador de carga --}}
    <div class="row mb-3 align-items-center">
        <div class="col-md-4">
            <input type="text" 
                   wire:model.live.debounce.300ms="nc" 
                   class="form-control" 
                   placeholder="Buscar por número de cuenta (Posgrado)">
        </div>
        <div class="col-md-4">
            <input type="text" 
                   wire:model.live.debounce.300ms="nombre_completo" 
                   class="form-control" 
                   placeholder="Buscar por nombre (Posgrado)">
        </div>
        <div class="col-md-4">
            <div wire:loading class="spinner-border text-primary spinner-border-sm" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
    </div>  

    {{-- Renderizado de la tabla estructurada --}}
    @if($egresados_posgrado && $egresados_posgrado->count())
        <div class="table-responsive">
            <table class="table text-xl" id="myTablePosgrado">
                <thead>
                    <tr>
                        <th>Egresado</th>
                        <th>Cuenta</th>
                        <th>Generación</th>
                        <th>Programa</th>
                        <th>Plan</th>
                        <th>Status</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($egresados_posgrado as $egp)
                        <tr wire:key="egresado-posgrado-{{ $egp->id }}">
                            <td>{{ $egp->nombre }} {{ $egp->paterno }} {{ $egp->materno }}</td>
                            <td>{{ $egp->cuenta }}</td>
                            <td>{{ $egp->anio_egreso }}</td>
                            <td>{{ $egp->programa }}</td>     
                            <td>{{ $egp->plan }}</td>
                            
                            {{-- Color de fondo dinámico según el código de estatus --}}
                            <td style="background-color: {{ $egp->color_codigo ?? 'transparent' }}; font-weight: bold;">
                                {{ $egp->estado ?? 'SIN STATUS' }}
                            </td>
                            
                            <td>
                                {{-- Condición 1: Estatus pendientes, parciales o nulos --}}
                                @if(in_array($egp->status, [null, 0, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], false))
                                    @can('ver_muestra_posgrado')
                                        <a href="{{ route('llamar_posgrado', [$egp->cuenta, $egp->plan, $egp->programa]) }}">
                                            <button class="boton-oscuro mb-2">
                                                <i class="fa fa-phone" aria-hidden="true"></i> &nbsp; LLAMAR 
                                            </button>
                                        </a>
                                    @endcan
                                    <br>
                                    <small class="d-block"><strong>Fecha:</strong> {{ $egp->fecha_posgrado ?? 'N/A' }}</small>
                                    <small class="d-block"><strong>Aplicador:</strong> {{ $egp->aplicador_posgrado ?? 'N/A' }}</small>
                                @endif

                                {{-- Condición 2: Ya encuestados exitosamente --}}
                                @if(in_array($egp->status, [1, 2], false))
                                    <small class="d-block"><strong>Fecha:</strong> {{ $egp->fechaFinal_posgrado ?? 'N/A' }}</small>
                                    <small class="d-block"><strong>Aplicador:</strong> {{ $egp->aplicador_posgrado ?? 'N/A' }}</small>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        
    @else
        <div class="alert alert-info text-center mt-3">
            No se encontraron egresados de posgrado con los criterios de búsqueda especificados.
        </div>
    @endif

</div> 