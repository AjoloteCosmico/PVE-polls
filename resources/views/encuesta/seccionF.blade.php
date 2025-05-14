@extends('layouts.blank_app')

@section('content')
<h1 >COMPLETAR ENCUESTA   </h1>
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
<form action="{{ url('encuestas/2020/F_update/'. $Encuesta->registro) }}" method="POST" enctype="multipart/form-data" id='forma_sagrada' name='forma'>
@csrf
<table class="encuesta_table">
        <!-- primera fila  -->

        <tr>
        <td>
<h2 class="reactivo">
35.-La carrera que estudió: </h2>
<select class="select" id="nfr0"  name="nfr0"  onchange="bloquear('nfr0',[2],[nfr1,nfr1a_label,nfr1a]);">
 <option selected="selected" value=""></option>
   <option value=1 @if($Encuesta->nfr0==1) selected @endif>La eligió </option>
  <option value=2 @if($Encuesta->nfr0==2) selected @endif>Se la asignaron (Pase a la 37)</option>
  </select>
      </td>
<td>
<h2 class="reactivo">
36. ¿Cuál fue la razón más importante por la que usted eligió su carrera?</h2>
<select class="select" id="nfr1"  name="nfr1"  onchange="bloquear('nfr1',[1,2,3,4,5,6,7,8,9,10,12],[nfr1a_label,nfr1a])">
<option value=" " selected="selected"></option>
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
<option value=12 @if($Encuesta->nfr1==12) selected @endif>Plan de Estudios</option>
<option value=11 @if($Encuesta->nfr1==11) selected @endif>Otro</option>
<option value=0 ></option>
  </select>
  <p id='nfr1a_label'>Otra:</p><input type="text" class="texto"   id="nfr1a" name="nfr1a"  maxlength="50"  value="{{$Encuesta->nfr1a}}"> 
      </td>
<td>
<h2 class="reactivo">
<BR>37.- ¿Durante sus estudios de bachillerato  se le proporcionó orientación vocacional?</h2>
<select class="select" id="nfr2" name="nfr2" >
<option selected="selected" value="">
 <option value=1 @if($Encuesta->nfr2==1) selected @endif>Sí, y me fue útil</option>
 <option value=2 @if($Encuesta->nfr2==2) selected @endif>Sí, y me fue medio útil</option>
 <option value=3 @if($Encuesta->nfr2==3) selected @endif>Sí, pero no fue  útil</option>
<option value=4 @if($Encuesta->nfr2==4) selected @endif>No </option>
 </select>
     </td>
     <td></td>
  </tr>
  <tr>
<td>
<h2 class="reactivo">
38.- Tomando en cuenta sus experiencias posteriores a la conclusión de la licenciatura ¿volvería a elegir la misma?</h2>
<select class="select" id="nfr3" name="nfr3"  onchange="bloquear('nfr3',[1],[nfr4])" >
<option selected="selected" value="">
  <option value=1 @if($Encuesta->nfr3==1) selected @endif>Sí (pase a la 40)</option>
  <option value=2 @if($Encuesta->nfr3==2) selected @endif>No, una relacionada</option>
  <option value=3 @if($Encuesta->nfr3==3) selected @endif>No, una totalmente diferente</option>
   </select>
<br>
</td><td>
<h2 class="reactivo">
39a).- ¿Por qué no la elegiría? </h2>
  <select class="select" id="nfr4"  name="nfr4" onchange="bloquear('nfr4',[1,2,3,4,5,6,0],[nfr4_a])"> 
  <option selected="selected" value="">
  <option value=1 @if($Encuesta->nfr4==1) selected @endif>Esta carrera no fue mi primera opción</option>
  <option value=2 @if($Encuesta->nfr4==2) selected @endif>No ha podido encontrar trabajo en este campo</option>
  <option value=3 @if($Encuesta->nfr4==3) selected @endif>No está satisfecho(a) con su trabajo</option>
  <option value=4 @if($Encuesta->nfr4==4) selected @endif>No está satisfecho(a) con el salario que percibe en su  actual trabajo</option>
  <option value=5 @if($Encuesta->nfr4==5) selected @endif>Un cambio en sus intereses</option>
  <option value=6 @if($Encuesta->nfr4==6) selected @endif>En la carrera no adquirió las habilidades prácticas  necesarias para el trabajo</option>
  <option value=7 @if($Encuesta->nfr4==7) selected @endif>Otra</option>
  <option value=0 @if($Encuesta->nfr4==0)selected  @endif hidden></option>  
</select>
  
    </td>
    <td>
      Otra (Especifíque):
        <INPUT id="nfr4_a" name="nfr4_a" TYPE=TEXT  class="texto"  MAXLENGTH=80 value="{{$Encuesta->nfr4_a}}" >

    </td>
    <td></td>
</tr>
<tr>
<td>
<h2 class="reactivo">40.- ¿Volvería a estudiar en la UNAM?</h2>
    <select class="select" id="nfr5" name="nfr5"  onchange="bloquear('nfr5',[1],[nfr5_a])">
    <option selected="selected" value="">
    <option value=1 @if($Encuesta->nfr5==1) selected @endif>Sí (pasa a la 87)</option>
    <option value=2 @if($Encuesta->nfr5==2) selected @endif>No</option>
   </select> 
   
       </td>
<td>
<h2 class="reactivo"><br> <br>
  40a).- ¿Por qué?
  <br> <br></h2>
<INPUT  name="nfr5_a" id="nfr5_a" style="width:50%" value="{{str_replace('0','',$Encuesta->nfr5_a )}}"  maxlength="99" type="text" class="texto">

      </td>
<td>
<h2 class="reactivo"> 
 41).- ¿Recomendaría su escuela o facultad?</h2>
   <select class="select" id="nfr6" name="nfr6"  onchange="bloquear('nfr6',[1],[nfr6_a])">
     <option value="" selected="selected"></option>
     <option value=1 @if($Encuesta->nfr6==1) selected @endif>Sí (pasa a la 88)</option>
     <option value=2 @if($Encuesta->nfr6==2) selected @endif>No</option>
    </select>

        </td>
<td>
<h2 class="reactivo"><br> <br>
41a).- ¿Por qué? 
<br> <br></h2>
<INPUT id="nfr6_a" class="texto" Type='text' name="nfr6_a" value="{{str_replace('0','',$Encuesta->nfr6_a )}}" maxlength='99' style="width:50%" >

      </td>
</tr>
<tr>
<td>
<h2 class="reactivo">
42).-¿En qué porcentaje el programa de las asignaturas que cursó estaba actualizado?</h2>
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
43.-¿El plan de estudios que cursó debería?</h2>
<select class="select" id="nfr8" name="nfr8" >
<option value="" selected="selected"></option>
   <option value=1 @if($Encuesta->nfr8==1) selected @endif>Permanecer igual</option>
  <option value=2 @if($Encuesta->nfr8==2) selected @endif>Modificarse</option>
  <option value=3 @if($Encuesta->nfr8==3) selected @endif>Reestructurarse completamente</option>
  </select> </TD>

      </td>
<td>
<h2 class="reactivo"> 
44.- ¿Considera que su formación teórica  fue adecuada?</h2>
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
45.- ¿Considera que  su   formación   práctica   fue adecuada?</h2>
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
46.- ¿Considera que faltaron temas importantes en el plan de estudios que usted cursó?  </h2>
<select class="select" id="nfr11" name="nfr11"  onchange="bloquear('nfr11',[2],[nfr11a])">
 <option value="" selected="selected"></option>
 <option value=1 @if($Encuesta->nfr11==1) selected @endif>Sí</option>
 <option value=2 @if($Encuesta->nfr11==2) selected @endif>No (Pasar a 93)</option>
 </select>


     </td>
<td>
<h2 class="reactivo">
46a).- ¿Cuáles?</h2>
<textarea  class="texto" id="nfr11a" name="nfr11a" MAXLENGTH=200 rows="4"  >{{$Encuesta->nfr11a}} </textarea>

      </td>
<td>
<h2 class="reactivo"> 
47.- En su opinión, en términos generales ¿Con qué calidad se impartía la enseñanza?</h2>
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
48.-¿Con qué frecuencia interactuó con sus profesores  dentro  del aula? </h2>

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
49.-¿Con qué frecuencia interactuó con sus profesores  fuera del aula?</h2>
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
50.- ¿Durante sus estudios profesionales recibió o percibió que otro estudiante recibiera algún tipo de discriminación?
</h2>
<select class="select" id="nfr23a" name="nfr23a"   onchange="bloquear('nfr23a',[2],[nfr23,nfr24])">
<option selected="selected" value="">
 <option value=1 @if($Discriminacion->count()>0) selected @endif>Sí (Especifíque)</option>
 <option value=2 @if($Discriminacion->count()==0) selected @endif>No (Pase a la 52)</option>
  </select>
    </TD>
  <TD colspan="2"> 
  <h2 class="reactivo"> 
51.-Especifíque:  </h2>
<div id="nfr23">
@foreach($nfr23_options  as $o)
<input type="checkbox" name="opcion{{$o->clave}}" @if($Discriminacion->where('clave_opcion','=',$o->clave)->count()>0) checked @endif/>
    <label for="scales">{{$o->descripcion}}</label>
  
  <br>
@endforeach</div>
    <h2 class="reactivo"> 
51a) Otra (opcional):</h2>
<INPUT id="nfr24" name="nfr24" TYPE=TEXT  class="texto"  MAXLENGTH=80 value="{{$Encuesta->nfr24}}" >
</TD>
</tr>

<tr>
<TD > <h2 class="reactivo"> 
52.- ¿Cómo considera que fue la carga de trabajo durante sus estudios profesionales?
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
53.- ¿Cómo  fue  su  desempeño  como  estudiante durante sus estudios profesionales? </h2>
    
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
54.- ¿Ya se tituló? </h2>
   
   <select class="select" id="nfr27"  name="nfr27"  onchange="titulado()" >
     <option value="" selected="selected"></option>
     <option value=1 @if($Encuesta->nfr27==1) selected @endif>Sí</option>
     <option value=2 @if($Encuesta->nfr27==2) selected @endif>No</option>
     <OPTION VALUE=3 @if($Encuesta->nfr27==3) selected @endif>No, estoy en trámite</OPTION>
    </select>
    
      </td>
      <td>
      <h2 class="reactivo"> 55.- ¿Cuánto tiempo después de egresar se tituló? </h2>

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
56.- ¿Cuál es el motivo más importante por el que no se ha titulado? </h2>
     <select class="select" id="nfr29"  name="nfr29"  onchange="bloquear('nfr29',[1,2,3,4,5,6,7,8,10,11,12,13,14,15,16,17,18,19,20,21],[nfr29a])">
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
  <option value=17 @if($Encuesta->nfr29==17) selected @endif>Cambio de residencia</option>
  <option value=18 @if($Encuesta->nfr29==18) selected @endif>Errores en los trámites</option>
  <option value=19 @if($Encuesta->nfr29==19) selected @endif>Desconozco las opciones de titulación</option>
  <option value=20 @if($Encuesta->nfr29==20) selected @endif>Pocas opciones de titulación</option>
  <option value=21 @if($Encuesta->nfr29==21) selected @endif>Problemas administrativos  </option>
  <option value=8 @if($Encuesta->nfr29==8) selected @endif>No deseo contestar</option>
  <option value=9 @if($Encuesta->nfr29==9) selected @endif>Otra (especifíque)</option>
  <option value=0 ></option>
    
</select> 
      </td>
<td>
<h2 class="reactivo">
56a).- Otra (especifíque):</h2>
<INPUT  id="nfr29a" name="nfr29a" TYPE=TEXT  class="texto" MAXLENGTH=47 value="{{str_replace('0','',$Encuesta->nfr29a)}}"> 

      </td>
<td>
<h2 class="reactivo">
57.- ¿Ya realizó el servicio social?</h2>
 <select class="select" id="nfr30" name="nfr30"  onchange="bloquear('nfr30',[2,4],[nfr31,nfr32])">
  <option selected="selected" value="">
  <option value=1 @if($Encuesta->nfr30==1) selected @endif>Sí</option>
  <option value=2 @if($Encuesta->nfr30==2) selected @endif>No</option>
  
  <option value=3 @if($Encuesta->nfr30==3) selected @endif>Articulo 91</option>
  
  <option value=4 @if($Encuesta->nfr30==4) selected @endif>Articulo 52</option>
</select>

    </td>
<td> </td>

</tr>
<tr>
  <td colspan="2">
  <h2 class="reactivo">
58.- ¿En qué grado estaban relacionadas con su carrera las actividades que realizó durante el servicio social? </h2>
<select class="select" id="nfr31" name="nfr31" >
     <option selected="selected" value="">
 <option value=1 @if($Encuesta->nfr31==1) selected @endif>Muy relacionadas</option>
  <option value=2 @if($Encuesta->nfr31==2) selected @endif>Relacionadas</option>
  <option value=3 @if($Encuesta->nfr31==3) selected @endif>Medianamente relacionadas</option>
  <option value=4 @if($Encuesta->nfr31==4) selected @endif>Poco relacionadas</option>
  <option value=5 @if($Encuesta->nfr31==5) selected @endif>Nada relacionadas</option>
  <option value=0>
</select>

  </td>
<td>
<h2 class="reactivo">
59.- Las funciones qué realizó en su servicio social, ¿Se traducían en beneficios para la sociedad?  </h2>
<select class="select" id="nfr32" name="nfr32" >
 <option selected="selected" value="">
 <option value=1 @if($Encuesta->nfr32==1) selected @endif>Sí</option>
 <option value=2 @if($Encuesta->nfr32==2) selected @endif>No</option>
 <option value=0>
</select></TD>

     </td>
<td>
<h2 class="reactivo"> 
60.- ¿En qué medida está satisfecho con su formación profesional?  </h2>
<select class="select" id="nfr33" name="nfr33" >
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
<i class="fas fa-save"></i> &nbsp; GUARDAR <br> SECCION
  </button>
  </form>
</div>

@endsection


@push('js')

  
<script>
  unhide('F');

</script>
<script>
  console.log('marcandooo rojo');
 @foreach ($errors->all() as $error)
                document.getElementById( "{{str_replace(' ', '_',str_replace('The ','',str_replace(' field is required.', '', $error))) }}").style="border: 0.3vw  solid red";
                console.log( "{{str_replace(' ', '_',str_replace('The ','',str_replace(' field is required.', '', $error))) }}");
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
function titulado(){
  bloquear('nfr27',[2,3],[nfr28]);
  bloquear('nfr27',[1],[nfr29,nfr29a]);
 
}


titulado();
bloquear('nfr0',[2],[nfr1,nfr1a_label,nfr1a]);
bloquear('nfr3',[1],[nfr4]);
bloquear('nfr4',[1,2,3,4,5,6,0],[nfr4_a]);
bloquear('nfr5',[1],[nfr5_a])
bloquear('nfr6',[1],[nfr6_a])
bloquear('nfr11',[2],[nfr11a]);
bloquear('nfr23a',[2],[nfr23,nfr24]); 
bloquear('nfr0',[2],[nfr1,nfr1a_label,nfr1a]);
bloquear('nfr29',[0,1,2,3,4,5,6,7,8,10,11,12,13,14,15,16,17,18,19,20.21],[nfr29a]);
bloquear('nfr30',[2],[nfr31,nfr32]);
bloquear('nfr1',[1,2,3,4,5,6,7,8,9,10,12,0],[nfr1a_label,nfr1a]);
var warning = false;
</script>
@endpush