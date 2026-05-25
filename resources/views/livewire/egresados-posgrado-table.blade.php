<div>
    
    {{-- Renderizado de la tabla estructurada --}}
    @if($egresados_posgrado && $egresados_posgrado->count())
        <div class="table-responsive">
            <table class="table text-xl" id="myTablePosgrado">
                <thead>
                    <tr>
                        <th>Egresado</th>
                        <th>Cuenta</th>
                        <th>Generación</th>
                        <th>Programa / Plan </th> 
                        <th>Muestra</th>
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

                            {{-- Evaluación dinámica de Programa y Plan dependiendo el botón activo --}}
                            @php 
                                $tipo = $selecciones[$egp->id] ?? null;
                                
                                // Variables dinámicas por defecto
                                $bgColor = 'transparent';
                                $estadoTexto = 'Seleccione Muestra';
                                $programaActivo = '---';
                                $planActivo = '---';

                                if($tipo == 'posgrado') {
                                    $bgColor = $egp->color_posgrado ?? 'transparent';
                                    $estadoTexto = $egp->estado_posgrado ?? 'SIN STATUS';
                                    $programaActivo = $egp->programa_posgrado;
                                    $planActivo = $egp->plan_posgrado;
                                } 
                                elseif($tipo == 'especialidad') {
                                    $bgColor = $egp->color_especialidad ?? 'transparent';
                                    $estadoTexto = $egp->estado_especialidad ?? 'SIN STATUS';
                                    $programaActivo = $egp->programa_especialidad ?? 'N/A';
                                    $planActivo = $egp->plan_especialidad ?? 'N/A';
                                }
                            @endphp

                            <td>
                                {{ $programaActivo }}
                                <small> Plan: {{ $planActivo }}</small> 
                            </td>
                            
                            {{-- Columna de Selección de Muestra (Botones de control) --}}
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" 
                                            wire:click="seleccionarMuestra({{ $egp->id }}, 'posgrado')" 
                                            class="btn {{ $tipo == 'posgrado' ? 'btn-primary' : 'btn-outline-primary' }}">
                                        Posgrado
                                    </button>
                                    
                                    {{-- El botón de especialidad se puede deshabilitar o marcar si el alumno no cuenta con registro de especialidad --}}
                                    <button type="button" 
                                            wire:click="seleccionarMuestra({{ $egp->id }}, 'especialidad')" 
                                            class="btn {{ $tipo == 'especialidad' ? 'btn-success' : 'btn-outline-success' }}"
                                            {{ !$egp->es_especialidad ? 'title=No_registrado' : '' }}>
                                        Especialidad
                                    </button>
                                </div>
                            </td>
                            
                            {{-- Color de fondo dinámico según el código de estatus --}}
                            <td style="background-color: {{ $bgColor }}; font-weight: bold; min-width: 140px;">
                                <span class="p-1 rounded">{{ $estadoTexto }}</span>
                            </td>
                            
                            {{-- Acciones Dinámicas dependiendo del origen de datos seleccionado --}}
                            <td>
                                @if($tipo == 'posgrado')
                                    {{-- Lógica de Llamadas para Posgrado --}}
                                    @if(in_array($egp->status, [null, 0, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], false))
                                        @can('ver_muestra_posgrado')
                                            <a href="{{ route('llamar_posgrado', [$egp->cuenta, $egp->plan_posgrado, $egp->programa_posgrado]) }}">
                                                <button class="boton-oscuro mb-1">
                                                    <i class="fa fa-phone"></i> LLAMAR 
                                                </button>
                                            </a>
                                        @endcan
                                        <small class="d-block text-muted"><strong>Fecha:</strong> {{ $egp->fecha_posgrado ?? 'N/A' }}</small>
                                        <small class="d-block text-muted"><strong>Aplicador:</strong> {{ $egp->aplicador_posgrado ?? 'N/A' }}</small>
                                    @endif

                                    @if(in_array($egp->status, [1, 2], false))
                                        <small class="d-block text-success"><strong>Finalizado:</strong> {{ $egp->fechaFinal_posgrado ?? 'N/A' }}</small>
                                        <small class="d-block text-muted"><strong>Aplicador:</strong> {{ $egp->aplicador_posgrado ?? 'N/A' }}</small>
                                    @endif

                                @elseif($tipo == 'especialidad')
                                    {{-- Lógica de Llamadas para Especialidad --}}
                                    @if($egp->es_especialidad)
                                        @if(in_array($egp->status_especialidad_num, [null, 0, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], false))
                                            {{-- Ajusta la ruta 'llamar_especialidad' si cuentas con ella en tu Web.php --}}
                                            <a href="{{ route('llamar_posgrado', [$egp->cuenta, $egp->plan_especialidad, $egp->programa_especialidad]) }}">
                                                <button class="btn btn-sm btn-dark mb-1">
                                                    <i class="fa fa-phone"></i> LLAMAR ESP
                                                </button>
                                            </a>
                                        @else
                                            <small class="text-success d-block">Encuesta Completada</small>
                                        @endif
                                    @else
                                        <span class="text-muted small">Sin datos de Especialidad</span>
                                    @endif
                                @else
                                    <span class="text-secondary small"><i class="fa fa-arrow-left"></i> Elija una opción</span>
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