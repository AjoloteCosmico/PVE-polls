{{--
    Componente: agregar correo
    Variables recibidas:
        $cuenta -> la cuenta del egresado
        $respuestasKey -> id de la tabla de respuestas
        $typeStudy -> recibe 'pos' o 'seg' o 'act' o 'esp' o 'verde' o 'cont'
--}}

<div class="modal fade" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel" aria-hidden="true"  style="background: #131931;">
  <div class="modal-dialog" style=" font-size: 150%;" style="z-index:1500">
    <form id="formSendCorreo" class="modal-content">
      <div class="modal-header">
        <h5 id="sendEmailModalLabel" class="modal-title"  style="color:white;">Enviar Correo Electrónico</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> -->
         <button type="button" class="close btn btn-danger" style="background-color:red;" data-dismiss="modal" aria-label="Close">
          <i class="fa fa-times fa-xl" aria-hidden="true"></i>
         </button>
      </div>
      <div class="modal-body">
        <h1>Estas enviando un correo a  {{$EgName}}</h1>
        @csrf
        <input type="hidden" id="encuesta_id" name="encuesta_id" value="{{$respuestasKey}}">
        <input type="hidden" id="correoId" name="correo_id"  value="">
        <input type="hidden" id="email" name="correo" value="" >
        <input type="hidden" id="prog" name="prog_acad" value="" >
        <input type="hidden" id="cuenta" name="cuenta" value="{{$cuenta}}">
        <input type="hidden"  id="mail_type" name="mail_type" value="">
        <div class="mb-3">
          <label for="correo_edit" style="color:white;">Enviar Correo Electrónico</label>
          <div style="color:white; background-color: #335192; padding: 10px; border-radius: 5px; margin-bottom: 10px;">  
              <p id='correo_label'></p>
              <input type="text" id="prueba" name='prueba'>
          </div>
        </div>

        {{-- BOTONES --}}
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success text-lg"> <i class="fas fa-paper-plane fa-xlg"></i> Enviar </button>
        
    
        </div>
      
    </form>
  </div>
</div>

<script>
  window.sendEmail = function( correo_id, correo,prog_acad,mail_type) {
    // Ensure any other modal is hidden before opening the edit modal.
    $('#phoneModal').modal('hide');
    $('#emailModal').modal('hide');
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
    if (document.activeElement) {
      document.activeElement.blur();
    }

   $('#correoId').val(correo_id);
    $('#mail_type').val(mail_type);
    $('#prueba').val(correo_id);
     
    $('#email').val(correo);
    
    $('#prog').val(prog_acad);
    $('#correo_label').html('Enviar <strong>'+ mail_type +'</strong> por correo a '+correo);
    $('#sendEmailModal').modal('show');
    

  }
$(document).ready(function() {
    $('#formSendCorreo').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('send_prioritary_mail') }}",
            method: "POST",
            data: formData,
            success: function(response) {
                $('#sendEmailModal').modal('hide');
                $('#formSendCorreo')[0].reset();
                // Trigger event with phone data
                let correo = response.correo;
                // $(document).trigger('emailSended', {correo: correo});
                // alert('Empresa agregada correctamente');
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Encuesta enviada correctamente "+response.type,
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