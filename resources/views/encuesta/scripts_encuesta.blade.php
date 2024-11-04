<!-- colorear pestañas  -->
<script> 
  function hide_all(){
    sections=['A','C','D','E','F','G'];
    for (let i = 0; i < sections.length; i++) {
      document.getElementById(sections[i]+'btn').style.backgroundColor="#ffffff";
      document.getElementById(sections[i]+'txt').style.color="rgb(23,23,23)";
    }
  }
  function fill_completed(sec){
    document.getElementById(sec+'btn').style.backgroundColor="#3eb03e";
    document.getElementById(sec+'txt').style.color="white";
    document.getElementById(sec+'txt').innerHTML='<i class="fas fa-check-circle" aria-hidden="true"></i> Seccion '+sec;
  }
  function unhide(sec){
    hide_all();
    @if($Encuesta->sec_a==1)
    fill_completed('A');
    @endif
    @if($Encuesta->sec_c==1)
    fill_completed('C');
    @endif
    @if($Encuesta->sec_d==1)
    fill_completed('D');
    @endif
    @if($Encuesta->sec_e==1)
    fill_completed('E');
    @endif
    @if($Encuesta->sec_f==1)
    fill_completed('F');
    @endif
    @if($Encuesta->sec_g==1)
    fill_completed('G');
    @endif
    
    document.getElementById(sec+'btn').style.backgroundColor="{{Auth::user()->color}}";
    console.log(document.getElementById(sec+'btn').style.color);
    document.getElementById(sec+'txt').style.color="white";
  }   
</script>
<script>
  function bloquear(reactivo,options,reactivosPorCerrar){
    window.warning=true;
    var val=document.getElementById(reactivo);
    if(options.includes(parseInt(val.value))){
      console.log('Bloquear: '+reactivo)
      reactivosPorCerrar.forEach(ocultar);
    }else{
      console.log('Desbloquear: '+reactivreactivoosPorCerrar)
      reactivosPorCerrar.forEach(visibilizar);
    }
  }
  function ocultar(item){
    console.log('Ocultar: '+item.id);
    document.getElementById(item.id).hidden="hidden";
    document.getElementById(item.id).value=0;
  }
  
  function visibilizar(item){
    if(document.getElementById(item.id).value==0){
      console.log('Mostrar ' +item.id);
      document.getElementById(item.id).hidden="";
      document.getElementById(item.id).value="";
    }
  }

  var warning = false;
  window.onbeforeunload = function() { 
    if (warning) {
      return "You have made changes on this page that you have not yet confirmed. If you navigate away from this page you will lose your unsaved changes";
    }
  }
  
  $('#forma_sagrada').submit(function() {
     window.onbeforeunload = null;
  });
</script>