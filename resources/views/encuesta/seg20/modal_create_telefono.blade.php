<!-- Modal para Agregar Nuevo Número de Teléfono -->
<div class="modal fade" id="phoneModal" tabindex="-1" aria-labelledby="phoneModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="font-size: 150%;">
        <form id="formPhone" class="modal-content">
            <div class="modal-header"> 
                <h5 class="modal-title" style="color:white;">Nuevo Teléfono</h5>   
                <!-- Botón de Cerrar (X) -->
                <button type="button" class="close btn btn-danger" style="background-color:red;" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times fa-xl" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                 <input type="hidden" id="encuesta_id" name="encuesta_id" value="{{$Encuesta->registro}}">
                 <input type="hidden" id="table" name="table" value="{{$Egresado->anio_egreso}}">
                <!-- Campo para el Número de Teléfono -->
                <div class="mb-3">
                    <label style="color:white;">Número de Teléfono *</label>
                    
                    <input type="text" name="telefono" id="numero_telefono" class="form-control modal-input" style="font-size: 120%;" required>
                </div>

                
                <!-- Campo para la Descripcion -->
                <div class="mb-3">
                    <label style="color:white;">Descripcion o notas (telefono de trabajo, lada, extencion)</label>
                    <input name="description" class="form-control modal-input" style="font-size: 120%;"></input>
                </div>

                <div class="d-flex justify-content-between pt-3">
                    <!-- Botón de Guardar -->
                    <button type="submit" class="btn btn-success text-lg"> 
                        <i class="fas fa-save fa-xlg"></i> Guardar Teléfono
                    </button>
                    <!-- Botón de Cancelar -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> 
                        Cancelar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
const URL_GUARDAR = "{{ route('guardar_telefono',[$Egresado->cuenta,$Egresado->carrera,'0',$TelefonoEnLlamada->id ?? 0])}}";
// Lógica para enviar el formulario vía AJAX
$(document).ready(function() {
    $('#formPhone').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();


        $.ajax({
            url: URL_GUARDAR,
            method: "POST",
            data: formData,
            success: function(response) {
                $('#phoneModal').modal('hide');
                $('#formPhone')[0].reset();
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Teléfono agregado correctamente",
                    showConfirmButton: false,
                    timer: 1500
                });


                
            },
           
            error: function(xhr) {
                let errors = xhr.responseJSON && xhr.responseJSON.errors ? xhr.responseJSON.errors : {};
                let msg = 'Error al guardar el teléfono. Por favor, verifica:\n';
               
                if (Object.keys(errors).length > 0) {
                    for (let campo in errors) {
                        msg += '- ' + errors[campo][0] + '\n';
                    }
                } else {
                    msg = 'Ocurrió un error desconocido al procesar la solicitud.';
                }


                // Usamos alert() como fallback para el entorno actual
                alert(msg);
                console.error("Error de AJAX:", xhr.responseJSON || xhr.responseText);
            }
        });
    });
});
</script>