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
        <th>Plan:</th>
        <td> {{ $Egresado->plan }}</td>

        <th>Programa:</th>
        <td> {{ $Egresado->programa }}</td>

        <th>Correos: <br><br> <button class="btn boton-dorado" data-toggle="modal" onclick="" data-target="#emailModal" type="button"><i class="fas fa-plus-circle"></i>&nbsp; Nuevo Correo</button> </th>
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
                  @if($Encuesta->sec_pa==1)
                         <a class="btn boton-verde" id="btn-pA" href="{{route('posgrado.show',['pA',$Encuesta->registro])}}"> <i class="fas fa-check-circle" aria-hidden="true"></i> Sección A </a>
               
                    @else
                         <a class="btn boton-dorado" id="btn-pA" href="{{route('posgrado.show',['pA',$Encuesta->registro])}}">Sección A</a>
               
                    @endif
                </div>
               <div class="col">
                  @if($Encuesta->sec_pb==1)
                         <a class="btn boton-verde" id="btn-pB" href="{{route('posgrado.show',['pB',$Encuesta->registro])}}"> <i class="fas fa-check-circle" aria-hidden="true"></i> Sección B </a>
               
                    @else
                         <a class="btn boton-dorado" id="btn-pB" href="{{route('posgrado.show',['pB',$Encuesta->registro])}}">Sección B</a>
               
                    @endif
                </div>
               <div class="col">
                  @if($Encuesta->sec_pc==1)
                         <a class="btn boton-verde" id="btn-pC" href="{{route('posgrado.show',['pC',$Encuesta->registro])}}"> <i class="fas fa-check-circle" aria-hidden="true"></i> Sección C </a>
               
                    @else
                         <a class="btn boton-dorado" id="btn-pC" href="{{route('posgrado.show',['pC',$Encuesta->registro])}}">Sección C</a>
               
                    @endif
                </div>
               <div class="col">
                  @if($Encuesta->sec_pd==1)
                         <a class="btn boton-verde" id="btn-pD" href="{{route('posgrado.show',['pD',$Encuesta->registro,])}}"> <i class="fas fa-check-circle" aria-hidden="true"></i> Sección D </a>
               
                    @else
                         <a class="btn boton-dorado" id="btn-pD" href="{{route('posgrado.show',['pD',$Encuesta->registro])}}">Sección D</a>
               
                    @endif
                </div>
               <div class="col">
                  @if($Encuesta->sec_pe==1)
                         <a class="btn boton-verde" id="btn-pE" href="{{route('posgrado.show',['pE',$Encuesta->registro])}}"> <i class="fas fa-check-circle" aria-hidden="true"></i> Sección E </a>
               
                    @else
                         <a class="btn boton-dorado" id="btn-pE" href="{{route('posgrado.show',['pE',$Encuesta->registro])}}">Sección E</a>
               
                    @endif
                </div>
               

                {{-- Nuevo div para el botón de acción --}}
                
                <div class="col">
                    @if($Encuesta->completed == 1)
                    <a href="{{route('terminar22',$Encuesta->registro)}}">
                    <button class="btn boton-dorado" onclick="send_form('terminar')">Terminar Encuesta</button>
                    @else
                    <a href="{{route('terminar22',$Encuesta->registro)}}">
                    <button class="btn boton-dorado" onclick="send_form('inconclusa')">Guardar como inconclusa</button>
                    @endif
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
<script>
    document.getElementById("btn-{{ $section }}").style="background-color: #002b7a; color: white;border: 2px solid #f7f7f7ff;"
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    function correos(correo_id, correo) {
        window.warning = false;
        console.log(window.warning);
        Swal.fire({
            title: correo,
            html:
                "<br>" +
                '<button type="button" role="button" tabindex="0" class="SwalBtn1 customSwalBtn" onclick="location.href = `/direct_send/' + correo_id + '`">' + 'Enviar Aviso de Privacidad' + '</button>' +
                '<button type="button" role="button" tabindex="0" class="SwalBtn2 customSwalBtn" onclick="location.href = `/editar_correo/' + correo_id + '/{{ $Egresado->carrera }}/{{ $Encuesta->registro }}/{{ Session::get('telefono_encuesta') }}`">' + 'Editar' + '</button>',
            icon: "warning",
            showConfirmButton: false,
            showCancelButton: false
        });
    }
</script>

@endpush