

<!-- Modal para eviar los coreeos electronico -->



<div class="modal fade" id="modalEnviarEncuesta_{{ $correo_obj->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel_{{ $correo_obj->id }}" aria-hidden="true">
    <div class="modal-dialog" style=" font-size: 150%">
        <div class="modal-content style-modal-custom text-dark">
            <div class="modal-header">
                <h5 class="modal-title"  style="color:white; id="modalLabel_{{ $correo_obj->id }}">
                    <i class="fas fa-paper-plane mr-2"></i> Confirmar Envío de Encuesta ({{ $gen }})
                </h5>
                <button type="button" class="close btn btn-danger" style="background-color:red;" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times fa-xl" aria-hidden="true"></i>
                </button>
            </div>

            
                <form action="{{ route('enviar_invitacion') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="correo" value="{{ $correo_obj->correo }}">
                    <input type="hidden" name="nombre" value="{{ $Egresado->nombre }} {{ $Egresado->paterno }} {{ $Egresado->materno }}">
                    <input type="hidden" name="cuenta" value="{{ $Egresado->cuenta }}">
                    <input type="hidden" name="carrera" value="{{ is_object($Carrera) ? $Carrera->carrera : $Carrera }}">
                    <input type="hidden" name="carrera_clave" value="{{ $Egresado->carrera }}">
                    <input type="hidden" name="plantel" value="{{ is_object($Carrera) ? $Carrera->plantel : $Plantel }}">
                    <input type="hidden" name="anio" value="{{ $gen }}"> 
                    <input type="hidden" name="telefono" value="{{ $Telefono->telefono }}">                                    
                
                
                <div class="modal-body text-left">
                        <p class="text-center font-weight-bold lead mb-3" style="color:white; ">
                            ¿Deseas enviar la encuesta al siguiente correo?
                        </p>

                        <table class="table table-bordered" style="font-size: 15px;">
                            <tr style="background-color: rgb(0, 43, 122);">
                                <td><strong>Egresado:</strong></td>
                                <td>{{ $Egresado->nombre }} {{ $Egresado->paterno }} {{ $Egresado->materno }}</td>
                            </tr>
                            <tr style="background-color: rgb(0, 43, 122);">
                                <td><strong>Cuenta:</strong></td>
                                <td>{{ $Egresado->cuenta }}</td>
                            <tr style="background-color: rgb(0, 43, 122);">
                                <td><strong>Correo:</strong></td>
                                <td>{{ $correo_obj->correo }}</td>
                            </tr>
                            <tr style="background-color: rgb(0, 43, 122);">
                                <td><strong>Teléfono:</strong></td>
                                <td>{{ $Telefono->telefono }}</td>
                            </tr>
                        </table>   
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-paper-plane"></i> Confirmar y Enviar
                        </button>
                    </div>
                </form>
        </div>
    </div>
</div>
