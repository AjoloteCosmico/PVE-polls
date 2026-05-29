<div>
    @if($egresados && $egresados->count())
        <div class="table-responsive">
            <table class="table text-xl" id="myTablePosgrado">
                <thead>
                    <tr>
                        <th>Egresado</th>
                        <th>Cuenta</th>
                        <th>Generación</th>
                        <th>Programa / Plan / Especialidad </th> 
                        <th>Muestra</th>
                        <th>Status</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($egresados as $eg)
                        <tr wire:key="egr-{{ $eg->cuenta }}">
                            <td>{{ $eg->nombre }} {{ $eg->paterno }} {{ $eg->materno }}</td>
                            <td>{{ $eg->cuenta }}</td>

                            {{-- Evaluación DINÁMICA basada en la CUENTA del alumno --}}
                            @php 
                                // Si el usuario presionó un botón, tomamos ese tipo; si no, el asignado por defecto
                                $tipo = $selecciones[$eg->cuenta] ?? $eg->universo_origen;
                                
                                $anioActivo = '---';
                                $programaActivo = '---';
                                $planActivo = '---';
                                $bgColor = 'transparent';

                                if($tipo == 'posgrado') {
                                    $anioActivo = $eg->anio_posgrado ?? 'N/A';
                                    $programaActivo = $eg->programa_posgrado ?? 'No inscrito en Posgrado';
                                    $planActivo = $eg->plan_posgrado ?? '---';
                                    $bgColor = $eg->color_posgrado ?? 'transparent';
                                } 
                                elseif($tipo == 'especialidad') {
                                    $anioActivo = $eg->anio_especialidad ?? 'N/A';
                                    $programaActivo = $eg->programa_especialidad ?? 'No inscrito en Especialidad';
                                    $planActivo = $eg->plan_especialidad ?? '---';
                                    $bgColor = $eg->color_especialidad ?? 'transparent';
                                }
                            @endphp

                            {{-- Generación Dinámica --}}
                            <td>{{ $anioActivo }}</td>

                            {{-- Programa / Plan / Especialidad Dinámica --}}
                            <td>
                                <strong>{{ $programaActivo }}</strong>
                                <br>
                                <small class="text-muted">Plan: {{ $planActivo }}</small> 
                            </td>
                            
                            {{-- Botones de Control (Muestra) basados en la cuenta --}}
                            <td>
                                <div class="btn-group" role="group">
                                    {{-- Solo se muestra el botón de Posgrado si el alumno tiene registro en esa tabla --}}
                                    @if(!is_null($eg->id_posgrado))
                                        <button type="button" 
                                                wire:click="seleccionarMuestra('{{ $eg->cuenta }}', 'posgrado')" 
                                                class="boton-oscuro {{ $tipo == 'posgrado' ? 'active bg-primary border-primary' : '' }}">
                                            POSGRADO
                                        </button>
                                    @endif
                                    
                                    {{-- Solo se muestra el botón de Especialidad si el alumno tiene registro en esa tabla --}}
                                    @if(!is_null($eg->id_especialidad))
                                        <button type="button" 
                                                wire:click="seleccionarMuestra('{{ $eg->cuenta }}', 'especialidad')" 
                                                class="boton-oscuro {{ $tipo == 'especialidad' ? 'active bg-success border-success' : '' }}">
                                            ESPECIALIDAD
                                        </button>
                                    @endif
                                </div>
                            </td>
                            
                            {{-- Status Dinámico --}}
                            <td style="background-color: {{ $bgColor }}; font-weight: bold; min-width: 150px; text-align: center; vertical-align: middle;">
                                @if($tipo == 'posgrado')
                                    <span style="text-shadow: 1px 1px 2px #000; color: #fff;">
                                        {{ $eg->estado_posgrado ?? 'SIN STATUS / NO REGISTRADO' }}
                                    </span>
                                @elseif($tipo == 'especialidad')
                                    <span style="text-shadow: 1px 1px 2px #000; color: #fff;">
                                        {{ $eg->estado_especialidad ?? 'SIN STATUS / NO REGISTRADO' }}
                                    </span>
                                @else
                                    <span class="text-muted small">Seleccione una muestra</span>
                                @endif
                            </td>
                            
                            {{-- Acciones Dinámicas --}}
                            <td style="vertical-align: middle;">
                                @if($tipo == 'posgrado' && !is_null($eg->id_posgrado))
                                    @if(!is_null($eg->plan_posgrado) && !is_null($eg->programa_posgrado))
                                        
                                        @if(in_array($eg->status_posgrado_num, [null, 0, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], false))
                                            <a href="{{ route('llamar_posgrado', [$eg->cuenta, $eg->plan_posgrado, $eg->programa_posgrado]) }}">
                                                <button class="boton-oscuro">
                                                    <i class="fa fa-phone" aria-hidden="true"></i> LLAMAR POS
                                                </button>
                                            </a>
                                            <br>
                                            <small><strong>Fecha:</strong> {{ $eg->fecha_posgrado ?? 'N/A' }}</small><br>
                                            <small><strong>Aplicador:</strong> {{ $eg->aplicador_posgrado ?? 'N/A' }}</small>
                                        @endif

                                        @if(in_array($eg->status_posgrado_num, [1, 2], false))
                                            <small class="text-success"><strong><i class="fa fa-check-circle"></i> Finalizado:</strong> {{ $eg->fechaFinal_posgrado ?? 'N/A' }}</small><br>
                                            <small><strong>Aplicador:</strong> {{ $eg->aplicador_posgrado ?? 'N/A' }}</small>
                                        @endif

                                
                                        
                                    @endif

                                @elseif($tipo == 'especialidad' && !is_null($eg->id_especialidad))
                                    @if(!is_null($eg->plan_especialidad) && !is_null($eg->programa_especialidad))
                                        
                                        @if(in_array($eg->status_especialidad_num, [null, 0, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], false))
                                            <a href="{{ route('llamar_especialidad', [$eg->cuenta, $eg->programa_especialidad]) }}">
                                                <button class="boton-oscuro">
                                                    <i class="fa fa-phone" aria-hidden="true"></i> LLAMAR 
                                                </button>
                                            </a>
                                            <br>
                                            <small class="text-muted">Especialidad Pendiente</small>
                                        @endif

                                        @if(in_array($eg->status_especialidad_num, [1, 2], false))
                                            <small class="text-success d-block"><strong><i class="fa fa-check-circle"></i> Encuesta Completada</strong></small>
                                        @endif
                                        
                                    
                                    @endif
                                @else
                                    <span class="text-secondary small">No cuenta con esta opción</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $egresados->links() }}
        </div>
    @else
        <div class="alert alert-info text-center mt-3">
            No se encontraron egresados con los criterios de búsqueda especificados.
        </div>
    @endif
</div>