
{{--
    Componente: agregar correo
    Variables recibidas:
        $cuenta -> la cuenta del egresado
        $respuestasKey -> id de la tabla de respuestas
        $typeStudy -> recibe 'pos' o 'seg' o 'act' o 'esp' o 'verde' o 'cont'
--}}

<div class="modal fade" id="editEmailModal" tabindex="-1" aria-labelledby="editEmailModalLabel" aria-hidden="true"  style="background: #131931;">
  <div class="modal-dialog" style=" font-size: 150%;" style="z-index:1500">
    <form id="formEditCorreo" class="modal-content">
      <div class="modal-header">
        <h5 id="editEmailModalLabel" class="modal-title"  style="color:white;">Editar Correo</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> -->
         <button type="button" class="close btn btn-danger" style="background-color:red;" data-dismiss="modal" aria-label="Close">
          <i class="fa fa-times fa-xl" aria-hidden="true"></i>
         </button>
      </div>
      <div class="modal-body">
        <h1>{{$EgName}}</h1>
        @csrf
        <input type="hidden" id="encuesta_id" name="encuesta_id" value="{{$respuestasKey}}">
        <input type="hidden" id="correo_id" name="correo_id" value="">
        <input type="hidden" id="cuenta" name="cuenta" value="{{$cuenta}}">
        <input type="hidden" id="type" name="type" value="{{$typeStudy}}">
        <div class="mb-3">
          <label for="correo_edit" style="color:white;">Correo</label>
          <input type="text" name="correo" id="correo_edit" class="form-control modal-input" style=" font-size: 120%;">
        </div>
        <div class="mb-3">
           <label for="email_status" style="color: white;">Status</label>
            <select style="width:50%" class="form-control" id="email_status" name="status" aria-describedby="emailHelp" placeholder="Enter email">
                <option value="13"> En Uso</option>   
                <option value="14"> Sin usar</option>   
            </select>
        </div>
        <div class="mb-3">
          <label for="description_edit" style="color:white;">Anotaciones (opcional)</label>
          <input type="text" name="description" id="description_edit" class="form-control modal-input" style=" font-size: 120%;">
        </div>
         <button type="submit" class="btn btn-success text-lg"> <i class="fas fa-save fa-xlg"></i> Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
    
        </div>
      
    </form>
  </div>
</div>

<script>
  window.editEmail = function(id, correo, description, status) {
    // Ensure any other modal is hidden before opening the edit modal.
    $('#phoneModal').modal('hide');
    $('#emailModal').modal('hide');
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
    if (document.activeElement) {
      document.activeElement.blur();
    }

    $('#correo_id').val(id);
    $('#correo_edit').val(correo);
    $('#description_edit').val(description);
    $('#email_status').val(status || '13');
    $('#editEmailModal').modal('show');
  }
$(document).ready(function() {
    $('#formEditCorreo').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('correos.update_async') }}",
            method: "POST",
            data: formData,
            success: function(response) {
                $('#editEmailModal').modal('hide');
                $('#formEditCorreo')[0].reset();
                // Trigger event with phone data
                let correo = response.correo;
                $(document).trigger('emailUpdated', {correo: correo});
                // alert('Empresa agregada correctamente');
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Correo editado correctamente",
                    showConfirmButton: false,
                    timer: 1500
                    });
              
            },
            
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let msg = '';
                for (let campo in errors) {
                    msg += errors[campo][0] + '\n';
                }
                alert(msg,xhr.responseJSON.errors);
            }
        });
    });
});
</script>