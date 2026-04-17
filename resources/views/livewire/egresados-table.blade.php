<div>
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" 
                   wire:model.live.debounce.300ms="nc" 
                   class="form-control" 
                   placeholder="Buscar por número de cuenta">
        </div>
        <div class="col-md-4">
            <input type="text" 
                   wire:model.live.debounce.300ms="nombre_completo" 
                   class="form-control" 
                   placeholder="Buscar por nombre">
        </div>
    </div>  
    <div class="col-6 col-sm-12 table-responsive">
        <table class="table  text-xl">
            <thead>
                <tr>
                    <th>Egresado</th>
                    <th>Cuenta</th>
                    <th>Gen</th>
                    <th>Carrera</th>
                    <th>Plantel</th>
                    <th>Muestra</th>
                    <th>Status</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($egresados as $eg)
                <tr wire:key="egresado-{{ $eg->id }}">
                    <td>{{$eg->nombre}} {{$eg->paterno}} {{$eg->materno}}</td>
                    <td>{{$eg->cuenta}}</td>
                    <td>{{$eg->anio_egreso}}</td>
                    <td>{{$eg->nombre_carrera}}</td>     
                    <td>{{$eg->nombre_plantel}}</td>
                    <td>
                        <div class="btn-group">
                            @if($eg->muestra==5||$eg->act_suvery==1)
                            <button wire:click="seleccionarMuestra({{$eg->id}}, 'licenciatura')" class="boton-oscuro">
                                 LICENCIATURA
                            </button>
                            @endif
                            @if($eg->es_muestra)
                            <button wire:click="seleccionarMuestra({{$eg->id}}, 'continua')" class="boton-oscuro">
                                 CONTINUA
                            </button>
                            @endif
                            
                        </div>
                    </td>

                    @php 
                        $tipo = $selecciones[$eg->id] ?? null; 
                    @endphp

                    {{-- Status Dinámico --}}
                    <td style="background-color: {{ $tipo == 'licenciatura' ? $eg->color_codigo : ($tipo == 'continua' ? $eg->color_continua : 'transparent') }};">
                        @if($tipo == 'licenciatura')
                            {{-- Muestra el estado que viene de la tabla 'codigos' --}}
                             {{ $eg->estado_lic ?? '---' }}

                        @elseif($tipo == 'continua')
                            {{-- Muestra el estado que viene de la tabla 'egresado_muestra' --}}
                            {{ $eg->descripcion_continua ?? '-----' }}
        
                        @else
                            <span class="text-muted small">Seleccione una muestra</span>
                        @endif
                    </td>

                    {{-- Acciones Dinámicas --}}
                    <td>
                        @if($tipo == 'licenciatura')

                            @if($eg->muestra==5 && in_array($eg->status,[null,0,3,4,5,6,7,8,9,10,6,11,12], false))
                                <a href="{{route('llamar',['2022',$eg->cuenta,$eg->carrera])}}">
                                    <button class="boton-oscuro">
                                        <i class="fa fa-phone" aria-hidden="true"> </i> LLAMAR
                                    </button> 
                                </a>
                                <br>
                                    <small><strong>Fecha:</strong> {{ $eg->fecha_22 ?? 'N/A' }}</small><br>
                                    <small><strong>Aplicador:</strong> {{ $eg->aplicador22 ?? 'N/A' }}</small>
                                    <br>
                                    @if($eg->r20_nbr2 != null && $eg->r20_completed != 1)
                                        <small><strong>Encuesta Inconclusa</strong></small>
                                    @endif
                            @endif
                            <!-- si esta encuestado por llamada o internet solo muestra datos del encuestador -->
                            @if($eg->muestra==5 && in_array($eg->status,[1,2], false))
                                <small><strong>Fecha:</strong> {{ $eg->fechaFinal_22 ?? 'N/A' }}</small><br>
                                <small><strong>Aplicador:</strong> {{ $eg->aplicador22 ?? 'N/A' }}</small>
                            @endif

                            @if($eg->act_suvery==1 && in_array($eg->status,[null,0,3,4,5,6,7,8,9,10,6,11,12], false))
                                <a href="{{route('llamar',['2016',$eg->cuenta,$eg->carrera])}}">
                                    <button class="boton-oscuro">
                                        <i class="fa fa-phone" aria-hidden="true"> </i> &nbsp; LLAMAR 
                                    </button>
                                </a>
                                <br>
                                    <small><strong>Fecha:</strong> {{ $eg->fecha_16 ?? 'N/A' }}</small><br>
                                    <small><strong>Aplicador:</strong> {{ $eg->aplicador16 ?? 'N/A' }}</small>
                                    <br>
                                    @if($eg->r16_nbr2 != null && $eg->r16_completed != 1)
                                        <small><strong>Encuesta Inconclusa</strong></small>
                                    @endif
                            @endif
                            <!-- si esta encuestado por llamada o internet solo muestra datos del encuestador -->
                            @if($eg->act_suvery==1 && in_array($eg->status,[1,2], false))
                                <small><strong>Fecha:</strong> {{ $eg->fechaFinal_16 ?? 'N/A' }}</small><br>
                                <small><strong>Aplicador:</strong> {{ $eg->aplicador16 ?? 'N/A' }}</small>
                            @endif
                            
                        @elseif($tipo == 'continua')
                             @if(in_array($eg->estado_continua,[null,0,3,4,5,6,7,8,9,10,6,11,12]))
                                <a href="{{route('llamar_continua',[$eg->anio_egreso,$eg->cuenta,$eg->carrera, 897])}}" >
                                    <button class="boton-oscuro">
                                        <i class="fa fa-phone" aria-hidden="true"> </i> &nbsp; LLAMAR 
                                    </button>
                                </a>
                                <br>
                                    <small><strong>Fecha:</strong></small><br>
                                    <small><strong>Aplicador:</strong></small>
                                    <br>
                                    <!-- checa si el egresado tiene una encuesta inconclusa y lo muestra -->
                                    @if($eg->r20_nbr2 != null && $eg->r20_completed != 1)
                                        <small><strong>Encuesta Inconclusa</strong></small>
                                
                                    @endif
                            @endif

                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@push('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        
    } );
</script>
@endpush