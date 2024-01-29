@extends('layouts.blank_app')

@section('content')
<h1 >COMPLETAR ENCUESTA   </h1>
<div  id='datos'>  @include('encuesta.personal_data') </div>
<div style="padding:1.2vw;">
<form action="{{ url('encuestas/2020/F_update/'. $Encuesta->registro) }}" method="POST" enctype="multipart/form-data" id='forma_sagrada' name='forma'>
@csrf
<table class="encuesta_table">
        <!-- primera fila  -->

        <tr>
        <td>
<h2 class="reactivo">
82.-La carrera que estudió: </h2>
<select class="select" id="nfr0"  name="nfr0"  onchange="bloquear('nfr0',[2],[nfr1])">
 <option selected="selected" value=""></option>
   <option value=1 @if($Encuesta->nfr0==1) selected @endif>La eligió </option>
  <option value=2 @if($Encuesta->nfr0==2) selected @endif>Se la asignaron (Pase a la 84)</option>
  </select>


      </td>
<td>
<h2 class="reactivo">
83. ¿Cuál  fue la razón más importante por la que usted eligió su carrera?</h2>
<select class="select" id="nfr1"  name="nfr1"  onchange=bloqueof(f)>
<option value="" selected="selected"></option>
<option value=1 @if($Encuesta->nfr1==1) selected @endif>El prestigio de la profesión</option>
<option value=2 @if($Encuesta->nfr1==2) selected @endif>Sus  habilidades  y  fortalezas   académicas</option>
<option value=3 @if($Encuesta->nfr1==3) selected @endif>Opinión de amistades y/o familiares</option>
<option value=4 @if($Encuesta->nfr1==4) selected @endif>Perspectivas de trabajo</option>
<option value=5 @if($Encuesta->nfr1==5) selected @endif>Perspectivas de ingresos altos</option>
<option value=6 @if($Encuesta->nfr1==6) selected @endif>Su género (sexo)</option>
<option value=7 @if($Encuesta->nfr1==7) selected @endif>Facilidad para ingresar a esa carrera</option>
<option value=8 @if($Encuesta->nfr1==8) selected @endif>El tipo de actividades profesionales</option>
<option value=9 @if($Encuesta->nfr1==9) selected @endif>Contribuir al desarrollo del país</option>
<option value=10 @if($Encuesta->nfr1==10) selected @endif>Contribuir al  desarrollo de la ciencia o cultura</option>
<option value=11 @if($Encuesta->nfr1==11) selected @endif>Otro</option>
  </select>

      </td>
<td>
<h2 class="reactivo">
<BR>84.- ¿Durante sus estudios de bachillerato  se le proporcionó orientación vocacional?</h2>
<select class="select" id="nfr2" name="nfr2" >
<option selected="selected" value="">
 <option value=1 @if($Encuesta->nfr2==1) selected @endif>Sí, y me fue útil</option>
 <option value=2 @if($Encuesta->nfr2==2) selected @endif>Sí, y me fue medio útil</option>
 <option value=3 @if($Encuesta->nfr2==3) selected @endif>Sí, pero no fue  útil</option>
<option value=4 @if($Encuesta->nfr2==4) selected @endif>No </option>
 </select>

     </td>
<td>
<h2 class="reactivo">
85.- Tomando en cuenta sus experiencias posteriores a la conclusión de la licenciatura
¿volvería   a elegir la misma carrera?</h2>
<select class="select" id="nfr3" name="nfr3"  onchange="bloquear('nfr3',[1],[nfr4])" >
<option selected="selected" value="">
  <option value=1 @if($Encuesta->nfr3==1) selected @endif>Sí (pase a la 86)</option>
  <option value=2 @if($Encuesta->nfr3==2) selected @endif>No, una relacionada</option>
  <option value=3 @if($Encuesta->nfr3==3) selected @endif>No, una totalmente diferente</option>
   </select>
<br>

    </td>
</tr>
<tr>
<td>
<h2 class="reactivo">86.- ¿Volvería a estudiar en la UNAM?</h2>
    <select class="select" id="nfr5" name="nfr5"  onchange="bloquear('nfr5',[1],[nfr5_a])">
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->nfr5==1) selected @endif>Sí (pasa a la 87)</option>
    <option value=2 @if($Encuesta->nfr5==2) selected @endif>No</option>
   </select> 
   
       </td>
<td>
<h2 class="reactivo"><br> <br>
   86a).- ¿Por qué?
  <br> <br></h2>
<INPUT  name="nfr5_a" id="nfr5_a" style="width:50%"  maxlength="35" type="text" class="texto">

      </td>
<td>
<h2 class="reactivo"> 
 87).- ¿Recomendaría su escuela o facultad?</h2>
   <select class="select" id="nfr6" name="nfr6"  onchange="bloquear('nfr6',[1],[nfr6_a])">
     <option value="" selected="selected"></option>
     <option value=1 @if($Encuesta->nfr6==1) selected @endif>Sí (pasa a la 88)</option>
     <option value=2 @if($Encuesta->nfr6==2) selected @endif>No</option>
    </select>

        </td>
<td>
<h2 class="reactivo"><br> <br>
87a).- ¿Por qué? 
<br> <br></h2>
<INPUT id="nfr6_a" class="texto" Type='text' name="nfr6_a"  maxlength='35' style="width:50%" >

      </td>
</tr>
<tr>
<td>
<h2 class="reactivo">
88).-¿En qué porcentaje los programas de las asignaturas que curs&oacute estaban actualizados?</h2>
<select class="select" id="Pregunta 88"  name="nfr7" >
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->nfr7==1) selected @endif>100%</option>
  <option value=2 @if($Encuesta->nfr7==2) selected @endif>75%</option>
  <option value=3 @if($Encuesta->nfr7==3) selected @endif>50%</option>
  <option value=4 @if($Encuesta->nfr7==4) selected @endif>25%</option>
  <option value=5 @if($Encuesta->nfr7==5) selected @endif>0%</option>
  </select></TD>
  
  
      </td>
<td>
<h2 class="reactivo">
89.-¿El plan de estudios que cursó debería?</h2>
<select class="select" id="nfr8" name="nfr8" >
<option value="" selected="selected"></option>
   <option value=1 @if($Encuesta->nfr8==1) selected @endif>Permanecer igual</option>
  <option value=2 @if($Encuesta->nfr8==2) selected @endif>Modificarse</option>
  <option value=3 @if($Encuesta->nfr8==3) selected @endif>Reestructurarse completamente</option>
  </select> </TD>

      </td>
<td>
<h2 class="reactivo"> 
90.- ¿Considera qué su formación teórica  fue adecuada?</h2>
<select class="select" id="Pregunta 90" name="nfr9" >
  <option selected="selected" value="">
  <option value=1 @if($Encuesta->nfr9==1) selected @endif>Totalmente de acuerdo</option>
  <option value=2 @if($Encuesta->nfr9==2) selected @endif>De acuerdo</option>
  <option value=3 @if($Encuesta->nfr9==3) selected @endif>Medianamente de acuerdo</option>
  <option value=4 @if($Encuesta->nfr9==4) selected @endif>En desacuerdo</option>
  <option value=5 @if($Encuesta->nfr9==5) selected @endif>Totalmente en desacuerdo</option>
</select>

    </td>
<td>
<h2 class="reactivo">
91.- ¿Considera qué  su   formación   práctica   fue adecuada?</h2>
<select class="select" id="Pregunta 91" name="nfr10" >
     <option selected="selected" value="">
 <option value=1 @if($Encuesta->nfr10==1) selected @endif>Totalmente de acuerdo</option>
  <option value=2 @if($Encuesta->nfr10==2) selected @endif>De acuerdo</option>
  <option value=3 @if($Encuesta->nfr10==3) selected @endif>Medianamente de acuerdo</option>
  <option value=4 @if($Encuesta->nfr10==4) selected @endif>En desacuerdo</option>
  <option value=5 @if($Encuesta->nfr10==5) selected @endif>Totalmente en desacuerdo</option>
</select>

    </td>
</tr>
<tr>
<td>
<h2 class="reactivo">
92.- ¿Considera qué faltaron temas importantes en el plan de estudios que usted cursó?  </h2>
<select class="select" id="nfr11" name="nfr11"  onchange="bloquear('nfr11',[2],[nfr11a])">
 <option value="" selected="selected"></option>
 <option value=1 @if($Encuesta->nfr11==1) selected @endif>Sí</option>
 <option value=2 @if($Encuesta->nfr11==2) selected @endif>No (Pasar a 93)</option>
 </select>


     </td>
<td>
<h2 class="reactivo">
92a).- ¿Cúales?</h2>
<INPUT type="text" class="texto" id="nfr11a" name="nfr11a" maxlength="75" value="{{$Encuesta->nfr11a}}">

      </td>
<td>
<h2 class="reactivo"> 
93.- ¿Con qué calidad se impartía la enseñanza?</h2>
<select class="select" id="Pregunta 93" name="nfr12" >
<option selected="selected" value="">
 <option value=1 @if($Encuesta->nfr12==1) selected @endif>Excelente</option>
  <option value=2 @if($Encuesta->nfr12==2) selected @endif>Buena</option>
  <option value=3 @if($Encuesta->nfr12==3) selected @endif>Regular</option>
  <option value=4 @if($Encuesta->nfr12==4) selected @endif>Mala</option>
  <option value=5 @if($Encuesta->nfr12==5) selected @endif>Deficiente</option>
 </select>


     </td>
<td>
<h2 class="reactivo">
94.-¿Con qué frecuencia interactuó con sus profesores  dentro  del aula? </h2>

<select class="select" id="nfr13" name="nfr13" >
<option selected="selected" value="">
 <option value=1 @if($Encuesta->nfr13==1) selected @endif>Muy frecuentemente</option>
 <option value=2 @if($Encuesta->nfr13==2) selected @endif>Frecuentemente</option>
 <option value=3 @if($Encuesta->nfr13==3) selected @endif>Esporádicamente</option>
 <option value=4 @if($Encuesta->nfr13==4) selected @endif>Casi nunca</option>
 <option value=5 @if($Encuesta->nfr13==5) selected @endif>Nunca</option>
 </select>


    </td>
</tr>

<tr>
<td>
<h2 class="reactivo">
95.-¿Con qué frecuencia interactuó con sus profesores  fuera del aula?</h2>
<select class="select" id="Pregunta 95" name="nfr22" >
 <option selected="selected" value="">
 <option value=1 @if($Encuesta->nfr8==1) selected @endif>Muy frecuentemente</option>
 <option value=2 @if($Encuesta->nfr8==2) selected @endif>Frecuentemente</option>
 <option value=3 @if($Encuesta->nfr8==3) selected @endif>Esporádicamente</option>
 <option value=4 @if($Encuesta->nfr8==4) selected @endif>Casi nunca</option>
 <option value=5 @if($Encuesta->nfr8==5) selected @endif>Nunca</option>
 </select>

     </td>
<td>
<h2 class="reactivo">
96.- ¿Durante sus estudios profesionales recibió o percibió que 
otros estudiantes recibieran algún tipo de 
discriminación?
</h2>
<select class="select" id="nfr23a" name="nfr23a"   onchange="bloquear('nfr23a',[2],[nfr23,nfr24])">
<option selected="selected" value="">
 <option value=1 @if($Encuesta->nfr23==1) selected @endif>Sí (Especifíque)</option>
 <option value=2 @if($Encuesta->nfr23==2) selected @endif>No (Pase a la 98)</option>
  </select>
    </TD>

  <TD colspan="2"> 
  <h2 class="reactivo"> 
97.-Especifíque:----  </h2>
@foreach($Discriminacion as $d)
<input type="checkbox" id="scales" name="scales" checked />
    <label for="scales">Scales</label>
  </div>
  <br>
@endforeach
    <h2 class="reactivo"> 
97a) Otra-</h2>
<INPUT id="nfr24" name="nfr24" TYPE=TEXT  class="texto"  MAXLENGTH=80 value="{{$Encuesta->nfr24}}" >
</TD>
</tr>

<tr>
<TD > <h2 class="reactivo"> 
98.- ¿Cómo considera que fue la carga de trabajo durante sus estudios profesionales?
 (exámenes, tareas, proyectos,etc) </h2>
    
<select class="select" id="Pregunta 98" name="nfr25" > 
  <option selected="selected" value="">
  <option value=1 @if($Encuesta->nfr25==1) selected @endif>Muy alta</option>
  <option value=2 @if($Encuesta->nfr25==2) selected @endif>Alta</option>
  <option value=3 @if($Encuesta->nfr25==3) selected @endif>Media</option>
  <option value=4 @if($Encuesta->nfr25==4) selected @endif>Baja</option>
  <option value=5 @if($Encuesta->nfr25==5) selected @endif>Muy baja o nula</option>

  </select>
   </TD>

<TD > <h2 class="reactivo"> 
99.- ¿Cómo  fue  su  desempeño  como  estudiante durante sus estudios profesionales? </h2>
    
 <select class="select" id="Pregunta 99"  name="nfr26" >
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->nfr26==1) selected @endif>Excelente</option>
    <option value=2 @if($Encuesta->nfr26==2) selected @endif>Bueno</option>
    <option value=3 @if($Encuesta->nfr26==3) selected @endif>Regular</option>
    <option value=4 @if($Encuesta->nfr26==4) selected @endif>Malo</option>
    <option value=5 @if($Encuesta->nfr26==5) selected @endif>Deficiente</option>
   </select>
    </TD>

  <TD>  <h2 class="reactivo"> 
100.- ¿Ya se tituló? </h2>
   
   <select class="select" id="nfr27"  name="nfr27"  onchange="titulado()" >
     <option value="" selected="selected"></option>
     <option value=1 @if($Encuesta->nfr27==1) selected @endif>Sí</option>
     <option value=2 @if($Encuesta->nfr27==2) selected @endif>No</option>
     <OPTION VALUE=3 @if($Encuesta->nfr27==3) selected @endif>No, estoy en trámite</OPTION>
    </select>
    
      </td>
      <td>
      <h2 class="reactivo"> 101.- ¿Cuánto tiempo después de egresar se tituló? </h2>

<select class="select" id="nfr28" name="nfr28" @if($Encuesta->nfr27!=1) hidden value=0 @else value={{$Encuesta->nfr28}} @endif>Sí>
<option value="" selected="selected"></option>
  <option value=1 @if($Encuesta->nfr28==1) selected @endif>Durante el primer año después de egresar</option>
  <option value=2 @if($Encuesta->nfr28==2) selected @endif>Dos años después de egresar</option>
  <option value=3 @if($Encuesta->nfr28==3) selected @endif>Tres años o más después de egresar</option>
  <option value=0 @if($Encuesta->nfr27!=1)selected  @endif hidden></option>  

</select>
</td>
</tr>

<tr>
<td>
<h2 class="reactivo">
102.- ¿Cuál es el motivo más importante por el que no se ha titulado? </h2>
     <select class="select" id="nfr29"  name="nfr29"  onchange="bloquear('nfr29',[1,2,3,4,5,6,7,8,10,11,12,13,14,15,16],[nfr29a])">
<option value="" selected="selected"></option>
   <option value=1 @if($Encuesta->nfr29==1) selected @endif>Trámites  engorrosos y difíciles</option>
  <option value=2 @if($Encuesta->nfr29==2) selected @endif>No he tenido tiempo por estar trabajando</option>
  <option value=3 @if($Encuesta->nfr29==3) selected @endif>No he tenido tiempo por obligaciones familiares</option>
  <option value=4 @if($Encuesta->nfr29==4) selected @endif>No he podido concluir la tesis</option>
  <option value=5 @if($Encuesta->nfr29==5) selected @endif>No he hecho la tesis</option>
  <option value=6 @if($Encuesta->nfr29==6) selected @endif>No me interesa hacerlo</option>
  <option value=7 @if($Encuesta->nfr29==7) selected @endif>No, por estar estudiando</option>
  <option value=10 @if($Encuesta->nfr29==10) selected @endif>No acreditar el o los idiomas</option>
  <option value=11 @if($Encuesta->nfr29==11) selected @endif>Economicas</option>
  <option value=12 @if($Encuesta->nfr29==12) selected @endif>Esperar la convocatoria para diplomados o examen de conocimientos</option>
  <option value=13 @if($Encuesta->nfr29==13) selected @endif>Problemas con el asesor</option>
  <option value=14 @if($Encuesta->nfr29==14) selected @endif>No ha realizado el servicio social</option>
  <option value=15 @if($Encuesta->nfr29==15) selected @endif>Cursando el diplomado o alguna otra modalidad de titulación</option>
  <option value=16 @if($Encuesta->nfr29==16) selected @endif>Motivos de salud</option>
  <option value=8 @if($Encuesta->nfr29==8) selected @endif>No deseo contestar</option>
  <option value=9 @if($Encuesta->nfr29==9) selected @endif>Otra (especifíque)</option>
  </select> 
      </td>
<td>
<h2 class="reactivo">
102a).- Otra (especifíque):</h2>
<INPUT  id="nfr29a" name="nfr29a" TYPE=TEXT  class="texto" MAXLENGTH=47 > 

      </td>
<td>
<h2 class="reactivo">
103.- ¿Ya realizó el servicio social?</h2>
 <select class="select" id="nfr30" name="nfr30"  onchange="bloquear('nfr30',[2],[nfr31,nfr32])">
  <option selected="selected" value="">
  <option value=1 @if($Encuesta->nfr30==1) selected @endif>Sí</option>
  <option value=2 @if($Encuesta->nfr30==2) selected @endif>No</option>
</select>

    </td>
<td> </td>

</tr>
<tr>
  <td colspan="2">
  <h2 class="reactivo">
104.- ¿En  qué  grado  estaban  relacionadas  con  su carrera las actividades que llevó a cabo durante el 
servicio social? </h2>
<select class="select" id="Pregunta 104" name="nfr31" >
     <option selected="selected" value="">
 <option value=1 @if($Encuesta->nfr31==1) selected @endif>Muy relacionadas</option>
  <option value=2 @if($Encuesta->nfr31==2) selected @endif>Relacionadas</option>
  <option value=3 @if($Encuesta->nfr31==3) selected @endif>Medianamente relacionadas</option>
  <option value=4 @if($Encuesta->nfr31==4) selected @endif>Poco relacionadas</option>
  <option value=5 @if($Encuesta->nfr31==5) selected @endif>Nada relacionadas</option>
</select>

  </td>
<td>
<h2 class="reactivo">
105.- ¿Las funciones qué realizó en su servicio social, se traducían en beneficios para la sociedad?  </h2>
<select class="select" id="Pregunta 105" name="nfr32" >
 <option selected="selected" value="">
 <option value=1 @if($Encuesta->nfr32==1) selected @endif>Sí</option>
 <option value=2 @if($Encuesta->nfr32==2) selected @endif>No</option>
</select></TD>

     </td>
<td>
<h2 class="reactivo"> 
106.- ¿En qué medida está satisfecho con su formación profesional?  </h2>
<select class="select" id="Pregunta 106" name="nfr33" >
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->nfr33==1) selected @endif>Muy satisfecho(a)</option>
    <option value=2 @if($Encuesta->nfr33==2) selected @endif>Satisfecho(a)</option>
    <option value=3 @if($Encuesta->nfr33==3) selected @endif>Medianamente satisfecho(a)</option>
    <option value=4 @if($Encuesta->nfr33==4) selected @endif>Poco satisfecho(a)</option>
    <option value=5 @if($Encuesta->nfr33==5) selected @endif>Nada satisfecho(a)</option>
 </select>
 </td>
</tr>
</table>
<button class="btn fixed" name='boton1'  value=0 type="summit" onclick="post_data()" style="background-color:{{Auth::user()->color}} ; color:white; display: flex;">
<i class="fas fa-arrow-right"></i> &nbsp; Siguiente
  </button>
  </form>
</div>

@endsection


@push('js')

  
<script>
  unhide('F');
//   reactivos=document.getElementById("forma_sagrada").elements
//   for (var i=0, item; item = reactivos[i]; i++) {
//   // Look no need to do list[i] in the body of the loop
//   console.log("'"+item.name+"' => 'required',");
// }
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

</script>
@endpush