<div class="modal fade" id="empresaModal" tabindex="-1" aria-labelledby="empresaModalLabel" aria-hidden="true">
  <div class="modal-dialog" style=" font-size: 150%;">
    <form id="formEmpresa" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"  style="color:white;">Nueva Empresa</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> -->
         <button type="button" class="close btn btn-danger" style="background-color:red;" data-dismiss="modal" aria-label="Close">
          <i class="fa fa-times fa-xl" aria-hidden="true"></i>
         </button>
      </div>
      <div class="modal-body">
        @csrf
        <div class="mb-3">
          <label style="color:white;">Nombre</label>
          <input type="text" name="nombre" id="nombre_empresa" class="form-control modal-input" style=" font-size: 120%;">
        </div>
        <div class="mb-3">
          <label style="color:white;">Sector</label>
          <select name="sector" id="sector"  class="form-control modal-input" style=" font-size: 120%;" >
                <option value="">seleccione </option>
                <option value="1"  >   Pública</option>
                <option value="2"  >   Privada</option>
                <option value="3"  >   Social</option>
          </select>
        </div>
        
        <div class="mb-3">
          <label style="color:white;">Rama</label>
          <select name="rama" id="rama"  class="form-control modal-input" style=" font-size: 120%;">
                <option value="">seleccione </option>
                <option value="1"  > 1  Agricultura, ganadería, aprovechamiento forestal, caza y pesca</option>                    
                <option value="2"  > 2  Minería</option>                    
                <option value="3"  > 3  Electricidad, agua y suministro de gas</option>                    
                <option value="4"  > 4  Construcción</option>                    
                <option value="5"  > 5  Industrias manufactureras o de la transformación</option>                    
                <option value="6"  > 6  Comercio al por mayor</option>                    
                <option value="7"  > 7  Comercio al por menor</option>                    
                <option value="8"  > 8  Transporte, correos y almacenamiento</option>                    
                <option value="9"  > 9  Información en medios masivos</option>                    
                <option value="10"  > 10  Servicios financieros y de seguros</option>                    
                <option value="11"  > 11  Servicio inmobiliario y de alquiler de bienes muebles e intangibles</option>                    
                <option value="12"  > 12  Servicios profesionales, científicos y técnicos</option>                    
                <option value="13"  > 13  Dirección de corporativos y empresas</option>                    
                <option value="14"  > 14  Servicios de apoyo a los negocios, manejo de desecho y servicios de remediación</option>                    
                <option value="15"  > 15  Servicios de salud</option>                    
                <option value="16"  > 16  Servicios educativos</option>                    
                <option value="17"  > 17  Servicios de esparcimiento cultural, deportivos y otros centros recreativos</option>                    
                <option value="18"  > 18  Servicios de alojamiento temporal, de preparación de alimentos y bebidas (hotel, restaurante, bar)</option>
                <option value="19"  > 19  Asociaciones y agrupaciones</option>  
                <option value="20"  > 20  Actividades de gobierno, organismos internacionales y extraterritoriales</option>                    
                <option value="21"  > 21  Otro</option>                    
                <option value="22"  > 22  Telecomunicaciones</option>                    
                <option value="23"  > 23  Editorial</option>                    
                <option value="24"  > 24  Servicios personales</option>                    
                <option value="25"  > 25  Servicios de reparacion y mantenimiento</option>
          </select>
        </div>
        <div class="mb-3">
          <label style="color:white;">Giro Específico</label>
          <input type="text" name="giro_especifico" id="giro_modal" class="form-control modal-input" style=" font-size: 120%;">
        </div>
        <div class="mb-3">
          <label style="color:white;">Nota</label>
          <textarea name="nota" class="form-control modal-input" style=" font-size: 120%;"></textarea>
        </div>
         <button type="submit" class="btn btn-success text-lg"> <i class="fas fa-save fa-xlg"></i> Guardar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    
        </div>
      
    </form>
  </div>
</div>

<script>
$(document).ready(function() {
    $('#formEmpresa').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('empresas.modal_store') }}",
            method: "POST",
            data: formData,
            success: function(response) {
                $('#empresaModal').modal('hide');
                $('#formEmpresa')[0].reset();
                // alert('Empresa agregada correctamente');
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Empresa guardada correctamente",
                    showConfirmButton: false,
                    timer: 1500
                    });
                setValueWithEffect(document.getElementById('ncr2'), response.data.nombre);
                setValueWithEffect(document.getElementById('ncr3'), response.data.sector);
                setValueWithEffect(document.getElementById('ncr4'), response.data.clave_giro);
                setValueWithEffect(document.getElementById('giro_especifico'), response.giro_esp);
                setValueWithEffect(document.getElementById('nota_empresa'), response.notas);

                @if($Egresado->anio_egreso==2020)
                bloquear('ncr4',[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,22,23,24,25],[ncr4a]);
                @endif
                // Aquí puedes actualizar la lista si la tienes en pantalla
            },
            
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let msg = '';
                for (let campo in errors) {
                    msg += errors[campo][0] + '\n';
                }
                alert(msg);
            }
        });
    });
});
</script>