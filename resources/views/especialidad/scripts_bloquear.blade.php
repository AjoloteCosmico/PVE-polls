<script>
array_bloqueos={
    @foreach($Reactivos as $reactivo)
    '{{$reactivo->clave}}':{
       @php
        $ThisBloqueos=$BloqueosSeccion->where('clave_reactivo',$reactivo->clave);
       @endphp

       @foreach($ThisBloqueos->unique('valor')->pluck('valor') as $bloqueo_value)
        @php
            $BloqueosParaValor = $ThisBloqueos->filter(fn($b) => $b->valor == $bloqueo_value);
        @endphp

        {{$bloqueo_value}}:[@foreach($ThisBloqueos->where('valor',$bloqueo_value)->unique('bloqueado')->pluck('bloqueado') as $bloqueado) '{{$bloqueado}}', @endforeach ],
       @endforeach
       
       'involucrados': [@foreach($ThisBloqueos->unique('bloqueado')->pluck('bloqueado') as $bloqueado) '{{$bloqueado}}', @endforeach ]
       },
       @endforeach
      };
    // Función de bloqueo 
function checkBloqueos(reactive, isInitialLoad = false) {
    console.log('---CHANGE: ' + reactive + ' Ha cambiado');

    const elemento = document.getElementById(reactive);
    let selected_values = [];

    
    if (elemento && elemento.tagName === 'SELECT') {
        if (elemento.value) selected_values.push(elemento.value);
    } else {
        const checkboxes = document.querySelectorAll(`[id^="${reactive}-"]:checked`);
        checkboxes.forEach(checkbox => {
            selected_values.push(checkbox.value);
        });
    }

    // se usa para distiguir entre la carga inicial o un cambio posterior
    if (!isInitialLoad) {
        const involucrados = array_bloqueos[reactive]?.involucrados || [];
        involucrados.forEach(involucrado => {
            if (!involucrado) return; 

            const elemento_bloqueado = document.getElementById(involucrado);
            const contenedor_bloqueado = document.getElementById('container' + involucrado);
            
            if (elemento_bloqueado && contenedor_bloqueado) {
                if (!contenedor_bloqueado.classList.contains('bloqueado_inicialmente')) {
                    console.log('desbloqueando ' + involucrado);
                    if (elemento_bloqueado.value === '0') elemento_bloqueado.value = '';
                    
                    contenedor_bloqueado.style.backgroundColor = 'transparent';
                    elemento_bloqueado.style.backgroundColor = 'white';
                    elemento_bloqueado.disabled = false;

                    // Desbloquear radios/ratings
                    let radio_buttons = document.querySelectorAll(`#${involucrado} input[type="radio"]`);
                    radio_buttons.forEach(radio => {
                        radio.disabled = false;
                        radio.style.backgroundColor = 'transparent';
                    });
                    
                    let radio_button_divs = contenedor_bloqueado.querySelectorAll(`.rating-option-wrapper`);
                    radio_button_divs.forEach(radio => {
                        radio.style.backgroundColor = 'transparent';
                        elemento_bloqueado.style.backgroundColor = 'transparent';
                    });
                }
            }
            $('[id^="' + involucrado + '-"]').prop('disabled', false);
        });
    }

     // 2. Bloquear los reactivos basándose en los valores seleccionados
    selected_values.forEach(selected_value => {
        const reactivos_a_bloquear = array_bloqueos[reactive]?.[selected_value] || [];

        if (reactivos_a_bloquear.length > 0) {
            console.log('se bloquea por valor ' + selected_value + ': ', reactivos_a_bloquear);

            reactivos_a_bloquear.forEach(bloqueado => {
                if (!bloqueado) return; 

                //IF DE FEL
                if (selected_values.includes("1") && (bloqueado === 'edc5' || bloqueado === 'edc5otra')) {
                    console.log('-> Ignorando bloqueo de ' + bloqueado + ' porque la opción 1 está activa');
                    return; 
                }

                const elemento_bloqueado = document.getElementById(bloqueado);
                const contenedor_bloqueado = document.getElementById('container' + bloqueado);
                
                if (elemento_bloqueado && contenedor_bloqueado) {
                    console.log('bloqueando ' + bloqueado + ' por valor ' + selected_value);
                    elemento_bloqueado.value = '0';
                    contenedor_bloqueado.style.backgroundColor = '#252E56';
                    elemento_bloqueado.style.backgroundColor = 'gray';
                    elemento_bloqueado.disabled = true;
                    //si  el reactivo es un rating,
                    let radio_buttons = document.querySelectorAll(`#${bloqueado} input[type="radio"]`);
                    radio_buttons.forEach(radio => {
                        radio.checked = false;
                        radio.disabled = true;
                        radio.style.backgroundColor = '#252E56';
                    });
                    
                    let radio_button_divs = contenedor_bloqueado.querySelectorAll(`.rating-option-wrapper`);
                    radio_button_divs.forEach(radio => {
                        radio.style.backgroundColor = '#08090a';
                    });
                }
                $('[id^="' + bloqueado + '-"]').prop('disabled', true);
            });
        }
    });

    if (selected_values.length === 0) {
            console.log('Ninguna opción seleccionada, nada por cerrar.');
        }
}

    //aplica estilo de bloquepo a las preguntas que venian bloqueadas
    document.addEventListener('DOMContentLoaded', (event) => {
        
        const contenedoresBloqueados = document.querySelectorAll('.bloqueado_inicialmente');
    
        contenedoresBloqueados.forEach(contenedor_bloqueado => {
            const id_contenedor = contenedor_bloqueado.id; 
            const bloqueado = id_contenedor.replace('container', ''); 
        
            const elemento_bloqueado = document.getElementById(bloqueado);

            
            if (elemento_bloqueado && contenedor_bloqueado) {
                console.log('Aplicando estilos iniciales a ' + bloqueado);
                contenedor_bloqueado.style.backgroundColor = '#252E56';
            
                
                if (elemento_bloqueado.tagName !== 'INPUT' || elemento_bloqueado.type !== 'hidden') {
                    elemento_bloqueado.style.backgroundColor = 'gray';
                    elemento_bloqueado.disabled = true;
                }
            
                  //si  el reactivo es un rating,
                    radio_buttons=document.querySelectorAll(`#${bloqueado} input[type="radio"]`);
                    // console.log('Radio buttons a bloquear: ', radio_buttons);
                    radio_buttons.forEach(radio => {
                        radio.checked = false;
                        radio.disabled = true;
                        radio.style.backgroundColor = '#252E56';
                    });
                    radio_button_divs=contenedor_bloqueado.querySelectorAll(`.rating-option-wrapper`);
                    // console.log('Radio buttons a bloquear: ', radio_buttons);
                    radio_button_divs.forEach(radio => {
                        elemento_bloqueado.style.backgroundColor = 'transparent';
                        radio.style.backgroundColor = '#252E56';
                    });
            }
        });
    
        
        const reactivos_disparadores = Object.keys(array_bloqueos);
        reactivos_disparadores.forEach(reactive => {
            checkBloqueos(reactive, true); 
        });
    });




 // Inicializa los bloqueos cuuando la página carga
    document.addEventListener('DOMContentLoaded', (event) => {
        const reactivos_disparadores = Object.keys(array_bloqueos);

        // 
        reactivos_disparadores.forEach(reactive => {
            checkBloqueos(reactive, true); 
        });
    });



</script>