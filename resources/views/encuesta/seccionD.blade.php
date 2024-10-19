@extends('layouts.blank_app')

@section('content')
<h1 > COMPLETAR ENCUESTA </h1>
<div  id='datos'>  @include('encuesta.personal_data') </div>

<div style="padding:1.2vw;">
<form action="{{ url('encuestas/2020/D_update/'. $Encuesta->registro) }}" method="POST" enctype="multipart/form-data" id='forma_sagrada' name='forma'>
@csrf
<table class="encuesta_table">
        <!-- primera fila  -->
<tr>
<td colspan="2">
<h2 class="reactivo">85.- ¿Comó fue su transición de la universidad al mercado laboral, en terminos de encontrar un trabajo relacionado con su campo profesional?    </h2>

 
<select class="select" id="ndr1" name="ndr1" onchange="bloquear('ndr1',[6,7],[ndr2,ndr2_a,ndr3,ndr8,ndr4,ndr9,ndr5,ndr10,ndr6,ndr11,ndr7,ndr12,ndr12a,ndr12b,ndr12c,ndr13a,ndr14,ndr15,ndr16,ndr17 @if($Encuesta->ncr1<=2) ,ndr18,ndr19 @endif])" >
        <option value="" selected></option>
        <option value=1  @if($Encuesta->ndr1==1) selected @endif>Muy fácil</option>
        <option value=2  @if($Encuesta->ndr1==2) selected @endif>Fácil</option> 
        <option value=3  @if($Encuesta->ndr1==3) selected @endif>Medianamente</option> 
        <option value=4  @if($Encuesta->ndr1==4) selected @endif>Difícil</option> 
        <option value=5  @if($Encuesta->ndr1==5) selected @endif>Muy difícil</option> 
        <option value=6  @if($Encuesta->ndr1==6) selected @endif>No he buscado un trabajo relacionado con mi carrera (Pase 61)</option> 
        <option value=7  @if($Encuesta->ndr1==7) selected @endif>No he encontrado un trabajo relacionado con mi carrera (Pase 61)</option> 
        <option value=0  hidden></option>   
</select>



    </td>
<td>
<h2 class="reactivo"> 86.- ¿Cómo encontró su primer  trabajo  en  su  campo profesional?   </h2>
<select class="select" id="ndr2" name="ndr2" onchange="funcion_ndr2()">
<option selected="selected" value="">
<option value=6  @if($Encuesta->ndr2==6) selected @endif>Aviso en el periódico</option>
<option value=9  @if($Encuesta->ndr2==9) selected @endif>Autoempleo (Pase a la 98)</option>
<option value=1  @if($Encuesta->ndr2==1) selected @endif>En la bolsa de trabajo de la UNAM</option>
<option value=2  @if($Encuesta->ndr2==2) selected @endif>En otra bolsa de trabajo</option>
<option value=8  @if($Encuesta->ndr2==8) selected @endif>Por relaciones en el servicio social</option>
<option value=10 @if($Encuesta->ndr2==10) selected @endif>Integración a un negocio familiar (Pase a la 98)</option>
<option value=11 @if($Encuesta->ndr2==11) selected @endif>Iniciativa propia</option>
<option value=7  @if($Encuesta->ndr2==7) selected @endif>Relaciones laborales previas</option>
<option value=3  @if($Encuesta->ndr2==3) selected @endif>Recomendado por amigos</option>
<option value=4  @if($Encuesta->ndr2==4) selected @endif>Recomendado por parientes</option>
<option value=5  @if($Encuesta->ndr2==5) selected @endif>Recomendado por un profesor</option>
<option value=12  @if($Encuesta->ndr2==12) selected @endif>Internet (especifíque)</option>
<option value=13  @if($Encuesta->ndr2==13) selected @endif>Prácticas profesionales (especifíque)</option>
<option value=14  @if($Encuesta->ndr2==14) selected @endif>Ofrecimiento directo (especifíque)</option>
<option value=16  @if($Encuesta->ndr2==16) selected @endif>Anuncio</option>
<option value=17  @if($Encuesta->ndr2==17) selected @endif>Convocatoria o Examen de selecci&oacuten</option>
<option value=18  @if($Encuesta->ndr2==18) selected @endif>Ya trabajaba ahí antes de la Lic.</option>

<option value=15  @if($Encuesta->ndr2==15) selected @endif>Otra forma (especifíque)</option>
<option value=0  hidden></option>   
</select>
</td>
<td>
<br>Especifíque:
<INPUT id="ndr2_a" class="texto"  NAME="ndr2_a"  TYPE=TEXT SIZE="60" MAXLENGTH="60" value="{{$Encuesta->ndr2_a}}">

    </td>
</tr>

<tr>
<td colspan="4">
<h2 class="reactivo largo"> <b>¿Qué tan importantes fueron cada uno de los siguientes factores para su contratación, en su primer trabajo?  </b> </h2>
    </td>
</tr>
<tr>
<td>
<h2 class="reactivo">  87).- El prestigio de la UNAM </h2>
  

	<select class="select" id="ndr3" name="ndr3" >
        <option value="">
        <option value=1  @if($Encuesta->ndr3==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr3==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr3==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr3==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr3==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>
</td>
<td>
<h2 class="reactivo">88).- Su comportamiento en la entrevista y/o en los exámenes de selección  </h2>
	<select class="select" id="ndr8" name="ndr8" >
        <option selected="selected" value="">
        <option value=1   @if($Encuesta->ndr8==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr8==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr8==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr8==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr8==5) selected @endif>Nada importante </option> 
  <option value=0  hidden></option>   
</select>
</td>
<td>
<h2 class="reactivo"> 	89.- Sus conocimientos sobre la carrera </h2>

	<select class="select" id="ndr4" name="ndr4" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr4==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr4==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr4==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr4==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr4==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>

 </td>
<td>
<h2 class="reactivo">  90.- Recomendaciones</h2>


	<select class="select" id="ndr9" name="ndr9" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr9==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr9==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr9==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr9==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr9==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>

      </td>
</tr>

<tr>
<td>
<h2 class="reactivo"> 91.- Sus conocimientos sobre computación   </h2>
	<select class="select" id="ndr5" name="ndr5" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr5==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr5==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr5==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr5==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr5==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>

</td>
<td>
<h2 class="reactivo">92.- Su género (sexo)  </h2>
	<select class="select" id="ndr10" name="ndr10" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr10==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr10==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr10==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr10==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr10==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>

            </td>
<td>
<h2 class="reactivo"> 93.- Su  dominio  del inglés   </h2>
	<select class="select" id="ndr6" name="ndr6" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr6==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr6==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr6==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr6==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr6==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>
 

            </td>
<td>
<h2 class="reactivo"> 94.- Su edad  </h2>
	<select class="select" id="ndr11" name="ndr11" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr11==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr11==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr11==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr11==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr11==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>

            </td>
</tr>

<tr>
<td>
<h2 class="reactivo">	95.- Su dominio de otro idioma  </h2>
	<select class="select" id="ndr7" name="ndr7" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr7==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr7==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr7==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr7==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr7==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>
</td>
<td>
<h2 class="reactivo"> 96.- Su estado civil       </h2>
	<select class="select" id="ndr12" name="ndr12" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr12==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr12==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr12==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr12==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr12==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
 </select>
            </td>
<td>
<h2 class="reactivo">96.1 - Cercanía al domicilio.  </h2>
	      <select class="select" id="ndr12a" name="ndr12a" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr12a==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr12a==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr12a==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr12a==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr12a==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>

            </td>
<td>
<h2 class="reactivo">96.2 - Experiencia profesional    </h2>
	<select class="select" id="ndr12b" name="ndr12b" >
        <option selected="selected" value="">
        <option value=1  @if($Encuesta->ndr12b==1) selected @endif>Muy importante</option>
        <option value=2  @if($Encuesta->ndr12b==2) selected @endif>Importante</option> 
        <option value=3  @if($Encuesta->ndr12b==3) selected @endif>Medianamente importante</option> 
        <option value=4  @if($Encuesta->ndr12b==4) selected @endif>Poco importante</option> 
        <option value=5  @if($Encuesta->ndr12b==5) selected @endif>Nada importante </option> 
        <option value=0  hidden></option>   
</select>

            </td>
</tr>
<tr>
<td>
<h2 class="reactivo"> 96.3 - Título profesional.   </h2>
	      <select class="select" id="ndr12c" name="ndr12c" >
          <option selected="selected" value="">
          <option value=1  @if($Encuesta->ndr12c==1) selected @endif>Muy importante</option>
          <option value=2  @if($Encuesta->ndr12c==2) selected @endif>Importante</option> 
          <option value=3  @if($Encuesta->ndr12c==3) selected @endif>Medianamente importante</option> 
          <option value=4  @if($Encuesta->ndr12c==4) selected @endif>Poco importante</option> 
          <option value=5  @if($Encuesta->ndr12c==5) selected @endif>Nada importante </option> 
          <option value=0  hidden></option>   
</select>
    </td>
<td>
<h2 class="reactivo">97.- Otro factor para su contratación, ¿Cuál?(opcional) </h2>

<INPUT id="ndr13a" class="texto"  NAME="ndr13a" value=" {{$Encuesta->ndr13a}}" TYPE=TEXT SIZE="60" MAXLENGTH="60" >
      </td>
      <td>
<h2 class="reactivo">98.- ¿Cuándo encontró su primer trabajo relacionado con su campo profesional?  </h2>
<select class="select" id="ndr14" name="ndr14"  onchange="bloquear('ndr14',[1,3],[ndr15])">
   <option selected="selected" value="">
   <option value=1  @if($Encuesta->ndr14==1) selected @endif>Desde que estaba estudiando (Pase a la 100)</option>
   <option value=2  @if($Encuesta->ndr14==2) selected @endif>Después de egresar de la carrera </option>
   <option value=3  @if($Encuesta->ndr14==3) selected @endif>En el momento que terminó </option>
   <option value=0  hidden></option>   
</select>

      </td>
      <td></td>
</tr>

<tr>
<td colspan="2">
<h2 class="reactivo"> 99.- ¿Cuánto tiempo después  de  egresar  de  la licenciatura obtuvo su primer trabajo? {{$Encuesta->ndr15==1}}</h2>
<select class="select" id="ndr15" name="ndr15" >
<option selected="selected" value=0></option>
   <option value=1  @if($Encuesta->ndr15==1) selected @endif>6 meses o menos</option>
   <option value=2  @if($Encuesta->ndr15==2) selected @endif>de 6 meses a un año </option>
   <option value=3  @if($Encuesta->ndr15==3) selected @endif> más de un año</option>
   <option value=0  hidden></option>   
</select>

      </td>
<td colspan="2">
<h2 class="reactivo"> 100.- ¿Actualmente sigue laborando en el mismo trabajo?</h2>
<select class="select" id="ndr16" name="ndr16" >
<option selected="selected" value="">
   <option value=1  @if($Encuesta->ndr16==1) selected @endif>Sí</option>
   <option value=2  @if($Encuesta->ndr16==2) selected @endif>No</option>
   <option value=0  hidden></option>   
</select>

      </td>


</tr>
<tr>
<td colspan="2">
<h2 class="reactivo"> 101 a).- ¿Cuántos trabajos relacionados con su carrera ha tenido desde que egresó de la licenciatura? </h2>
<select class="select" id="ndr17" name="ndr17" >
<option selected="selected" value="">
   <option value=1  @if($Encuesta->ndr17==1) selected @endif>Uno</option>
   <option value=2  @if($Encuesta->ndr17==2) selected @endif>Dos </option>
   <option value=3  @if($Encuesta->ndr17==3) selected @endif>De tres a seis</option>
 <option value=4  @if($Encuesta->ndr17==4) selected @endif>Más de seis</option>
 <option value=5  @if($Encuesta->ndr17==5) selected @endif>Ninguno</option>
 <option value=0  hidden></option>   
</select>

     </td>
     <td colspan="2">
<h2 class="reactivo"> 101 b).- ¿Cuántos trabajos NO relacionados con su carrera ha tenido desde que egresó de la licenciatura? </h2>
<select class="select" id="ndr17a" name="ndr17a" >
<option selected="selected" value="">
   <option value=1  @if($Encuesta->ndr17a==1) selected @endif>Uno</option>
   <option value=2  @if($Encuesta->ndr17a==2) selected @endif>Dos </option>
   <option value=3  @if($Encuesta->ndr17a==3) selected @endif>De tres a seis</option>
 <option value=4  @if($Encuesta->ndr17a==4) selected @endif>Más de seis</option>
 <option value=5  @if($Encuesta->ndr17a==5) selected @endif>Ninguno</option>
 <option value=0  hidden></option>   
</select>

     </td>

</tr>
<tr><td colspan="4">
<h2 class="reactivo largo">Desde su inserción al campo laboral a la fecha, considera que su situación con respecto al:</h2>

     </td></tr>
<tr>

<td>
<h2 class="reactivo">102).- Puesto que ocupa    </h2>
<select class="select" id="ndr18" name="ndr18">
        <option selected="selected" value="">
<option value=1  @if($Encuesta->ndr18==1) selected @endif>Mejoró</option>
<option value=2  @if($Encuesta->ndr18==2) selected @endif>Es la misma</option>
<option value=3  @if($Encuesta->ndr18==3) selected @endif>Empeoró</option>
<option value=0  hidden></option>   
</select>

        </td>
<td>
<h2 class="reactivo">103).- Salario    </h2> 
<select class="select" id="ndr19" name="ndr19" >
        <option selected="selected" value="">
<option value=1  @if($Encuesta->ndr19==1) selected @endif>Mejoró</option>
<option value=2  @if($Encuesta->ndr19==2) selected @endif>Es la misma</option>
<option value=3  @if($Encuesta->ndr19==3) selected @endif>Empeoró</option>
<option value=0  hidden></option>   
</select>
</td> <td></td> <td></td>
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
  unhide('D');
  reactivos=document.getElementById("forma_sagrada").elements
  for (var i=0, item; item = reactivos[i]; i++) {
  // Look no need to do list[i] in the body of the loop
  console.log("'"+item.name+"' => 'required',");
}
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
function funcion_ndr2(){
 
  ndr2_val=document.getElementById('ndr2').value;
  console.log('func ndr2 '+ndr2_val);
  switch(ndr2_val){
    case '12': visibilizar(ndr2_a);[ndr3,ndr8,ndr4,ndr9,ndr5,ndr10,ndr6,ndr11,ndr7,ndr12,ndr12a,ndr12b,ndr12c,ndr13a].forEach(visibilizar);
    break;
    case '13':visibilizar(ndr2_a);[ndr3,ndr8,ndr4,ndr9,ndr5,ndr10,ndr6,ndr11,ndr7,ndr12,ndr12a,ndr12b,ndr12c,ndr13a].forEach(visibilizar);
    break;
    case '14': visibilizar(ndr2_a);[ndr3,ndr8,ndr4,ndr9,ndr5,ndr10,ndr6,ndr11,ndr7,ndr12,ndr12a,ndr12b,ndr12c,ndr13a].forEach(visibilizar);
    break;
    case '15': visibilizar(ndr2_a);[ndr3,ndr8,ndr4,ndr9,ndr5,ndr10,ndr6,ndr11,ndr7,ndr12,ndr12a,ndr12b,ndr12c,ndr13a].forEach(visibilizar);
    break;
    case '9': ocultar(ndr2_a);[ndr3,ndr8,ndr4,ndr9,ndr5,ndr10,ndr6,ndr11,ndr7,ndr12,ndr12a,ndr12b,ndr12c,ndr13a].forEach(ocultar);
    break;
    case '0': ocultar(ndr2_a);[ndr3,ndr8,ndr4,ndr9,ndr5,ndr10,ndr6,ndr11,ndr7,ndr12,ndr12a,ndr12b,ndr12c,ndr13a].forEach(ocultar);
    break;
    case '10': ocultar(ndr2_a);[ndr3,ndr8,ndr4,ndr9,ndr5,ndr10,ndr6,ndr11,ndr7,ndr12,ndr12a,ndr12b,ndr12c,ndr13a].forEach(ocultar);
    break;
    default: console.log('CASO DEFAULT');ocultar(ndr2_a);[ndr3,ndr8,ndr4,ndr9,ndr5,ndr10,ndr6,ndr11,ndr7,ndr12,ndr12a,ndr12b,ndr12c,ndr13a].forEach(visibilizar);
    break;
  }
}


bloquear('ndr1',[6,7,0],[ndr2,ndr3,ndr8,ndr4,ndr9,ndr5,ndr10,ndr6,ndr11,ndr7,ndr12,ndr12a,ndr12b,ndr12c,ndr13a,ndr14,ndr15,ndr16,ndr17,ndr18,ndr19]);
funcion_ndr2();
bloquear('ndr1',[6,7,0],[ndr2,ndr3,ndr8,ndr4,ndr9,ndr5,ndr10,ndr6,ndr11,ndr7,ndr12,ndr12a,ndr12b,ndr12c,ndr13a,ndr14,ndr15,ndr16,ndr17,ndr18,ndr19]);
@if($Encuesta->ncr1==6||$Encuesta->ncr1==8)
[ndr1,ndr2,ndr3,ndr8,ndr4,ndr9,ndr5,ndr10,ndr6,ndr11,ndr7,ndr12,ndr12a,ndr12b,ndr12c,ndr13a,ndr14,ndr15,ndr16,ndr17,ndr17a,ndr18,ndr19].forEach(ocultar);
@endif


bloquear('ndr1',[6,7,0],[ndr2,ndr3,ndr8,ndr4,ndr9,ndr5,ndr10,ndr6,ndr11,ndr7,ndr12,ndr12a,ndr12b,ndr12c,ndr13a,ndr14,ndr15,ndr16,ndr17,ndr18,ndr19]);
funcion_ndr2();
bloquear('ndr14',[0,1,3],[ndr15]);
@if($Encuesta->ncr1>2)
[ndr18,ndr19].forEach(ocultar);
@endif
var warning = false;
</script>

<script>
console.log('marcandooo rojo sec D ');
 @foreach ($errors->getMessages() as $key => $message)
                document.getElementsByName( "{{$key}}")[0].style="border: 0.3vw  solid red";
                console.log( "{{$key}}");
  @endforeach

</script>
@endpush