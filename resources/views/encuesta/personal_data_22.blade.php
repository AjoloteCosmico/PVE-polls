<table class="table text-lg table-personal">
    <tr>
        <th>Egresad@:</th>
        <td> {{ $Egresado->nombre }} {{ $Egresado->paterno }} {{ $Egresado->materno }}</td>

        <th>Número de Cuenta:</th>
        <td> {{ $Egresado->cuenta }}</td>

        <th>Teléfonos: <br><br> <a href="{{ route('agregar_telefono', [$Egresado->cuenta, $Egresado->carrera, $Encuesta->registro, Session::get('telefono_encuesta')]) }}"> <button class="btn boton-dorado"><i class="fas fa-plus-circle"></i>&nbsp; Nuevo teléfono</button></a></th>
        <td style="width:25vw">
            @foreach($Telefonos as $t)
                <a class="contact_data" style="color: #002b7a;" href="{{ route('editar_telefono', [$t->id, $Egresado->carrera, $Encuesta->registro, Session::get('telefono_encuesta')]) }}">{{ $t->telefono }} </a>, &nbsp;
            @endforeach
        </td>

        <th>Promedio: <br> @if($Egresado->promedio>10) {{$Egresado->promedio /100}} @else {{$Egresado->promedio}} @endif</th>
        
        <th>fec. nac.: <br> {{$Egresado->fec_nac}}</th>
      
    </tr>
    <tr>
        <th>Carrera:</th>
        <td> {{ $Carrera }}</td>

        <th>Plantel:</th>
        <td> {{ $Plantel }}</td>

        <th>Correos: <br><br> <a href="{{ route('agregar_correo', [$Egresado->cuenta, $Egresado->carrera, $Encuesta->registro, Session::get('telefono_encuesta')]) }}"> <button class="btn boton-dorado"><i class="fas fa-plus-circle"></i>&nbsp; Nuevo Correo</button></a></th>
        <td>
            @foreach($Correos as $c)
                <a class="contact_data" style="color: #002b7a;" onclick="correos({{ $c->id }},'{{ $c->correo }}')"> {{ $c->correo }} </a>, &nbsp;
            @endforeach
        </td>

        <th>Sexo: <br> {{$Egresado->sexo}}</th>

        <th>Bach: <br> @if($Egresado->bach >= 20 && $Egresado->bach < 30)  ENP @elseif($Egresado->bach >= 30) CCH @endif</th>

    </tr>
    <tr>
        <th colspan="8">
            <div class="row justify-content-center" style="margin-top: 10px; margin-bottom: 10px;">
                
                            <div class="col">
                  @if($Encuesta->sec_a==1)
                         <a class="btn boton-verde" id="btn-A" href="{{route('edit_22',[$Encuesta->registro,'A'])}}"> <i class="fas fa-check-circle" aria-hidden="true"></i> Sección A </a>
               
                    @else
                         <a class="btn boton-dorado" id="btn-A" href="{{route('edit_22',[$Encuesta->registro,'A'])}}">Sección A</a>
               
                    @endif
                </div>
               <div class="col">
                  @if($Encuesta->sec_e==1)
                         <a class="btn boton-verde" id="btn-E" href="{{route('edit_22',[$Encuesta->registro,'E'])}}"> <i class="fas fa-check-circle" aria-hidden="true"></i> Sección E </a>
               
                    @else
                         <a class="btn boton-dorado" id="btn-E" href="{{route('edit_22',[$Encuesta->registro,'E'])}}">Sección E</a>
               
                    @endif
                </div>
               <div class="col">
                  @if($Encuesta->sec_f==1)
                         <a class="btn boton-verde" id="btn-F" href="{{route('edit_22',[$Encuesta->registro,'F'])}}"> <i class="fas fa-check-circle" aria-hidden="true"></i> Sección F </a>
               
                    @else
                         <a class="btn boton-dorado" id="btn-F" href="{{route('edit_22',[$Encuesta->registro,'F'])}}">Sección F</a>
               
                    @endif
                </div>
               <div class="col">
                  @if($Encuesta->sec_c==1)
                         <a class="btn boton-verde" id="btn-C" href="{{route('edit_22',[$Encuesta->registro,'C'])}}"> <i class="fas fa-check-circle" aria-hidden="true"></i> Sección C </a>
               
                    @else
                         <a class="btn boton-dorado" id="btn-C" href="{{route('edit_22',[$Encuesta->registro,'C'])}}">Sección C</a>
               
                    @endif
                </div>
               <div class="col">
                  @if($Encuesta->sec_d==1)
                         <a class="btn boton-verde" id="btn-D" href="{{route('edit_22',[$Encuesta->registro,'D'])}}"> <i class="fas fa-check-circle" aria-hidden="true"></i> Sección D </a>
               
                    @else
                         <a class="btn boton-dorado" id="btn-D" href="{{route('edit_22',[$Encuesta->registro,'D'])}}">Sección D</a>
               
                    @endif
                </div>
               <div class="col">
                  @if($Encuesta->sec_g==1)
                         <a class="btn boton-verde" id="btn-G" href="{{route('edit_22',[$Encuesta->registro,'G'])}}"> <i class="fas fa-check-circle" aria-hidden="true"></i> Sección G </a>
               
                    @else
                         <a class="btn boton-dorado" id="btn-G" href="{{route('edit_22',[$Encuesta->registro,'G'])}}">Sección G</a>
               
                    @endif
                </div>

                {{-- Nuevo div para el botón de acción --}}
                
                <div class="col">
                    @if($Encuesta->completed == 1)
                    <a href="{{route('terminar',$Encuesta->registro)}}">
                    <button class="btn boton-dorado" onclick="send_form('terminar')">Terminar Encuesta</button>
                    @else
                    <a href="{{route('terminar',$Encuesta->registro)}}">
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