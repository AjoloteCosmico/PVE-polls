<script>
array_bloqueos={
    @foreach($Reactivos as $reactivo)
    '{{$reactivo->clave}}':{
       @php
        $ThisBloqueos=$Bloqueos->where('clave_reactivo',$reactivo->clave);
       @endphp
       @foreach($ThisBloqueos->unique('valor')->pluck('valor') as $bloqueo_value)
        {{$bloqueo_value}}:[@foreach($ThisBloqueos->where('valor',$bloqueo_value)->unique('bloqueado')->pluck('bloqueado') as $bloqueado) '{{$bloqueado}}', @endforeach ],
       @endforeach
       'involucrados': [@foreach($ThisBloqueos->unique('bloqueado')->pluck('bloqueado') as $bloqueado) '{{$bloqueado}}', @endforeach ]
       },
       @endforeach
      };



/*
//funcion que revisa todos los bloqueos
 function checkBloqueos(reactive){
  console.log('---CHANGE: '+reactive+' Ha cambiado');
  //get current value
  selected_value=document.getElementById(reactive).value;
  console.log('valor del reactivo:'+String(selected_value));
//   busca todos los bloquos con el reactivo que cambio involucrado 
//abrir los reactivos involucrados
 //ubvicar reactivos involucrados que se cerrarian con algun valor 
    //Asegurarse de que todo lo que deba estar abierto se abra
    console.log('volver a abrir los ractivos: ');
    // Accede al diccionario 'pbr1'
    // Extrae los valores y conviértelos en un Set para eliminar duplicados
    const valoresUnicos = new Set(Object.values(array_bloqueos[reactive]['involucrados']));

    const main_element = document.getElementById(reactive);
    const reactivo_type = main_element ? main_element.dataset.type : null;

    // Itera sobre los reactivos involucrados, deben volver a abrirse
    valoresUnicos.forEach(valor => {
      console.log('desbloquear '+valor);
      
        if(document.getElementById(valor).value==0){
              document.getElementById(valor).value='';
            }
            // document.getElementById('container'+valor).style.display='block';
            document.getElementById('container'+valor).style.backgroundColor ='transparent';
            document.getElementById(valor).style.backgroundColor = "white";
            document.getElementById(valor).disabled= false;
            console.log('desbloqueo realized-----')
            
    });
// (como detonador del bloqueo segun su valor)
//luego filtra por el valor actual del reactivo para saber si hay que ocultar alguna pregunta
  if(array_bloqueos[reactive][selected_value]){
    //si existe un bloqueo de este reactivo con este valor 
    const valoresUnicos = new Set(Object.values(array_bloqueos[reactive][selected_value]));
    console.log(valoresUnicos)
    console.log('se bloquea: '+array_bloqueos[reactive][selected_value]);
    valoresUnicos.forEach(valor => {
      //valor sera 0.
      console.log('ciclo '+ valor);
      document.getElementById(valor).value=0;
      //ocultar la cajita
      console.log('ocultar caja con id '+'container'+array_bloqueos[reactive][selected_value])
      // document.getElementById('container'+valor).style.display='none';
      document.getElementById('container'+valor).style.backgroundColor = "#252E56";
      console.log('input con id ' +valor)
      document.getElementById(valor).style.backgroundColor = "gray";
      document.getElementById(valor).disabled= true;
    });

  }else{
   console.log('nada por cerrar');
    
  }
//bloquear los reactivos necesarios que estan ivolucrados 
 }
 */

//Update

function checkBloqueos(reactive) {
    console.log('---CHANGE: ' + reactive + ' Ha cambiado');

    // Identificar el tipo de reactivo para obtener el valor de forma correcta
    const elemento = document.getElementById(reactive);
    let selected_values = [];

    // Si es un <select>
    if (elemento && elemento.tagName === 'SELECT') {
        const selected_value = elemento.value;
        if (selected_value) {
            selected_values.push(selected_value);
        }
    } 
    // Si son <checkbox>
    else {
        const checkboxes = document.querySelectorAll(`[id^="${reactive}-"]:checked`);
        checkboxes.forEach(checkbox => {
            selected_values.push(checkbox.value);
        });
    }

    // 1. Desbloquear todos los reactivos involucrados previamente
    const involucrados = array_bloqueos[reactive]?.involucrados || [];
    involucrados.forEach(involucrado => {
        const elemento_bloqueado = document.getElementById(involucrado);
        const contenedor_bloqueado = document.getElementById('container' + involucrado);

        if (elemento_bloqueado && contenedor_bloqueado) {
            console.log('desbloqueando ' + involucrado);
            if (elemento_bloqueado.value === '0') {
                elemento_bloqueado.value = '';
            }
            contenedor_bloqueado.style.backgroundColor = 'transparent';
            elemento_bloqueado.style.backgroundColor = 'white';
            elemento_bloqueado.disabled = false;
        }
    });

    // 2. Bloquear los reactivos basándose en los valores seleccionados
    selected_values.forEach(selected_value => {
        const reactivos_a_bloquear = array_bloqueos[reactive]?.[selected_value] || [];

        if (reactivos_a_bloquear.length > 0) {
            console.log('se bloquea por valor ' + selected_value + ': ', reactivos_a_bloquear);

            reactivos_a_bloquear.forEach(bloqueado => {
                const elemento_bloqueado = document.getElementById(bloqueado);
                const contenedor_bloqueado = document.getElementById('container' + bloqueado);

                if (elemento_bloqueado && contenedor_bloqueado) {
                    console.log('bloqueando ' + bloqueado);
                    elemento_bloqueado.value = '0';
                    contenedor_bloqueado.style.backgroundColor = '#252E56';
                    elemento_bloqueado.style.backgroundColor = 'gray';
                    elemento_bloqueado.disabled = true;
                }
            });
        }
    });

    if (selected_values.length === 0) {
        console.log('Ninguna opción seleccionada, nada por cerrar.');
    }
}

 reactivos_por_revisar=[@foreach($Bloqueos->sortBy('act_order')->unique('clave_reactivo')->pluck('clave_reactivo') as $r) '{{$r}}', @endforeach];
 reactivos_por_revisar.forEach(reactivo => {
  checkBloqueos(reactivo);

 });
 

 @if($Encuesta->ner8==2)
 checkBloqueos('ner8');
 @endif
 
 @if($Encuesta->nar8==1)
 checkBloqueos('nar8');
 @endif
 
 @if($Encuesta->ner12==2)
 checkBloqueos('ner12');
 @endif
 
 @if($Encuesta->ner1a==2)
 checkBloqueos('ner1a');
 @endif
 @if($Encuesta->ner18==2)
 checkBloqueos('ner18');
 @endif

</script>