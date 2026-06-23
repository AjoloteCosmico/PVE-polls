
{{--
    Componente: agregar telefono
    Variables recibidas:
        $cuenta -> la cuenta del egresado
        $respuestasKey -> id de la tabla de respuestas
        $typeStudy -> recibe 'pos' o 'seg' o 'act' o 'esp' o 'verde' o 'cont'
--}}

<div class="modal fade" id="phoneEditModal" tabindex="-1" aria-labelledby="phoneEditModalLabel" aria-hidden="true"  style="background: #131931;">
  <div class="modal-dialog" style=" font-size: 150%;" style="z-index:1500">
    <form id="formEditTel" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"  style="color:white;">Nuevo Telefono</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> -->
         <button type="button" class="close btn btn-danger" style="background-color:red;" data-dismiss="modal" aria-label="Close">
          <i class="fa fa-times fa-xl" aria-hidden="true"></i>
         </button>
      </div>
      <div class="modal-body">
        @csrf
        <input type="hidden" id="encuesta_id" name="encuesta_id" value="{{$respuestasKey}}">
        <input type="hidden" id="telefono_id" name="telefono_id" value="">
        <input type="hidden" id="cuenta" name="cuenta" value="{{$cuenta}}">
        <input type="hidden" id="type" name="type" value="{{$typeStudy}}">
        <div class="mb-3">
          <label style="color:white;">Telefono</label>
          <input type="text" name="telefono" id="telefono_edit" class="form-control modal-input" style=" font-size: 120%;">
        </div>
        <div class="mb-3">
          <label style="color:white;">Description</label>
          <input type="text" name="description" id="tel_edit_desc" class="form-control modal-input" style=" font-size: 120%;">
        </div>
         <button type="submit" class="btn btn-success text-lg"> <i class="fas fa-save fa-xlg"></i> Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
    
        </div>
      
    </form>
  </div>
</div>

<script>
window.editPhone = function(telefono_id, telefono, description) {
    // Ensure any other modal is hidden before opening the edit modal.
    $('#phoneEditModal').modal('hide');
    $('#phoneModal').modal('hide');
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
    if (document.activeElement) {
      document.activeElement.blur();
    }

    $('#telefono_id').val(telefono_id);
    $('#telefono_edit').val(telefono);
    $('#tel_edit_desc').val(description);
    $('#phoneEditModal').modal('show');
  }


$(document).ready(function() {
    $('#formEditTel').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('telefonos.async_update') }}",
            method: "POST",
            data: formData,
            success: function(response) {
                $('#phoneEditModal').modal('hide');
                $('#formEditTel')[0].reset();
                // Trigger event with phone data
                let telefono = response.telefono;
                $(document).trigger('phoneUpdated', {telefono: telefono});
                // alert('Empresa agregada correctamente');
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Telefono guardado correctamente",
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