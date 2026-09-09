<div>
    <table class="table text-lg table-personal">
        {{-- FILA 1: DATOS PERSONALES --}}
        <tr>
            <th>Egresad@:</th>
            <td>{{ $egresado->nombre ?? '' }} {{ $egresado->paterno ?? '' }} {{ $egresado->materno ?? '' }}</td>

            <th>Número de Cuenta:</th>
            <td>{{ $egresado->cuenta ?? '' }}</td>

            <th>
                Teléfonos: <br><br>
                <button class="btn boton-dorado" wire:click="openCreatePhone" type="button">
                    <i class="fas fa-plus-circle"></i>&nbsp; Nuevo teléfono
                </button>
            </th>
            <td style="width:25vw">
                @foreach($telefonos as $t)
                    <button class="btn btn-link contact_data" style="color: #002b7a; text-decoration: none;" 
                            wire:click="editPhone({{ $t->id }}, '{{ $t->telefono }}', '{{ $t->descripcion ?? '' }}')">
                        {{ $t->telefono }}
                    </button>, &nbsp;
                @endforeach
            </td>

            @if($typeStudy === '22')
                <th>Promedio: <br> {{ isset($egresado->promedio) && $egresado->promedio > 10 ? $egresado->promedio / 100 : ($egresado->promedio ?? '') }}</th>
                <th>fec. nac.: <br> {{ $egresado->fec_nac ?? '' }}</th>
            @elseif(in_array($typeStudy, ['esp', 'posgrado']))
                <th>fec. grado: <br> {{ $egresado->fec_grad ?? '' }}</th>
                <th>fec. nac.: <br> {{ $egresado->fec_nac ?? '' }}</th>
            @else
                <th>Sistema: 
                    @if(($egresado->sistema ?? '') == 'E') ESCOLARIZADO 
                    @elseif(($egresado->sistema ?? '') == 'A') ABIERTO 
                    @else A DISTANCIA @endif
                </th> 
                <th>
                    @if(($egresado->titulado ?? 0) == 1) EN TRAMITES 
                    @elseif(($egresado->titulado ?? 0) == 2) TITULADO 
                    @else SIN TITULO @endif <br><small>según encuesta anterior</small>
                </th>
            @endif
        </tr>

        {{-- FILA 2: DATOS ACADÉMICOS Y CORREOS --}}
        <tr>
            @if($typeStudy === 'posgrado')
                <th>Plan:</th> <td>{{ $egresado->plan ?? '' }}</td>
                <th>Programa:</th> <td>{{ $egresado->programa ?? '' }}</td>
            @elseif($typeStudy === 'esp')
                <th>Especialidad:</th> <td>{{ $egresado->especialidad ?? '' }}</td>
                <th>Plantel:</th> <td>Fac. de Derecho</td>
            @else
                <th>Carrera:</th> <td>{{ $carrera }}</td>
                <th>Plantel:</th> <td>{{ $plantel }}</td>
            @endif

            <th>
                Correos: <br><br>
                <button class="btn boton-dorado" wire:click="openCreateEmail" type="button">
                    <i class="fas fa-plus-circle"></i>&nbsp; Nuevo Correo
                </button>
            </th>
            <td>
                @foreach($correos as $c)
                    <button class="btn btn-link contact_data" style="color: #002b7a; text-decoration: none;"
                            wire:click="editEmail({{ $c->id }}, '{{ $c->correo }}', '{{ $c->descripcion ?? '' }}')">
                        {{ $c->correo }}
                    </button>, &nbsp;
                @endforeach
            </td>

            @if($typeStudy === '22')
                <th>Sexo: <br> {{ $egresado->sexo ?? '' }}</th>
                <th>Bach: <br> @if(($egresado->bach ?? 0) >= 20 && ($egresado->bach ?? 0) < 30) ENP @elseif(($egresado->bach ?? 0) >= 30) CCH @endif</th>
            @elseif(in_array($typeStudy, ['esp', 'posgrado']))
                <th>Sexo: <br> {{ $egresado->sexo ?? '' }}</th>
                <th>Año de egreso: <br> {{ $egresado->anio_egreso ?? '' }}</th>
            @else
                <th>Fecha en que se encuestó:</th> 
                <td>
                    {{ substr($egresado->actualized ?? '', 0, 10) }}
                    @if(isset($encuesta) && $encuesta->completed == 1)
                        <button type="button" class="btn btn-sm btn-success" onclick="send_form('terminar')">Terminar Encuesta</button>
                    @else
                        <button type="button" class="btn btn-sm btn-warning" onclick="send_form('inconclusa')">Guardar como inconclusa</button>            
                    @endif
                </td>
            @endif
        </tr>
    </table>

    {{-- MODAL DE TELÉFONO --}}
    @if($showPhoneModal)
    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $phone_id ? 'Editar' : 'Agregar' }} Teléfono</h5>
                    <button type="button" class="close" wire:click="$set('showPhoneModal', false)">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" class="form-control" wire:model="nuevo_telefono">
                        @error('nuevo_telefono') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <input type="text" class="form-control" wire:model="descripcion_telefono">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showPhoneModal', false)">Cancelar</button>
                    <button type="button" class="btn btn-primary" wire:click="savePhone">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- MODAL DE CORREO --}}
    @if($showEmailModal)
    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $email_id ? 'Editar' : 'Agregar' }} Correo</h5>
                    <button type="button" class="close" wire:click="$set('showEmailModal', false)">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Correo Electrónico</label>
                        <input type="email" class="form-control" wire:model="nuevo_correo">
                        @error('nuevo_correo') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <input type="text" class="form-control" wire:model="descripcion_correo">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showEmailModal', false)">Cancelar</button>
                    <button type="button" class="btn btn-primary" wire:click="saveEmail">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>