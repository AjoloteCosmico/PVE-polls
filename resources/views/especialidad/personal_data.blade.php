<table class="table text-lg table-personal">
    <tr>
        <th>Egresad@:</th>
        <td> {{ $Egresado->nombre }} {{ $Egresado->paterno }} {{ $Egresado->materno }}</td>

        <th>Número de Cuenta:</th>
        <td> {{ $Egresado->cuenta }}</td>

        <th>Teléfonos: <br><br> <button class="btn boton-dorado" data-toggle="modal" onclick="" data-target="#phoneModal" type="button"><i class="fas fa-plus-circle"></i>&nbsp; Nuevo teléfono</button> </th>
        <td style="width:25vw">
            @foreach($Telefonos as $t)
                <a class="contact_data" style="color: #002b7a;" href="{{ route('editar_telefono', [$t->id, $Egresado->carrera, $Encuesta->registro, Session::get('telefono_encuesta')]) }}">{{ $t->telefono }} </a>, &nbsp;
            @endforeach
        </td>

        <th>fec. grado: <br>{{$Egresado->fec_grad}} </th>  
        <th>fec. nac.: <br> {{$Egresado->fec_nac}}</th>

    </tr>
    <tr>
        <th>Especialidad:</th>
        <td> {{ $Egresado->especialidad }}</td>

        <th>Plantel:</th>
        <td> Fac de derecho (pero alomejor no)</td>
        <th>Correos: <br><br> <button class="btn boton-dorado"  onclick="" data-toggle="modal" data-target="#emailModal" type="button"><i class="fas fa-plus-circle"></i>&nbsp; Nuevo Correo</button> </th>
        <td>
            @foreach($Correos as $c)
                <a class="contact_data" style="color: #002b7a;" onclick="correos({{ $c->id }},'{{ $c->correo }}')"> {{ $c->correo }} </a>, &nbsp;
            @endforeach
        </td>

        <th>Sexo: <br> {{$Egresado->sexo}}</th>

        <th>Año de egreso: <br> {{$Egresado->anio_egreso}}</th>

    </tr>
    <tr>
        <th colspan="8">
            <div class="row justify-content-center" style="">
                
                            <div class="col">
                  @if($Encuesta->sec_espa==1)
                         <a class="btn boton-verde" id="btn-espA" href="{{route('especialidad.show',['espA',$Encuesta->registro])}}"> <i class="fas fa-check-circle" aria-hidden="true"></i> Sección A </a>
               
                    @else
                         <a class="btn boton-dorado" id="btn-espA" href="{{route('especialidad.show',['espA',$Encuesta->registro])}}">Sección A</a>
               
                    @endif
                </div>
               <div class="col">
                  @if($Encuesta->sec_espf==1)
                         <a class="btn boton-verde" id="btn-espF" href="{{route('especialidad.show',['espF',$Encuesta->registro])}}"> <i class="fas fa-check-circle" aria-hidden="true"></i> Sección F </a>
               
                    @else
                         <a class="btn boton-dorado" id="btn-espF" href="{{route('especialidad.show',['espF',$Encuesta->registro])}}">Sección F</a>
               
                    @endif
                </div>
                <div class="col">
                  @if($Encuesta->sec_espe==1)
                         <a class="btn boton-verde" id="btn-espE" href="{{route('especialidad.show',['espE',$Encuesta->registro,])}}"> <i class="fas fa-check-circle" aria-hidden="true"></i> Sección D </a>
               
                    @else
                         <a class="btn boton-dorado" id="btn-espE" href="{{route('especialidad.show',['espE',$Encuesta->registro])}}">Sección E</a>
               
                    @endif
                </div>
               <div class="col">
                  @if($Encuesta->sec_espc==1)
                         <a class="btn boton-verde" id="btn-espC" href="{{route('especialidad.show',['espC',$Encuesta->registro])}}"> <i class="fas fa-check-circle" aria-hidden="true"></i> Sección C </a>
               
                    @else
                         <a class="btn boton-dorado" id="btn-espC" href="{{route('especialidad.show',['espC',$Encuesta->registro])}}">Sección C</a>
               
                    @endif
                </div>
                <div class="col">
                  @if($Encuesta->sec_espg==1)
                         <a class="btn boton-verde" id="btn-espG" href="{{route('especialidad.show',['espG',$Encuesta->registro,])}}"> <i class="fas fa-check-circle" aria-hidden="true"></i> Sección D </a>
               
                    @else
                         <a class="btn boton-dorado" id="btn-espG" href="{{route('especialidad.show',['espG',$Encuesta->registro])}}">Sección G</a>
               
                    @endif
                </div>
               

                {{-- Nuevo div para el botón de acción --}}
                
                <div class="col">
                    @if($Encuesta->completed == 1)
                    <a href="{{route('especialidad.terminar',$Encuesta->registro)}}">
                      <button class="btn boton-dorado" onclick="send_form('terminar')">Terminar Encuesta</button>
                    </a>
                    @else
                    <a href="{{route('especialidad.terminar',$Encuesta->registro)}}">
                      <button class="btn boton-dorado" onclick="send_form('inconclusa')">Guardar como inconclusa</button>
                    </a>
                    @endif
                </div>
                <div class="col">
                    
                        <button class="btn boton-oscuro" onclick="confirm_exit()">
                            <i class="fas fa-sign-out-alt"></i> Salir
                        </button>
                    

                </div>

            </div>
        </th>
    </tr>

</table>

@push('css')
<style>
    .customSwalBtn { padding: 0.10vmax; margin: 0.5vmax; background-color: #002b7a; }
    .customSwalBtn:hover { background-color: #ba800d; color: #FFFFFF; transform: translateY(-4px); }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById("btn-{{ $section }}").style="background-color: #002b7a; color: white;border: 2px solid #f7f7f7ff;"
    function confirm_exit() {
        console.log('Intentando salir de la encuesta');
        Swal.fire({
            title: '¿Estás seguro de que quieres salir?',
            text: "Los cambios no guardados se perderán",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, salir',
            cancelButtonText: 'No, quedarme'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{route('llamar_especialidad',[$Encuesta->cuenta,$Egresado->especialidad])}}";
            }
        });
    }
</script>
<script type="text/javascript">
    function correos(correo_id, correo) {
        window.warning = false;
        console.log(window.warning);
        Swal.fire({
            title: correo,
            html:
                "<br>" +
                '<button type="button" role="button" tabindex="0" class="SwalBtn1 customSwalBtn" onclick="location.href = `/especialidad_direct_send/' + correo_id + '`">' + 'Enviar Aviso de Privacidad' + '</button>' +
                '<button type="button" role="button" tabindex="0" class="SwalBtn2 customSwalBtn" onclick="location.href = `/editar_correo/' + correo_id + '/{{ $Egresado->carrera }}/{{ $Encuesta->registro }}/{{ Session::get('telefono_encuesta') }}`">' + 'Editar' + '</button>',
            icon: "warning",
            showConfirmButton: false,
            showCancelButton: false
        });
    }
</script>

@endpush