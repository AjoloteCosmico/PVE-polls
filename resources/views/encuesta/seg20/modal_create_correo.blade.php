<!-- Modal para Agregar Nuevo Correo Electrónico -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="font-size: 150%;">
        <form id="formEmail" class="modal-content">
            <div class="modal-header"> 
                <h5 class="modal-title" style="color:white;">Nuevo Correo Electrónico</h5>
                <!-- Botón de Cerrar (X) -->
                <button type="button" class="close btn btn-danger" style="background-color:red;" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times fa-xl" aria-hidden="true"></i>
                </button>
            </div>

            <div class="modal-body">
                @csrf
                <!-- Aquí asumo que necesitas pasar IDs de contexto, como la encuesta y el egresado. -->
                <input type="hidden" id="encuesta_id_email" name="encuesta_id" value="{{$Encuesta->registro}}">
                <input type="hidden" id="egresado_table" name="table" value="{{$Egresado->anio_egreso}}">

                <!-- Campo para el Correo Electrónico -->
                <div class="mb-3">
                    <label style="color:white;">Correo Electrónico *</label>
                    <input type="email" name="correo" id="email_address" class="form-control modal-input" style="font-size: 120%;" required>
                    
                </div>
                <div class="d-flex justify-content-between pt-3">
                    <!-- Botón de Guardar -->
                    <button type="submit" class="btn btn-success text-lg"> 
                        <i class="fas fa-save fa-xlg"></i> Guardar Correo
                    </button>
                    <!-- Botón de Cancelar/Cerrar -->
                    <button type="button" class="btn btn-secondary text-lg" data-dismiss="modal">
                        Cancelar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
const URL_GUARDAR_EMAIL = "{{ route('guardar_correo',[$Egresado->cuenta,$Egresado->carrera,'0',$TelefonoEnLlamada->id ?? 0])}}";
// Lógica para enviar el formulario vía AJAX
$(document).ready(function() {
    $('#formEmail').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: URL_GUARDAR_EMAIL,
            method: "POST",
            data: formData,
            success: function(response) {
                // Ocultar el modal, resetear el formulario y mostrar la alerta de éxito
                $('#emailModal').modal('hide');
                $('#formEmail')[0].reset();
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Correo guardado correctamente",
                    showConfirmButton: false,
                    timer: 1500
                });
                if (response.redirect_url) {
                    // Esperamos 500ms para que el usuario pueda ver la alerta
                    setTimeout(() => {
                        window.location.href = response.redirect_url;
                    }, 500); 
                } else {
                    // Fallback (recargar la página actual)
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                }


               
            },

            error: function(xhr){
                let errors = xhr.responseJSON && xhr.responseJSON.errors ? xhr.responseJSON.errors : {};
                let errorTitle = 'Error al Guardar Correo';
                let htmlMsg = 'Ocurrió un error desconocido. Por favor, revisa la consola.';

                if (Object.keys(errors).length > 0) {
                    // Manejar errores de validación 422
                    errorTitle = 'Error de Validación';
                    htmlMsg = '<ul>' + Object.keys(errors).map(campo => {
                        // El campo 'correo' se muestra como error
                        return '<li>' + errors[campo][0] + '</li>';
                    }).join('') + '</ul>';
                } else if (xhr.status === 419) {
                    // Manejar error de Token CSRF (Sesión Expirada)
                    errorTitle = 'Sesión Expirada (419)';
                    htmlMsg = 'La sesión ha expirado. Por favor, recarga la página para obtener un nuevo token de seguridad.';
                } else if (xhr.status === 500) {
                    // Manejar error interno del servidor
                    errorTitle = 'Error Interno del Servidor (500)';
                    htmlMsg = 'Hubo un problema fatal en el servidor. Revisa el log de PHP/Laravel.';
                } else {
                    // Otros errores
                    errorTitle = `Error ${xhr.status}`;
                    htmlMsg = 'Ocurrió un error inesperado al procesar la solicitud.';
                }

                // Usamos SweetAlert para mostrar el error (reemplazando alert())
                Swal.fire({
                    icon: "error",
                    title: errorTitle,
                    html: htmlMsg,
                    footer: xhr.status ? `Estado: ${xhr.status}` : ''
                });

                console.error("Error de AJAX:", xhr.responseJSON || xhr.responseText);

            }
        });
    });
});
</script>