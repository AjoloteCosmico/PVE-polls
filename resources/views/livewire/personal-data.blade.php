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
                <button type="button" class="btn boton-dorado" wire:click="nuevoTelefono">
                    <i class="fas fa-plus-circle"></i>&nbsp; Nuevo teléfono
                </button>
            </th>
            <td style="width:15vw">
                @foreach($telefonos as $t)
                    <button type="button" class="contact_data" style="color: #002b7a;"
                            wire:click="editarTelefono({{ $t->id }})">
                        {{ $t->telefono }}
                    </button>  &nbsp;
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
                <button type="button" class="btn boton-dorado" wire:click="nuevoCorreo" type="button">
                    <i class="fas fa-plus-circle"></i>&nbsp; Nuevo Correo
                </button>
            </th>
            <td>
                @foreach($correos as $c)
                    <button type="button" class="contact_data" style="color: #002b7a;"
                            wire:click="editarCorreo({{ $c->id }})">
                        {{ $c->correo }}
                    </button> &nbsp;
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

    <!-- MODAL DE TELÉFONO -->
    @if($showPhoneModal)
        <div class="modal show d-block" tabindex="-1" style="background: rgba(19, 25, 49, 0.85); z-index: 2000;" role="dialog">
            <div class="modal-dialog" style=" font-size: 150%;" style="z-index:1500">
                <div class="modal-content" style="background-color: #131931; color: white;">
                    
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:white;">
                            {{ $phoneId ? 'Editar Teléfono' : 'Nuevo Teléfono' }}
                        </h5>
                        <button type="button" class="close btn btn-danger" style="background-color:red;" wire:click="cerrarModal">
                            <i class="fa fa-times fa-xl" aria-hidden="true"></i>
                        </button>
                    </div>

                    <form wire:submit.prevent="guardarTelefono">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label style="color:white;">Teléfono</label>
                                <input type="text" class="form-control modal-input" style="font-size: 120%;" wire:model="telefonoInput" required>
                                @error('telefonoInput')
                                    <span class="text-danger" style="font-size: 0.9rem;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label style="color:white;">Descripción</label>
                                <input type="text" class="form-control modal-input" style="font-size: 120%;" wire:model="telefonoDescripcion">
                                @error('telefonoDescripcion')
                                    <span class="text-danger" style="font-size: 0.9rem;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="cerrarModal">Cancelar</button>
                            <button type="submit" class="btn btn-success text-lg">
                                <i class="fas fa-save fa-xlg"></i> Guardar
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endif

    <!-- MODAL DE CORREO -->
    @if($showEmailModal)
    <div class="modal show d-block" tabindex="-1" style="background: rgba(19, 25, 49, 0.85); z-index: 2000;" role="dialog">
        <div class="modal-dialog" style=" font-size: 150%;" style="z-index:1500">

            <form wire:submit.prevent="guardarCorreo" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color:white;">
                        {{ $emailId ? 'Editar Correo' : 'Agregar Correo' }}
                    </h5>
                    <button type="button" class="close btn btn-danger" style="background-color:red;" wire:click="cerrarModal">
                        <i class="fa fa-times fa-xl" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label style="color:white;">Correo Electrónico</label>
                        <input type="email" class="form-control modal-input" style="font-size: 120%;" wire:model="correoInput" required>
                        @error('correoInput') 
                            <span class="text-danger" style="font-size:0.9rem;">{{ $message }}</span> 
                        @enderror
                    </div>
                    @if($emailId)                    
                    <div class="mb-3">
                        <label style="color:white;">Descripción</label>
                        <input type="text" class="form-control modal-input" style="font-size: 120%;" wire:model="correoDescripcion">
                    </div>
                    @endif
                </div>
                <div class="modal-footer" style="background-color: #131931;">
                    <button type="button" class="btn btn-secondary" wire:click="cerrarModal">Cancelar</button>
                    <button type="submit" class="btn btn-success text-lg"><i class="fas fa-save fa-xlg"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>