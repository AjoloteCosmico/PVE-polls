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
                        <tr wire:key="egr-{{ $egp->universo_origen }}-{{ $egp->id_original }}">
                            <td>{{ $egp->nombre }} {{ $egp->paterno }} {{ $egp->materno }}</td>
                            <td>{{ $egp->cuenta }}</td>
                            <td>{{ $egp->anio_egreso ?? 'N/A' }}</td>

                            {{-- Evaluación dinámica de Programa y Plan dependiendo el botón activo --}}
                            @php 
                                // ID compuesto único para el estado de selección de Livewire
                            $idFila = $egp->universo_origen . '-' . $egp->id_original;
                            
                            // Si el usuario no ha hecho click, definimos el botón activo según su origen real
                            $tipo = $selecciones[$idFila] ?? $egp->universo_origen;
                            
                            $bgColor = 'transparent';
                            $estadoTexto = 'Seleccione Muestra';
                            $programaActivo = '---';
                            $planActivo = '---';

                            if($tipo == 'posgrado') {
                                $bgColor = $egp->color_posgrado ?? 'transparent';
                                $estadoTexto = $egp->estado_posgrado ?? 'SIN STATUS / NO REGISTRADO';
                                $programaActivo = $egp->programa_posgrado ?? 'No inscrito en Posgrado';
                                $planActivo = $egp->plan_posgrado ?? '---';
                            } 
                            elseif($tipo == 'especialidad') {
                                $bgColor = $egp->color_especialidad ?? 'transparent';
                                $estadoTexto = $egp->estado_especialidad ?? 'SIN STATUS / NO REGISTRADO';
                                $programaActivo = $egp->programa_especialidad ?? 'No inscrito en Especialidad';
                                $planActivo = $egp->plan_especialidad ?? '---';
                            }
                            @endphp

                            <td>
                                {{ $programaActivo }}
                                <br>
                                <small> Plan: {{ $planActivo }}</small> 
                            </td>
                            
                            {{-- Columna de Selección de Muestra (Botones de control) --}}
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" 
                                            wire:click="seleccionarMuestra('{{ $idFila }}', 'posgrado')" 
                                            class="btn {{ $tipo == 'posgrado' ? 'btn-primary' : 'btn-outline-primary' }}"
                                            {{ is_null($egp->status_posgrado_num) && is_null($egp->estado_posgrado) ? 'disabled title=Sin_registro_de_posgrado' : '' }}>
                                        Posgrado
                                    </button>
                                    
                                    {{-- El botón de especialidad se puede deshabilitar o marcar si el alumno no cuenta con registro de especialidad --}}
                                    <button type="button" 
                                            wire:click="seleccionarMuestra('{{ $idFila }}', 'especialidad')" 
                                            class="btn {{ $tipo == 'especialidad' ? 'btn-success' : 'btn-outline-success' }}"
                                            {{ is_null($egp->id_especialidad) ? 'disabled title=Sin_registro_de_especialidad' : '' }}>
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
                                @if($tipo == 'posgrado' && !is_null($egp->status_posgrado_num))
                                    {{-- Lógica de Llamadas para Posgrado --}}
                                    @if(in_array($egp->status_posgrado_num, [null, 0, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], false))
                                        @can('ver_muestra_posgrado')
                                            <a href="">
                                                <button class="boton-oscuro mb-1">
                                                    <i class="fa fa-phone"></i> LLAMAR 
                                                </button>
                                            </a>
                                        @endcan
                                        <small class="d-block text-muted"><strong>Fecha:</strong> {{ $egp->fecha_posgrado ?? 'N/A' }}</small>
                                        <small class="d-block text-muted"><strong>Aplicador:</strong> {{ $egp->aplicador_posgrado ?? 'N/A' }}</small>
                                    @endif

                                    @if(in_array($egp->status_posgrado_num, [1, 2], false))
                                        <small class="d-block text-success"><strong>Finalizado:</strong> {{ $egp->fechaFinal_posgrado ?? 'N/A' }}</small>
                                        <small class="d-block text-muted"><strong>Aplicador:</strong> {{ $egp->aplicador_posgrado ?? 'N/A' }}</small>
                                    @endif

                                @elseif($tipo == 'especialidad' && !is_null($egp->id_especialidad))
                                    {{-- Lógica de Llamadas para Especialidad --}}
                                    @if($egp->id_especialidad)
                                        @if(in_array($egp->status_especialidad_num, [null, 0, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], false))
                                            {{-- Ajusta la ruta 'llamar_especialidad' si cuentas con ella en tu Web.php --}}
                                            <a href="">
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