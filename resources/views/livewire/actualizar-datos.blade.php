<div class="container-fluid" style="background-image: url('{{ asset('img/Fondo2.jpg') }}'); padding-top: 20px;">
    
    <div class="numero_telefonico">
        Estás en una llamada con el número: {{ $telefonoEnLlamada->telefono}}
    </div>

    <div>
        <h1 class="text-white"> DATOS DE CONTACTO PARA EL EGRESADO </h1>
        <h1 class="text-white">{{ $egresado->nombre }} {{ $egresado->paterno }} {{ $egresado->materno }}</h1>
        <h1 class="text-white">{{ $egresado->cuenta }}</h1>
        <h1 class="text-white">{{ $carrera }} {{ $plantel }}</h1>
        <h2 class="text-white">Muestra: {{ $egresado->anio_egreso }}</h2>
    </div>

    {{-- Botones de Navegación  --}}
    <div class="row">
        <div class="col">
            @if($config['muestraRoute'])
                <a href="{{ $config['muestraRoute'] }}">
                    <button type="button" class="boton-oscuro">
                        <i class="fas fa-table"></i> Ir a muestra Carrera 
                    </button>
                </a>
            @endif
        </div>
        <div class="col">
            @if($config['botonReturn'])
                <a href="{{ $config['botonReturn'] }}">
                    <button type="button" class="boton-volver">
                        <i class="fa-sharp fa-solid fa-rotate-left"></i>
                    </button>
                </a>
            @endif
        </div>
        <div class="col"></div>
    </div>
    <br><br>

    {{-- TELÉFONOS --}}
    <div class="col-6 col-lg-12 table-responsive text-white">  
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h1>TELÉFONOS DEL EGRESADO</h1> 
            <button type="button" class="btn" style="background-color: {{ Auth::user()->color }}; color: white;"
                    wire:click="$dispatch('nuevoTelefono')">
                <i class="fas fa-plus-circle"></i>&nbsp; Nuevo teléfono 
            </button>
        </div>

        <table class="table text-xl text-white" style="table-layout: fixed;">
            <thead>
                <tr>
                    <th>Num. cuenta</th>
                    <th style="width: 30%;">Teléfono</th>
                    <th>Descripción</th>
                    <th>Status</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($telefonos as $t)
                    <tr>
                        <td>{{ $t->cuenta }}</td>
                        <td>{{ $t->telefono }}</td>
                        <td>{{ $t->descripcion }}</td>
                        <td style="color: '#ffffff'; font-weight: bold;">
                            {{ $t->status_description ?? 'Sin estatus' }}
                        </td>
                        <td>
                            <button type="button" class="btn" style="background-color: {{ Auth::user()->color }}; color: white;"
                                    wire:click="$dispatch('editarTelefono', { id: {{ $t->id }} })">
                                <i class="fa fa-edit"></i> EDITAR
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">No hay teléfonos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- CORREOS --}}
    <div class="col-12 table-responsive text-white mt-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h1>CORREOS DEL EGRESADO</h1>
            <button type="button" class="btn" style="background-color: {{ Auth::user()->color }}; color: white;"
                    wire:click="$dispatch('nuevoCorreo')">
                <i class="fas fa-plus-circle"></i>&nbsp; Nuevo Correo
            </button>
        </div>

        <table class="table text-xl text-white" style="table-layout: fixed;">
            <thead>
                <tr>
                    <th>Num. cuenta</th>
                    <th style="width: 30%;">Correo</th>
                    <th>Status</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($correos as $c)
                    <tr>
                        <td>{{ $c->cuenta }}</td>
                        <td>{{ $c->correo }}</td>
                        <td></td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn" style="background-color: {{ Auth::user()->color }}; color: white; margin-right: 5px;"
                                        wire:click="$dispatch('editarCorreo', { id: {{ $c->id }} })">
                                    <i class="fa fa-edit"></i> EDITAR
                                </button>

                                {{-- Envío por Correo --}}
                                @if($config['mailType'])
                                    <button type="button" class="btn boton-dorado"
                                            wire:click="$dispatch('solicitarEnvioCorreo', { id: {{ $c->id }}, mailType: '{{ $config['mailType'] }}' })">
                                        <i class="fa fa-paper-plane"></i> ENVIAR ENCUESTA
                                    </button>
                                @endif

                                {{-- Permiso para encuestar --}}
                                @if($config['permiso'] && auth()->user()->can($config['permiso']))
                                    <a href="{{ route($config['comenzar'], [$c->id, $egresado->cuenta, $egresado->carrera]) }}" class="btn boton-oscuro">
                                        <i class="fas fa-paper-plane"></i> AVISO Y ENCUESTAR
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">No hay correos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>