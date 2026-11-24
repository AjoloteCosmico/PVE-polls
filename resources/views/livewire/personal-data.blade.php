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
                <button type="button" class="btn boton-dorado" wire:click="$dispatch('nuevoTelefono')">
                    <i class="fas fa-plus-circle"></i>&nbsp; Nuevo teléfono
                </button>
            </th>
            <td style="width:15vw">
                @foreach($this->telefonos as $t)
                    <button type="button" class="contact_data" style="color: #002b7a;"
                            wire:key="tel-{{ $t->id }}"
                            wire:click="$dispatch('editarTelefono', { id: {{ $t->id }} })">
                        {{ $t->telefono }}
                    </button>  &nbsp;
                @endforeach
            </td>


            @if($typeStudy === 'seg')
                <th>Promedio: <br> {{ $egresado->promedio > 10 ? $egresado->promedio / 100 : $egresado->promedio }}</th>
                <th>fec. nac.: <br> {{ $egresado->fec_nac }}</th>
            @elseif(in_array($typeStudy, ['esp', 'posgrado']))
                <th>fec. grado: <br> {{ $egresado->fec_grad }} <br> 
                @if($egresado->carrera)
                    Licenciatura: {{ $carrera }} <br>
                @endif
                </th>
                <th>fec. nac.: <br> {{ $egresado->fec_nac }}</th>
            @elseif(in_array($typeStudy, ['act', 'ed_continua', 'encuesta_verde','credencial']))
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
                <th>Plan:</th> <td>{{ $encuesta->plan }}</td>
            @elseif($typeStudy === 'esp')
                <th>Especialidad:</th> <td style="color: #1c1d23;">{{ $egresado->especialidad ?? 'S/E'}}</td>
            @else
                <th>Carrera:</th> <td>{{ $carrera }}</td>
            @endif

            @if($typeStudy === 'posgrado')
                <th>Programa:</th> <td>{{ $egresado->programa }}</td>
            @elseif($typeStudy === 'esp')
                <th>Plantel:</th> <td style="color: #1c1d23;"> Fac. de Derecho </td>
            @else
                <th>Plantel:</th> <td>{{ $plantel }}</td>
            @endif

            <th>Correos: <br><br>
                <button type="button" class="btn boton-dorado" wire:click="$dispatch('nuevoCorreo')" type="button">
                    <i class="fas fa-plus-circle"></i>&nbsp; Nuevo Correo
                </button>
            </th>
            <td>
                @foreach($this->correos as $c)
                    <button type="button" class="contact_data" style="color: #002b7a;"
                            wire:key="mail-{{ $c->id }}"
                            wire:click="$dispatch('editarCorreo', { id: {{ $c->id }} })">
                        {{ $c->correo }}
                    </button> &nbsp;
                @endforeach
            </td>

            @if($typeStudy === 'seg')
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
            @elseif($typeStudy === 'ed_continua')
                <th>                    
                    <button class="btn boton-dorado" onclick="send_form('{{ $encuesta->completed == 1 ? 'terminar' : 'inconclusa' }}')">
                        {{ $encuesta->completed == 1 ? 'Terminar Encuesta' : 'Guardar Encuesta' }}
                    </button>
                </th>
            @elseif($typeStudy === 'encuesta_verde')
                <th>                    
                    @if(isset($encuesta->vr1))
                        <button class="btn boton-dorado" onclick="send_form('terminar')"> Terminar Encuesta</button>            
                    @endif
                </th>
            @elseif($typeStudy === 'credencial')
                <th>                    
                    <button class="btn boton-dorado" onclick="send_form('{{ $encuesta->completed == 1 ? 'terminar' : 'inconclusa' }}')">
                        {{ $encuesta->completed == 1 ? 'Terminar Encuesta' : 'Guardar Encuesta' }}
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
                            <div class="col">
                                <a class="btn {{ $sec['completada'] ? 'boton-verde' : 'boton-dorado' }}"
                                   href="{{ $sec['url'] }}"
                                   @if($section === $sec['clave']) style="background-color: #002b7a; color: white; border: 2px solid #f7f7f7ff;" @endif>
                                    @if($sec['completada']) <i class="fas fa-check-circle"></i> @endif
                                    {{ $sec['etiqueta'] }}
                                </a>
                            </div>
                        @endforeach
                    
                    
                    <div class="col-auto mb-2">
                        @if($typeStudy === 'seg')
                            <a href="{{ route('terminar22', $encuesta->registro) }}" class="btn boton-dorado">
                                {{ $encuesta->completed == 1 ? 'Terminar Encuesta' : 'Guardar como inconclusa' }}
                            </a>
                        @elseif($typeStudy === 'posgrado')
                            <a href="{{ route('posgrado.terminar', $encuesta->registro) }}" class="btn boton-dorado">
                                {{ $encuesta->completed == 1 ? 'Terminar Encuesta' : 'Guardar como inconclusa' }}
                            </a>
                        @elseif($typeStudy === 'esp')
                            <a href="{{ route('especialidad.terminar', $encuesta->registro) }}" class="btn boton-dorado">
                                {{ $encuesta->completed == 1 ? 'Terminar Encuesta' : 'Guardar como inconclusa' }}
                            </a>
                        @endif
                    </div>
                </div>
                
            </th>
        </tr>
        @endif

    </table>

   