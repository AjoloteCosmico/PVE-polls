
{{--
    Componente: agregar telefono
    Variables recibidas:
        $cuenta -> la cuenta del egresado
        $respuestasKey -> id de la tabla de respuestas
        $typeStudy -> recibe 'pos' o 'seg' o 'act' o 'esp' o 'verde' o 'cont'
--}}

<div class="modal fade" id="phoneModal" tabindex="-1" aria-labelledby="phoneModalLabel" aria-hidden="true"  style="background: #131931;">
  <div class="modal-dialog" style=" font-size: 150%;" style="z-index:999">
    <form id="formTel" class="modal-content">
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
        <input type="hidden" id="cuenta" name="cuenta" value="{{$cuenta}}">
        <input type="hidden" id="type" name="type" value="{{$typeStudy}}">
        <div class="mb-3">
          <label style="color:white;">Telefono</label>
          <input type="text" name="telefono" id="telefono" class="form-control modal-input" style=" font-size: 120%;">
        </div>
        <div class="mb-3">
          <label style="color:white;">Description</label>
          <input type="text" name="description" id="description" class="form-control modal-input" style=" font-size: 120%;">
        </div>
         <button type="submit" class="btn btn-success text-lg"> <i class="fas fa-save fa-xlg"></i> Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
    
        </div>
      
    </form>
  </div>
</div>

<script>
$(document).ready(function() {
    $('#formTel').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('telefonos.store_async') }}",
            method: "POST",
            data: formData,
            success: function(response) {
                $('#phoneModal').modal('hide');
                $('#formTel')[0].reset();
                // Trigger event with phone data
                let telefono = response.telefono;
                $(document).trigger('phoneAdded', {telefono: telefono});
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