@extends('layouts.blank_app')

@section('content')
<h1 >COMPLETAR ENCUESTA</h1>
<div  id='datos'>  @include('encuesta.personal_data') </div>
<div style="padding:1.2vw;">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}} {{str_replace('The ','',str_replace('field is required', '', $error)) }} </li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ url('encuestas/2020/E_update/'. $Encuesta->registro) }}" method="POST" enctype="multipart/form-data" id='forma_sagrada' name='forma'>
@csrf
<table class="encuesta_table">
        <!-- primera fila  -->
<tr>
<td colspan="2">
<h2 class="reactivo">  
    16.- ¿Desde que egresó de la licenciatura ha realizado actividades formales de actualización en su campo profesional?
    (cursos, diplomados,seminarios, etc.)</h2>
         <select class="select" id="ner1" name="ner1"  onchange="ner8func()" > 
        <option  value="" selected></option>
       <option value=1  @if($Encuesta->ner1==1) selected @endif>Sí</option>
       <option value=2  @if($Encuesta->ner1==2) selected @endif>No (pase a la 25)</option>
       <option value=0  hidden></option>   
</select>
</td>
<td>
<h2 class="reactivo">  
    17.- ¿Cada cuándo lo realiza?</h2>
          <select class="select" id="ner2" name="ner2"  >
          <option value=""></option>
       <option value=1  @if($Encuesta->ner2==1) selected @endif>Cada seis meses</option>
       <option value=2  @if($Encuesta->ner2==2) selected @endif>Cada año</option>
       <option value=3  @if($Encuesta->ner2==3) selected @endif>Cada dos o tres años</option>
       <option value=4  @if($Encuesta->ner2==4) selected @endif>Continuamente</option>
       <option value=0  hidden></option>   
 </select>
</td>
<td>
<h2 class="reactivo">  
    a).-¿Para su actualización ha requerido el idioma inglés o algún otro idioma?</h2>
         <select class="select" id="ner1a" name="ner1a"  > 
        <option  value="" selected></option>
       <option value=1  @if($Encuesta->ner1a==1) selected @endif>Sí</option>
       <option value=2  @if($Encuesta->ner1a==2) selected @endif>No </option>
       <option value=0  hidden></option>   
</select>
</td>

</tr>
<tr>
<td colspan="4">
<h2 class="reactivo">  
    <b>¿Dónde las ha realizado?</b></h2>
    
</td>
</tr>
<tr>
    <td>
    <h2 class="reactivo">  
    18.- En la UNAM</h2>
    <select class="select" id="ner3"  name="ner3" >
        <option value=2  @if($Encuesta->ner3==2) selected @endif>No</option>
        <option value=1  @if($Encuesta->ner3==1) selected @endif>Sí</option>
       <option value=0  hidden></option>   
</select>
    </td>
<td>
   
<h2 class="reactivo">  
    19.- En otra institución pública</h2>
    <select class="select" id="ner4" name="ner4" >
        <option value=2  @if($Encuesta->ner4==2) selected @endif>No</option>
        <option value=1  @if($Encuesta->ner4==1) selected @endif>Sí</option>
       <option value=0  hidden></option>   
</select> 
</td>
<td>
<h2 class="reactivo">  
20.- En otra institución privada</h2>
    <select class="select" id="ner5" name="ner5" >
      <option value=2  @if($Encuesta->ner5==2) selected @endif>No</option>
      <option value=1  @if($Encuesta->ner5==1) selected @endif>Sí</option>
      <option value=0  hidden></option>   
</select>  
</td>
<td>
    
<h2 class="reactivo">  
    21.-En la empresa o institución en la que trabaja</h2>
    <select class="select" id="ner6" name="ner6" >
    <option value=2  @if($Encuesta->ner6==2) selected @endif>No</option>
    <option value=1  @if($Encuesta->ner6==1) selected @endif>Sí</option>
    <option value=0  hidden></option>   
</select>
</td>
</tr>
<tr>
<td>
<h2 class="reactivo">  
    22.-En una asociación</h2>
    <select class="select" id="ner7" name="ner7" >
    <option value=2  @if($Encuesta->ner7==2) selected @endif>No</option>
    <option value=1  @if($Encuesta->ner7==1) selected @endif>Sí</option>
    <option value=0  hidden></option>  
    <option value=0  hidden></option>   
</select>
</td>
<td>
      
<h2 class="reactivo">  
    23.-En Internet</h2>
    <select class="select" id="ner7int" name="ner7int" >
      <option value=2  @if($Encuesta->ner7int==2) selected @endif>No</option>
      <option value=1  @if($Encuesta->ner7int==1) selected @endif>Sí</option>
      <option value=0  hidden></option>   
</select>
</td>
<td colspan="2">
<h2 class="reactivo">  24.-Otro lugar ¿Cúal?</h2>
 <INPUT id="ner7_a" NAME="ner7_a" TYPE=TEXT class="texto"  value="{{$Encuesta->ner7_a}} " MAXLENGTH=60 >
      
</td>
</tr>
<tr>
    <td colspan= "4"><h2 class="reactivo">  
    <B>Ha realizado estudios de:</B> <BR></h2>
   </td>
</tr>
<tr>
<td>
<h2 class="reactivo">  
    25.- <B>¿Posgrado?</B></h2>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <select class="select" id="ner8" name="ner8"  onchange="bloquear('ner8',[2],[ner9,ner10,ner10a,ner11,ner12, @if(($Egresado->carrera==208) || ($Egresado->carrera ==202)) ner12b,ner12a,ner12ext, @endif ner13,ner14,ner15,ner16,ner17,ner18,ner19])" >
       <option selected="selected" value="">
       <option value=1  @if($Encuesta->ner8==1) selected @endif>Sí</option>
       <option value=2  @if($Encuesta->ner8==2) selected @endif>No (pase a la 35)</option >
       <option value=0  hidden></option>   
</select> 
</td>
<td colspan="2">
<h2 class="reactivo">  
    25a)-¿En qué medida están relacionados  los estudios de posgrado con su carrera profesional?</h2>
    <select class="select" id="ner9" name="ner9" >
       <option selected="selected" value="">
       <option value=1  @if($Encuesta->ner9==1) selected @endif>Muy relacionados</option>
       <option value=2  @if($Encuesta->ner9==2) selected @endif>Medianamente relacionados</option>
     <option value=3  @if($Encuesta->ner9==3) selected @endif>Poco o nada relacionados</option>
     <option value=0  hidden></option>   
</select>
 
</td>
</tr>

<tr>
<td> <h2 class="reactivo"> 
    26.- <B>¿Especialización?</B> </h2>
    <select class="select" id="ner10" name="ner10"  onchange="bloquear('ner10',[2],[ner10a,ner11,ner12,ner12ext]);" >
      <option selected="selected" value="">
      <option value=1  @if($Encuesta->ner10==1) selected @endif>Sí</option>
      <option value=2  @if($Encuesta->ner10==2) selected @endif>No</option>
      <option value=0  hidden></option>   
</select>
</td>
<td>
<h2 class="reactivo">  
    ¿Cuál? </h2>
    <INPUT   id="ner10a" name="ner10a" TYPE=TEXT class="texto"  value=" {{str_replace('0','',$Encuesta->ner10a)}}" MAXLENGTH=60 >
</td>

<td>
<h2 class="reactivo"> 
 26a).- ¿Ya se graduó? </h2>
    <select class="select" id="ner11" name="ner11" >
      <option selected="selected" value="">
      <option value=1  @if($Encuesta->ner11==1) selected @endif>Sí</option>
      <option value=2  @if($Encuesta->ner11==2) selected @endif>No</option>
      <option value=0  hidden></option>   
</select>
</td>
<td>
<h2 class="reactivo"> 
    27.- ¿En dónde los hizo? </h2>
     <select class="select" id="ner12" name="ner12"  onchange="bloquear('ner12',[0,1,2,3],[ner12ext])">
       <option selected="selected" value="">
       <option value=1  @if($Encuesta->ner12==1) selected @endif>En la UNAM</option>
       <option value=2  @if($Encuesta->ner12==2) selected @endif>En otra institución pública</option>
       <option value=3  @if($Encuesta->ner12==3) selected @endif>En otra institución privada</option>
       <option value=4  @if($Encuesta->ner12==4) selected @endif>En el extranjero</option>
       <option value=0  hidden></option>   
</select>

<h2 class="reactivo">27a.- Extranjero Especifique: </h2>

 <INPUT type="text" class="texto " id="ner12ext" name="ner12ext" value="{{$Encuesta->ner12text}}" style="width:60%"  maxlength="100"  >

</td>
</tr>

<tr>
    <td>
    <h2 class="reactivo">  
    28.- <b>¿Maestría?</b></h2>
    <select class="select" id="ner13" name="ner13"  onchange="bloquear('ner13',[2],[ner14,ner15,ner15ext])" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ner13==1) selected @endif>Sí</option>
        <option value=2  @if($Encuesta->ner13==2) selected @endif>No</option>
        <option value=0  hidden></option>   
</select>
    </td>

    <td>
    <h2 class="reactivo">  
    28a).- ¿Ya se graduó?</h2>
    <select class="select" id="ner14" name="ner14" >
       <option selected="selected" value="">
       <option value=1  @if($Encuesta->ner14==1) selected @endif>Sí</option>
       <option value=2  @if($Encuesta->ner14==2) selected @endif>No</option>
       <option value=0  hidden></option>   
</select>
    </td>

    <td>
    <h2 class="reactivo"> 
    29.- ¿En dónde los hizo? </h2>
    <select class="select" id="ner15"  name="ner15"  onchange="bloquear('ner15',[0,1,2,3],[ner15ext])" >
       <option selected="selected" value="">
       <option value=1  @if($Encuesta->ner15==1) selected @endif>En la UNAM</option>
       <option value=2  @if($Encuesta->ner15==2) selected @endif>En otra institución pública</option>
       <option value=3  @if($Encuesta->ner15==3) selected @endif>En otra institución privada</option>
       <option value=4  @if($Encuesta->ner15==4) selected @endif>En el extranjero</option>
       <option value=0  hidden></option>   
</select>
<h2 class="reactivo">29a.- Extranjero Especifique: </h2>

        <INPUT type="text" class="texto " id="ner15ext" name="ner15ext" value="{{$Encuesta->ner15text}}" style="width:60%"  maxlength="100"  >
    </td>
    <td>
    </td>
</tr>
<tr>
<td>
    <h2 class="reactivo">
        30.-¿Subespecialización? (solo médicos)  
    </h2>
    <select class="select" id="ner12a" name="ner12a" onchange="bloquear('ner12a',[2],[ner12b])" @if(($Egresado->carrera!=208) && ($Egresado->carrera !=202)) hidden value=0 @endif>
      <option value=0 >-</option>
      <option value=1  @if($Encuesta->ner12a==1) selected @endif>Sí</option>
      <option value=2  @if($Encuesta->ner12a==2) selected @endif>No</option>
      <option value=0  hidden></option>   
    </select></td>

    <td clospan="2">
    <h2 class="reactivo">  
    30a).-¿En qué área? </h2>
    <INPUT   id="ner12b" name="ner12b" TYPE=TEXT  class="texto" value=" "  MAXLENGTH=60 @if(($Egresado->carrera!=208) && ($Egresado->carrera !=202)) hidden value=0 @endif>
    </td>

    <td></td> <td></td>
</tr>

<tr>
<td colspan="2">
<h2 class="reactivo">  
    31.-¿Ha realizado estudios de Doctorado?</h2>
    <select class="select" id="ner16" name="ner16"  onchange="bloquear('ner16',[2],[ner17,ner18,ner18ext])" >
      <option selected="selected" value="">
      <option value=1  @if($Encuesta->ner16==1) selected @endif>Sí</option>
      <option value=2  @if($Encuesta->ner16==2) selected @endif>No (Pase a la 34)</option>
      <option value=0  hidden></option>   
</select>
</td>
<td>
<h2 class="reactivo">  
   32.- ¿Ya se graduó?</h2>
    <select class="select" id="ner17" name="ner17" @if($Encuesta->ner16==2) hidden value=0 @endif>
    <option selected="selected" value="">
      <option value=1  @if($Encuesta->ner17==1) selected @endif>Sí</option>
       <option value=2  @if($Encuesta->ner17==2) selected @endif>No</option>
       <option value=0  hidden></option>   
</select>  
</td>
<td>
<h2 class="reactivo">  
    33).- ¿En dónde los hizo?-</h2>
    <select class="select" id="ner18" name="ner18" onchange="bloquear('ner18',[0,1,2,3],[ner18ext])">
       <option selected="selected" value="">
       <option value=1  @if($Encuesta->ner18==1) selected @endif>En la UNAM</option>
       <option value=2  @if($Encuesta->ner18==2) selected @endif>En otra institución pública</option>
       <option value=3  @if($Encuesta->ner18==3) selected @endif>En otra institución privada</option>
       <option value=4  @if($Encuesta->ner18==4) selected @endif>En el extranjero</option>
       <option value=0  hidden></option>   
 </select>
 <h2 class="reactivo">33a.- Extranjero Especifique: </h2>

<INPUT type="text" class="texto " id="ner18ext" name="ner18ext" value="{{$Encuesta->ner18text}}" style="width:60%"  maxlength="100"  >
 
</td>
</tr>
<tr>
<td colspan="4">
<h2 class="reactivo">  
    <BR>34.-¿Cuál es la razón más importante por la que realiza(ó) estos estudios (posgrado y/o especialidad y/o doctorado)?
    </h2>
     <select class="select" id="ner19" name="ner19"  > 
       <option selected="selected" value="">
       <option value=1   @if($Encuesta->ner19==1) selected @endif> Interés por la investigación</option>
       <option value=2  @if($Encuesta->ner19==2) selected @endif> Interés en profundizar en la disciplina</option>
       <option value=3  @if($Encuesta->ner19==3) selected @endif> Quería cambiar de campo</option>
       <option value=4  @if($Encuesta->ner19==4) selected @endif> Falta de oportunidades de empleo en la carrera</option>
       <option value=5  @if($Encuesta->ner19==5) selected @endif> Incrementar ingresos</option>
       <option value=6  @if($Encuesta->ner19==6) selected @endif> Alcanzar un nivel más alto en el trabajo</option>
       <option value=7  @if($Encuesta->ner19==7) selected @endif> Otra</option>
       <option value=0  hidden></option>   
</select> 
</td>
</tr>

</table>
<button class="btn fixed" name='boton1'  value=0 type="summit" onclick="post_data()" style="background-color:{{Auth::user()->color}} ; color:white; display: flex;">
<i class="fas fa-save"></i> &nbsp; GUARDAR <br> SECCION
  </button>
  </form>
</div>

@endsection


@push('js')

<script>
  unhide('E');
  reactivos=document.getElementById("forma_sagrada").elements
  for (var i=0, item; item = reactivos[i]; i++) {
  // Look no need to do list[i] in the body of the loop
  console.log("'"+item.name+"' => 'required',");
}
</script>
<script>
 @foreach ($errors->all() as $error)
                document.getElementById( "{{str_replace('The ','',str_replace(' field is required.', '', $error)) }}").style="border: 0.3vw  solid red";
  @endforeach
</script>
@if($errors->any())
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
  Swal.fire({
  title: "Sección Incompleta",
  text: "faltan algunas respuestas, se marcaran en rojo",
  icon: "warning",
});
</script>
@endif

<script>

    function ner8func(){
        bloquear('ner1',[2],[ner2,ner1a,ner3,ner4,ner5,ner6,ner7,ner7int,ner7_a])
        var val=document.getElementById('ner1').value;
        if(val ==1){
            ['ner3','ner4','ner5','ner6','ner7','ner7int'].forEach((reactivo)=>{
               console.log(reactivo);
               document.getElementById(reactivo).value=2;
            })
        }
    }

    console.log('bloquenado ando');
  bloquear('ner1',[2],[ner2,ner1a,ner3,ner4,ner5,ner6,ner7,ner7int,ner7_a]);

  bloquear('ner8',[2],[ner9,ner10,ner10a,ner11,ner12, ner12ext, @if(($Egresado->carrera==208) || ($Egresado->carrera ==202)) ner12b,ner12a, @endif ner13,ner14,ner15,ner16,ner17,ner18,ner19]);
  @if(($Egresado->carrera!=208) && ($Egresado->carrera !=202))
   [ner12b,ner12a].forEach(ocultar);
    @endif 
  bloquear('ner8',[2],[ner9,ner10,ner10a,ner11,ner12,ner12ext, @if(($Egresado->carrera==208) || ($Egresado->carrera ==202)) ner12b,ner12a, @endif ner13,ner14,ner15,ner15ext,ner16,ner17,ner18,ner18ext,ner19]);
  @if($Encuesta->ner8 == 1)
  bloquear('ner10',[2],[ner10a,ner11,ner12,ner12ext]);
  bloquear('ner13',[2],[ner14,ner15,ner15ext]);
  bloquear('ner16',[2],[ner17,ner18,ner18ext]);
  bloquear('ner18',[0,1,2,3],[ner18ext]);
  bloquear('ner15',[0,1,2,3],[ner15ext]);
  bloquear('ner12',[0,1,2,3],[ner12ext]);
  @endif
  var warning = false;
</script>
@if($Encuesta->ner15ext)
    <script>
        console.log('change ner15ext');
        document.getElementById('ner15ext').value='{{$Encuesta->ner15ext}}';
    </script>
@endif
@if($Encuesta->ner18ext)
    <script>
        console.log('change ner18ext');
        document.getElementById('ner18ext').value='{{$Encuesta->ner18ext}}';
    </script>
@endif
@endpush