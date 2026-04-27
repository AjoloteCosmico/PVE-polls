{{--
    Componente: table
    Variables recibidas:
        $Reactivo        -> el reactivo padre (type=table), usado para título/descripción
        $Columns         -> array de definición de columnas desde rules JSON
        $RowsNormalized  -> array de arrays de claves, ej: [['nfr5','nfr6'], ['nfr7','nfr8']]
        $ReactivosTabla  -> colección de reactivos hijos keyBy('clave')
        $Encuesta        -> modelo de la encuesta (para leer valores guardados)
        $BloqueosActivos -> colección de bloqueos activos
--}}

@php
    // Alias de posición para arreglos de múltiples reactivos por fila
    $position_aliases = ['primary', 'secondary', 'tertiary', 'quaternary'];
  

@endphp
<div class="table_container" id="{{ 'container' . $Reactivo->clave }}">

    {{-- Título opcional del bloque tabla --}}
    @if($Reactivo->description)
        <h3 class="table_title">{{ $Reactivo->description }}</h3>
    @endif

    <div class="table_wrapper">
        <table class="reactivo_table">

            {{-- ENCABEZADOS --}}
            <thead>
                <tr>
                    @php
    
@endphp
@if(isset($Columns) && !empty($Columns))
                    @foreach($Columns as $col)
                        <th>{{ $col['header'] ?? '' }}</th>
                        <!-- column header comment -->
                    @endforeach
                </tr>
            </thead>
@endif
            {{-- FILAS --}}
            <tbody>
                @if(isset($RowsNormalized))
                @foreach($RowsNormalized as $row_claves)
                
                    @php
                        // Mapear aliases de posición a claves reales de esta fila
                        // primary -> $row_claves[0], secondary -> $row_claves[1], etc.
                        $alias_map = [];
                        foreach ($row_claves as $pos => $clave) {
                            if (isset($position_aliases[$pos])) {
                                $alias_map[$position_aliases[$pos]] = $clave;
                            }
                        }
                        // null también resuelve al primer reactivo de la fila
                        $alias_map[null] = $row_claves[0] ?? null;
                    @endphp
                    @if(str_contains($row_claves[0],'label'))
                    <tr >
                        <td colspan='2'>{{ $ReactivosTabla[$row_claves[0]]->description }} </td>
                    </tr>
                    @else
                      
                    <tr>
                        @foreach($Columns as $col)
                            @php
                                $col_source   = $col['source']   ?? 'description';
                                $col_reactivo = $col['reactivo'] ?? null;

                                // Resolver qué clave de reactivo aplica a esta celda
                                $clave_celda = $alias_map[$col_reactivo] ?? ($row_claves[0] ?? null);
                                $reactivo_celda = $clave_celda ? ($ReactivosTabla[$clave_celda] ?? null) : null;
                            @endphp

                            <td>
                                
                                @if(!$reactivo_celda)
                                    {{-- Reactivo no encontrado, celda vacía --}}

                                @elseif($col_source === 'description')
                                    {{-- Solo mostrar texto, sin input --}}
                                    <span class="table_description">
                                       {{$reactivo_celda->orden}}.- {{ $reactivo_celda->description ?? $reactivo_celda->question ?? '' }}
                                    </span>

                                @elseif($col_source === 'label')
                                    {{-- Texto fijo definido en la columna --}}
                                    <span class="table_label">{{ $col['value'] ?? '' }}</span>

                                @elseif($col_source === 'component')
                                    @php
                                        // Verificar bloqueo para este reactivo hijo
                                        $is_bloqueado = $BloqueosActivos->contains('bloqueado', $reactivo_celda->clave);

                                        // Leer valor guardado desde el modelo encuesta
                                        $field = $reactivo_celda->clave;
                                        $valor_guardado = $Encuesta->$field ?? null;
                                    @endphp

                                    {{-- Llamar RenderReactive igual que en section.blade --}}
                                    <div id="container{{$reactivo_celda->clave}}">
                                        {{$reactivo_celda->clave}}
                                    {{ \App\Http\Controllers\ComponentController::RenderReactive(
                                        $reactivo_celda,
                                        collect(),        // RenderReactive recarga opciones internamente
                                        $valor_guardado,
                                        $is_bloqueado
                                    ) }}
                                    </div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                    @endif
                @endforeach
                @endif
            </tbody>

        </table>
    </div>
</div>