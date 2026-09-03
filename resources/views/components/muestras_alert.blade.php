
{{--
    Componente: Alerta de muestras duplicadas
    Variables recibidas:
        $cuenta -> la cuenta del egresado para buscar en diferentes muestras
        $muestra_actual-> muestra desde donde se llama
    Descripción:
        Búsqueda escalable que verifica si una cuenta existe en múltiples muestras.
        Maneja automáticamente ceros iniciales en las cuentas.
--}}

<div id="advertencia-muestras" style="background-color:white;color:red !important"></div>

<script>
$(document).ready(function() {
    $.ajax({
        url: "{{ route('muestras.alert-check') }}",
        method: "GET",
        data: {
            cuenta: "{{ $cuenta }}",
            muestra_actual: "{{ $muestra_actual }}"
        },
        dataType: 'json',
        success: function(response) {
            if (response.existe) {
                // Construir mensaje de alertas
                let muestras = response.muestras;
                let titulo = '';
                let mensaje = '';

                // Mapeo de nombres de muestras
                if (muestras.posgrado) {
                    titulo = "Este egresado está en múltiples muestras";
                    mensaje += "⚠️ <strong>Muestra de Posgrado</strong><br>";
                }

                // Mapeo de nombres de muestras
                if (muestras.licenciatura) {
                    titulo = "Este egresado está en múltiples muestras";
                    mensaje += "⚠️ <strong>Muestra de Licenciatura</strong><br>";
                }

                if (muestras.especialidad) {
                    titulo = "Este egresado está en múltiples muestras";
                    mensaje += "⚠️ <strong>Muestra de ESPECIALIDAD</strong><br>";
                }
                if (muestras.continua) {
                    titulo = "Este egresado está en múltiples muestras";
                    mensaje += "⚠️ <strong>Muestra de EDUCACION CONTINUA</strong><br>";
                }

                // Mostrar badge en el componente
                let badgeHtml = `
                    <div   style="font-size: 16px; padding: 15px; color:white !important">
                        <strong style="font-size: 18px;">⚠️ EXISTE EN OTRAS MUESTRAS</strong><br>
                        ${mensaje}
                        
                    </div>
                `;
                $('#advertencia-muestras').html(badgeHtml);

                // Mostrar SweetAlert
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: titulo,
                    html: "<p style='background-color:#d0d0d0 !important; font-size: 20px'>" + mensaje + "Asegurate de priorizar la encuesta correspondiente </p>",
                    showConfirmButton: true,
                    confirmButtonText: "Entendido"
                });
            }
        },
        error: function(xhr) {
            console.error('Error en búsqueda de muestras:', xhr);
            let mensaje = 'Error al verificar muestras';
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                mensaje = xhr.responseJSON.message;
            }
            
            console.warn(mensaje);
            // No mostrar error al usuario si no hay coincidencias
        }
    });
});
</script>