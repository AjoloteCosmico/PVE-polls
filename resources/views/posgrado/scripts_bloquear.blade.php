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