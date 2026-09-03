
<!-- Modal para Agregar Nuevo Correo Electrónico Unificado -->



{{--
    Componente: agregar correo
    Variables recibidas:
        $cuenta -> la cuenta del egresado
        $respuestasKey -> id de la tabla de respuestas
        $typeStudy -> recibe 'pos' o 'seg' o 'act' o 'esp' o 'verde' o 'cont'
        $EgName ->nombre del egresado para ver sus apellidos
--}}

<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true"  style="background: #131931;">
  <div class="modal-dialog" style=" font-size: 150%">
    <form id="formCorreo" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"  style="color:white;">Nuevo Correo Electrónico</h5>
         <button type="button" class="close btn btn-danger" style="background-color:red;" data-dismiss="modal" aria-label="Close">
          <i class="fa fa-times fa-xl" aria-hidden="true"></i>
         </button>
      </div>
      <div class="modal-body">
        @csrf
        <input type="hidden" id="encuesta_id" name="encuesta_id" value="{{$respuestasKey}}">
        <input type="hidden" id="cuenta" name="cuenta" value="{{$cuenta}}">
        <input type="hidden" id="type" name="type" value="{{$typeStudy}}">
        <h1> {{$EgName}}</h1>
        <div class="mb-3">
          <label for="correo" style="color:white;">Correo Electrónico</label>
          <input type="email" name="correo" id="correo" class="form-control modal-input" style=" font-size: 120%;" required>
        </div>
        <div class="mb-3">
          <label for="description" style="color:white;">Description (Opcional)</label>
          <input type="text" name="description" id="description" class="form-control modal-input" style=" font-size: 120%;">
        </div>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
         <button type="submit" class="btn btn-success text-lg"> <i class="fas fa-save fa-xlg"></i> Guardar</button>
        
    
        </div>
    </form>
  </div>
</div>



<script>
$(document).ready(function() {
    $('#formCorreo').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('correos.store_async') }}",
            method: "POST",
            data: formData,
            success: function(response) {
                $('#emailModal').modal('hide');
                $('#formCorreo')[0].reset();
                // Trigger event with phone data
                let correo = response.correo;
                $(document).trigger('emailAdded', {correo: correo});
                
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Correo guardado correctamente",
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