<div>
    <table class="table text-lg table-personal" style="width: 100%; table-layout: fixed;">
        {{-- FILA 1 --}}
        <tr>
            <th> Egresad@:</th>
            <td style="color: #1c1d23">{{ $egresado->nombre }} {{ $egresado->paterno }} {{ $egresado->materno }}</td>

            <th>Número de Cuenta:</th>
            <td style="color: #1c1d23">{{ $egresado->cuenta }}</td>

            <th>
                Teléfonos: <br><br>
                <button class="btn boton-dorado" wire:click="openCreatePhone" type="button">
                    <i class="fas fa-plus-circle"></i>&nbsp; Nuevo teléfono
                </button>
            </th>
            <td style="width:15vw">
                @foreach($telefonos as $t)
                    <button class="btn btn-link contact_data" style="color: #002b7a; text-decoration: none;"
                            wire:click="editPhone({{ $t->id }}, '{{ $t->telefono }}', '{{ $t->descripcion }}')">
                        {{ $t->telefono }}
                    </button>, &nbsp;
                @endforeach
            </td>


            @if($typeStudy === '22')
                <th>Promedio: <br> {{ $egresado->promedio > 10 ? $egresado->promedio / 100 : $egresado->promedio }}</th>
                <th>fec. nac.: <br> {{ $egresado->fec_nac }}</th>
            @elseif(in_array($typeStudy, ['esp', 'posgrado']))
                <th>fec. grado: <br> {{ $egresado->fec_grad }}</th>
                <th>fec. nac.: <br> {{ $egresado->fec_nac }}</th>
            @elseif($typeStudy === 'act')
                <th>Sistema:
                    <br>
                    @if($egresado->sistema === 'E')
                        ESCOLARIZADO
                    @elseif($egresado->sistema === 'A')
                        ABIERTO
                    @else
                        A DISTANCIA
                    @endif
                </th>
                <th>Status:
                    <br>
                    @if($egresado->titulado === 1)
                        EN TRÁMITES
                    @elseif($egresado->titulado === 2)
                        TITULADO
                    @else
                        SIN TÍTULO
                    @endif
                    <br> 
                    segun la encuesta anterior
                </th>
            @else
                <th colspan="2"></th>
            @endif
        </tr>

        {{-- FILA 2  --}}
        <tr>
           
            @if($typeStudy === 'posgrado')
                <th>Plan:</th> <td>{{ $egresado->plan }}</td>
            @elseif($typeStudy === 'esp')
                <th>Especialidad:</th> <td>{{ $egresado->especialidad }}</td>
            @else
                <th>Carrera:</th> <td>{{ $carrera }}</td>
            @endif

            @if($typeStudy === 'posgrado')
                <th>Programa:</th> <td>{{ $egresado->programa }}</td>
            @elseif($typeStudy === 'esp')
                <th>Plantel:</th> <td>Fac. de Derecho</td>
            @else
                <th>Plantel:</th> <td>{{ $plantel }}</td>
            @endif

            <th>Correos: <br><br>
                <button class="btn boton-dorado" wire:click="openCreateEmail" type="button">
                    <i class="fas fa-plus-circle"></i>&nbsp; Nuevo Correo
                </button>
            </th>
            <td>
                @foreach($correos as $c)
                    <button class="contact_data" style="color: #002b7a;"
                            wire:click="editEmail({{ $c->id }}, '{{ $c->correo }}')">
                        {{ $c->correo }}
                    </button>, &nbsp;
                @endforeach
            </td>

            @if($typeStudy === '22')
                <th>Sexo: <br> {{ $egresado->sexo }}</th>
                <th>Bach: <br> @if($egresado->bach >= 20 && $egresado->bach < 30) ENP @elseif($egresado->bach >= 30) CCH @endif</th>
            @elseif(in_array($typeStudy, ['esp', 'posgrado']))
                <th>Sexo: <br> {{ $egresado->sexo }}</th>
                <th>Año de egreso: <br> {{ $egresado->anio_egreso }}</th>
            @elseif($typeStudy === 'act')
                <th>Fecha en que se encuestó:
                    <br>{{ substr($egresado->actualized, 0, 10) }}
                </th>
                <th>                    
                    <button class="btn boton-dorado" onclick="send_form('{{ $encuesta->completed == 1 ? 'terminar' : 'inconclusa' }}')">
                        {{ $encuesta->completed == 1 ? 'Terminar Encuesta' : 'Guardar inconclusa' }}
                    </button>
    
                </th>
            @else
                <th colspan="2"></th>
            @endif
        </tr>
        @if(!empty($secciones))
        {{-- FILA 3 --}}
        <tr>
            <th colspan="8">
                <div class="row justify-content-center align-items-center">
            
                        @foreach($secciones as $sec)
                            <div class="col-auto mb-2">
                                <a class="btn {{ $sec['completada'] ? 'boton-verde' : 'boton-dorado' }}"
                                   href="{{ $sec['url'] }}"
                                   @if($section === $sec['clave']) style="background-color: #002b7a; color: white; border: 2px solid #f7f7f7ff;" @endif>
                                    @if($sec['completada']) <i class="fas fa-check-circle"></i> @endif
                                    {{ $sec['etiqueta'] }}
                                </a>
                            </div>
                        @endforeach
                    
                    
                    <div class="col-auto mb-2">
                        <button class="btn boton-dorado" onclick="send_form('{{ $encuesta->completed == 1 ? 'terminar' : 'inconclusa' }}')">
                            {{ $encuesta->completed == 1 ? 'Terminar Encuesta' : 'Guardar inconclusa' }}
                        </button>
                    </div>

                    <div class="col-auto mb-2">
                        <button class="btn boton-oscuro" onclick="confirm_exit()">
                            <i class="fas fa-sign-out-alt"></i> Salir
                        </button>
                    </div>
                </div>
                
            </th>
        </tr>
        @endif

    </table>

    {{-- MODALES --}}
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
                        <label>Correo</label>
                        <input type="email" class="form-control" wire:model="nuevo_correo">
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