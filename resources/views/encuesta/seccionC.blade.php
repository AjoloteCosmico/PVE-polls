@extends('layouts.blank_app')
@section('content')
<h1 > COMPLETAR ENCUESTA </h1>
<div  id='datos'>  @include('encuesta.personal_data') </div>
<div style="padding:1.2vw;">
   <form action="{{ url('encuestas/2020/C_update/'. $Encuesta->registro) }}" method="POST" enctype="multipart/form-data" id='forma_sagrada' name='forma'>
      @csrf
      <table class="encuesta_table">
         <!-- primera fila  -->
         <tr>
            <td>
               <h2 class="reactivo">61.- ¿Actualmente está trabajando? </h2>
               <select class="select" id="ncr1" name="ncr1"  onchange='seccionc2()'>
                  <option selected  value="">Seleccione...</option>
                  <option value=1 @if($Encuesta->ncr1==1) selected @endif>Sí (permanente)</option>
                  <option value=2 @if($Encuesta->ncr1==2) selected @endif>Sí (eventual)</option>
                  <option value=3 @if($Encuesta->ncr1==3) selected @endif>No (Sin buscar trabajo), (pase a la 83)</option>
                  <option value=4 @if($Encuesta->ncr1==4) selected @endif>No (En búsqueda de trabajo), (pase a la 83)</option>
                  <option value=5 @if($Encuesta->ncr1==5) selected @endif>Residente (Médico) (conteste  la 62)</option>
                  <option value=6 @if($Encuesta->ncr1==6) selected @endif>Nunca ha trabajado, sin buscar (pase a la 83 )</option>
                  <option value=8 @if($Encuesta->ncr1==8) selected @endif>Nunca ha trabajado, buscando (pase a la 83 )</option>
                  <option value=7 @if($Encuesta->ncr1==7) selected @endif>Becario</option>
               </select>
            </td>
            <td colspan="2">
               <h2 class="reactivo"> 62.- Nombre de la empresa o institución donde trabaja </h2>
               <textarea class="texto" id="ncr2" name="ncr2" cols="30" rows="2" maxlength="220"> {{$Encuesta->ncr2}}</textarea>
            </td>
            <td>
               <h2 class="reactivo"> 63.-¿Cuál es el estado dónde usted se encuentra laborando? </h2>
               <select class="select" id="ncr2a"  name="ncr2a" onchange="bloquear('ncr2a',[0,1,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33],[ncr2ext])">
                  <option selected  value=""></option>
                  <option value=1 @if($Encuesta->ncr2a==1) selected @endif>CDMX</option>
                  <option value=2 @if($Encuesta->ncr2a==2) selected @endif>EXTRANJERO</option>
                  <option value=3 @if($Encuesta->ncr2a==3) selected @endif>Aguascalientes</option>
                  <option value=4 @if($Encuesta->ncr2a==4) selected @endif>Baja California</option>
                  <option value=5 @if($Encuesta->ncr2a==5) selected @endif>Baja California Sur</option>
                  <option value=6 @if($Encuesta->ncr2a==6) selected @endif>Campeche</option>
                  <option value=7 @if($Encuesta->ncr2a==7) selected @endif>Chiapas</option>
                  <option value=8 @if($Encuesta->ncr2a==8) selected @endif>Chihuahua</option>
                  <option value=9 @if($Encuesta->ncr2a==9) selected @endif>Coahuila</option>
                  <option value=10 @if($Encuesta->ncr2a==10) selected @endif>Colima</option>
                  <option value=11 @if($Encuesta->ncr2a==11) selected @endif>Durango</option>
                  <option value=12 @if($Encuesta->ncr2a==12) selected @endif>Guanajuato</option>
                  <option value=13 @if($Encuesta->ncr2a==13) selected @endif>Guerrero</option>
                  <option value=14 @if($Encuesta->ncr2a==14) selected @endif>Hidalgo</option>
                  <option value=15 @if($Encuesta->ncr2a==15) selected @endif>Jalisco</option>
                  <option value=16 @if($Encuesta->ncr2a==16) selected @endif>Estado de México</option>
                  <option value=17 @if($Encuesta->ncr2a==17) selected @endif>Michoacán</option>
                  <option value=18 @if($Encuesta->ncr2a==18) selected @endif>Morelos</option>
                  <option value=19 @if($Encuesta->ncr2a==19) selected @endif>Nayarit</option>
                  <option value=20 @if($Encuesta->ncr2a==20) selected @endif>Nuevo León</option>
                  <option value=21 @if($Encuesta->ncr2a==21) selected @endif>Oaxaca</option>
                  <option value=22 @if($Encuesta->ncr2a==22) selected @endif>Puebla</option>
                  <option value=23 @if($Encuesta->ncr2a==23) selected @endif>Querétaro</option>
                  <option value=24 @if($Encuesta->ncr2a==24) selected @endif>Quintana Roo</option>
                  <option value=25 @if($Encuesta->ncr2a==25) selected @endif>San Luis Potosí</option>
                  <option value=26 @if($Encuesta->ncr2a==26) selected @endif>Sinaloa</option>
                  <option value=27 @if($Encuesta->ncr2a==27) selected @endif>Sonora</option>
                  <option value=28 @if($Encuesta->ncr2a==28) selected @endif>Tabasco</option>
                  <option value=29 @if($Encuesta->ncr2a==29) selected @endif>Tamaulipas</option>
                  <option value=30 @if($Encuesta->ncr2a==30) selected @endif>Tlaxcala</option>
                  <option value=31 @if($Encuesta->ncr2a==31) selected @endif>Veracruz</option>
                  <option value=32 @if($Encuesta->ncr2a==32) selected @endif>Yucatán</option>
                  <option value=33 @if($Encuesta->ncr2a==33) selected @endif>Zacatecas</option>
                  <option value=0  hidden></option>
               </select>
               <h2 class="reactivo">63a.- Extranjero Especifique: </h2>
               <INPUT type="text" class="texto " id="ncr2ext" name="ncr2ext" value="{{$Encuesta->ncr2ext}}" style="width:60%"  maxlength="110"  >
            </td>
         </tr>
         <tr>
            <td>
               <h2 class="reactivo"> 64.- La empresa o institución donde trabaja es:</h2>
               <select class="select" id="ncr3"  name="ncr3" >
                  <option selected  value=""></option>
                  <option value=1 @if($Encuesta->ncr3==1) selected @endif>Pública</option>
                  <option value=2 @if($Encuesta->ncr3==2) selected @endif>Privada</option>
                  <option value=3 @if($Encuesta->ncr3==3) selected @endif>Social</option>
                  <option value=0  hidden></option>
               </select>
            </td>
            <td>
               <h2 class="reactivo">65.- ¿En qué sector se ubica? </h2>
               <select class="select" id="ncr4" name="ncr4"   onchange="bloquear('ncr4',[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,22,23,24],[ncr4a])">
                  <option selected="selected" value="">
                  <option value=1 @if($Encuesta->ncr4==1) selected @endif> Agricultura, ganadería, aprovechamiento forestal, caza y pesca</option>
                  <option value=19 @if($Encuesta->ncr4==19) selected @endif>Asociaciones y agrupaciones</option>
                  <option value=20 @if($Encuesta->ncr4==20) selected @endif>Actividades de gobierno, organismos internacionales y extraterritoriales</option>
                  <option value=4 @if($Encuesta->ncr4==4) selected @endif>Construcción</option>
                  <option value=6 @if($Encuesta->ncr4==6) selected @endif>Comercio al por mayor</option>
                  <option value=7 @if($Encuesta->ncr4==7) selected @endif>Comercio al por menor</option> 
                  <option value=13 @if($Encuesta->ncr4==13) selected @endif>Dirección de corporativos y empresas</option>
                  <option value=23 @if($Encuesta->ncr4==23) selected @endif>Editorial</option>
                  <option value=3 @if($Encuesta->ncr4==3) selected @endif>Electricidad, agua y suministro de gas</option>
                  <option value=5 @if($Encuesta->ncr4==5) selected @endif>Industrias manufactureras o de la transformación</option>
                  <option value=9 @if($Encuesta->ncr4==9) selected @endif>Información en medios masivos</option>
                  <option value=2 @if($Encuesta->ncr4==2) selected @endif>Minería</option>
                  <option value=10 @if($Encuesta->ncr4==10) selected @endif>Servicios financieros y de seguros</option>
                  <option value=11 @if($Encuesta->ncr4==11) selected @endif>Servicio inmobiliario y de alquiler de bienes muebles e intangibles</option>
                  <option value=12 @if($Encuesta->ncr4==12) selected @endif>Servicios profesionales, científicos y técnicos</option>
                  <option value=14 @if($Encuesta->ncr4==14) selected @endif>Servicios de apoyo a los negocios, manejo de desecho y servicios de remediación</option>
                  <option value=15 @if($Encuesta->ncr4==15) selected @endif>Servicios de salud</option>
                  <option value=16 @if($Encuesta->ncr4==16) selected @endif>Servicios educativos</option>
                  <option value=17 @if($Encuesta->ncr4==17) selected @endif>Servicios de esparcimiento, cultural, deportivos y otros centros recreativos</option>
                  <option value=18 @if($Encuesta->ncr4==18) selected @endif>Servicios de alojamiento temporal, de preparación de alimentos y bebidas (hotel, restaurant, bar) </option>
                  <option value=8 @if($Encuesta->ncr4==8) selected @endif>Transporte, correos y almacenamiento</option>
                  <option value=22 @if($Encuesta->ncr4==22) selected @endif>Telecomunicaciones </option>
                  <option value=24 @if($Encuesta->ncr4==24) selected @endif>Servicios Personales </option>
                  <option value=25 @if($Encuesta->ncr4==25) selected @endif>Servicios  de reparacion y mantenimiento </option>
                  <option value=21 @if($Encuesta->ncr4==21) selected @endif>Otro (Especifíque)</option>
                  <option value=0  hidden></option>
               </select>
               <br>
               <h2 class="reactivo"> Giro específico </h2>
               <textarea  class="texto" id="giro_especifico" name="giro_especifico" cols="30" maxlength="550" value=0 >@if($Empresa!=null){{$Empresa->giro_especifico}}@endif</textarea>
            </td>
            <td>
               <h2 class="reactivo">65a).- Otra:</h2>
               <input  class="texto" id="ncr4a" name="ncr4a"  maxlength="65" value=0 > 
            </td>
            <td>
               <h2 class="reactivo"> 66.-Aproximadamente, ¿cuántas personas laboran en la empresa?  </h2>
               <select class="select" id="ncr5" name="ncr5"  >
                  <option selected="selected" value="">
                     <option value=1 @if($Encuesta->ncr5==1) selected @endif> Hasta 15 empleados
                  </option>
                  <option value=2 @if($Encuesta->ncr5==2) selected @endif>Entre 16 y 100 empleados </option>
                  <option value=3 @if($Encuesta->ncr5==3) selected @endif>Entre 101 y 250 empleados</option>
                  <option value=4 @if($Encuesta->ncr5==4) selected @endif>Más de 251 empleados</option>
                  <option value=0  hidden></option>
               </select>
            </td>
         </tr>
         <tr>
            <td>
               <h2 class="reactivo"> 67.- ¿Cuál es su condición en el trabajo? </h2>
               <select class="select" id="ncr6a2"  name="ncr6" onchange="autoempleo()">
                  <option selected="selected" value="">
                     <option value=1 @if(in_array($Encuesta->ncr6,array(2,3,6))) selected @endif >Autoempleo
                  </option>
                  <option value=4 @if($Encuesta->ncr6==4) selected @endif>Empleado </option>
                  <option value=5 @if($Encuesta->ncr6==5) selected @endif>Otro (Especifíque)</option>
                  <option value=0  hidden></option>
               </select>
            </td>
            <td>
               <h2 class="reactivo"> 67a.-¿Tipo de autoempleo? </h2>
               <select class="select" id="ncr6a" name="ncr6t" >
                  <option selected="selected" value="">
                     <option value=2 @if($Encuesta->ncr6==2) selected @endif>Propietario
                  </option>
                  <option value=3 @if($Encuesta->ncr6==3) selected @endif>Profesional independiente</option>   
                  <option value=6 @if($Encuesta->ncr6==6) selected @endif>Trabajador independiente (no ejerce) </option>
                  <option value=0  hidden></option>
               </select>
               <br>
            </td>
            <td>
               <h2 class="reactivo"> Otra: </h2>
               <input type="text" class="texto" id="ncr6otra" name="ncr6_a" style="width:60%" maxlength="65" value=" " > 
            </td>
            <td>
               <h2 class="reactivo">68.- ¿Cuál es su puesto? </h2>
               <textarea type="text" class="texto" id="ncr7a" name="ncr7_a" cols="30" rows="3">{{$Encuesta->ncr7_a}} </textarea>
            </td>
         </tr>
         <tr>
            <td>
               <h2 class="reactivo">69.- ¿Requiere tener título profesional para el puesto que ocupa? </h2>
               <select class="select" id="ncr7b" name="ncr7b"  >
                  <option selected="selected" value="">
                     <option value=1 @if($Encuesta->ncr7b==1) selected @endif>Sí
                  </option>
                  <option value=2 @if($Encuesta->ncr7b==2) selected @endif>No</option> 
                  <option value=0  hidden></option>
               </select>
            </td>
            <td>
               <h2 class="reactivo"> 70.- En su trabajo,¿tiene personal a su cargo? </h2>
               <select class="select" id="ncr8" name="ncr8"  onchange="bloquear('ncr8',[2],[ncr9])" >
                  <option selected="selected" value="">
                     <option value=1 @if($Encuesta->ncr8==1) selected @endif>Sí
                  </option>
                  <option value=2 @if($Encuesta->ncr8==2) selected @endif>No</option>
                  <option value=0  hidden></option>
               </select>
            </td>
            <td>
               <h2 class="reactivo"> 71.- ¿Cuántas personas trabajan con usted? </h2>
               <select class="select" id="ncr9"  name="ncr9"  >
                  <option selected="selected" value="">
                     <option value=1 @if($Encuesta->ncr9==1) selected @endif>1 a 5 
                  </option>
                  <option value=2 @if($Encuesta->ncr9==2) selected @endif>6 a 10</option> 
                  <option value=3 @if($Encuesta->ncr9==3) selected @endif>11 a 20</option> 
                  <option value=4 @if($Encuesta->ncr9==4) selected @endif>21 a 30</option> 
                  <option value=5 @if($Encuesta->ncr9==5) selected @endif>31 o más</option> 
                  <option value=0  hidden></option>
               </select>
            </td>
            <td>
               <h2 class="reactivo">72.- ¿Su trabajo es de tiempo completo?</h2>
               <select class="select" id="ncr10" name="ncr10"  >
                  <option selected="selected" value="">
                     <option value=1 @if($Encuesta->ncr10==1) selected @endif>Sí
                  </option>
                  <option value=2 @if($Encuesta->ncr10==2) selected @endif>No</option> 
                  <option value=0  hidden></option>
               </select>
            </td>
         </tr>
         <tr>
            <td>
               <h2 class="reactivo"> 73.- ¿En que médida está relacionado su trabajo actual con su profesión? </h2>
               <select class="select" id="ncr11" name="ncr11"   onchange="func_ncr11()" >
                  <option selected="selected" value="">
                     <option value=1 @if($Encuesta->ncr11==1) selected @endif>Muy relacionado
                  </option>
                  <option value=2 @if($Encuesta->ncr11==2) selected @endif>Medianamente relacionado</option> 
                  <option value=3 @if($Encuesta->ncr11==3) selected @endif>No está relacionado</option> 
                  <option value=0  hidden></option>
               </select>
            </td>
            <td>
               <h2 class="reactivo">74.- ¿Que actividades realiza? 
                  Especifique:
               </h2>
               <textarea type="text" class="texto" id="ncr12_a"  rows="8"  name="ncr12_a" maxlength="500"  > {{$Encuesta->ncr12_a}} </textarea>
            </td>
            <td>
               <h2 class="reactivo"> 75.- ¿Si su trabajo no está relacionado con su carrera
                  es porque usted así lo decidió? 
               </h2>
               <select class="select" id="ncr15" name="ncr15"  >
                  <option selected="selected" value="">
                     <option value=1 @if($Encuesta->ncr15==1) selected @endif>Sí
                  </option>
                  <option value=2 @if($Encuesta->ncr15==2) selected @endif>No</option> 
                  <option value=0  hidden></option>
               </select>
            </td>
            <td>
               <h2 class="reactivo"> 76.- ¿Cómo considera que lo preparó el estudio de la carrera para el desempeño de su trabajo actual? </h2>
               <select class="select" id="ncr16" name="ncr16">
                  <option selected="selected" value="">
                     <option value=1 @if($Encuesta->ncr16==1) selected @endif>Muy Bien
                  </option>
                  <option value=2 @if($Encuesta->ncr16==2) selected @endif>Bien</option>
                  <option value=3 @if($Encuesta->ncr16==3) selected @endif>Medianamente</option>
                  <option value=4 @if($Encuesta->ncr16==4) selected @endif>Mal</option>
                  <option value=5 @if($Encuesta->ncr16==5) selected @endif>Muy mal</option>
                  <option value=0  hidden></option>
               </select>
            </td>
         </tr>
         <tr>
            <td>
               <h2 class="reactivo">77.¿Cuál es su grado de satisfacción con su trabajo actual? </h2>
               <select class="select" id="ncr17" name="ncr17" >
                  <option selected="selected" value="">
                     <option value=1 @if($Encuesta->ncr17==1) selected @endif>Muy satisfecho(a)
                  </option>
                  <option value=2 @if($Encuesta->ncr17==2) selected @endif>Satisfecho(a)</option>
                  <option value=3 @if($Encuesta->ncr17==3) selected @endif>Medianamente satisfecho(a)</option>
                  <option value=4 @if($Encuesta->ncr17==4) selected @endif>Poco satisfecho(a)</option>
                  <option value=5 @if($Encuesta->ncr17==5) selected @endif>Nada satisfecho(a)</option>
                  <option value=0  hidden></option>
               </select>
            </td>
            <td>
               <h2 class="reactivo">78.- ¿Considera que el salario que percibe en su  trabajo es congruente con su preparación?
               </h2>
               <select class="select" id="ncr18" name="ncr18">
                  <option selected="selected" value="">
                     <option value=1 @if($Encuesta->ncr18==1) selected @endif>Totalmente de acuerdo
                  </option>
                  <option value=2 @if($Encuesta->ncr18==2) selected @endif>De acuerdo</option>
                  <option value=3 @if($Encuesta->ncr18==3) selected @endif>Medianamente de acuerdo</option>
                  <option value=4 @if($Encuesta->ncr18==4) selected @endif>En desacuerdo</option>
                  <option value=5 @if($Encuesta->ncr18==5) selected @endif>Totalmente en desacuerdo</option>
                  <option value=0  hidden></option>
               </select>
            </td>
            <td>
               <h2 class="reactivo">79.- ¿Considera que las actividades y responsabilidades que tiene 
                  en su trabajo, corresponden a su nivel educativo?  
               </h2>
               <select class="select" id="ncr19" name="ncr19" >
                  <option selected="selected" value="">
                     <option value=5 @if($Encuesta->ncr19==5) selected @endif>Totalmente de acuerdo
                  </option>
                  <option value=4 @if($Encuesta->ncr19==4) selected @endif>De acuerdo</option>
                  <option value=3 @if($Encuesta->ncr19==3) selected @endif>Medianamente de acuerdo</option>
                  <option value=2 @if($Encuesta->ncr19==2) selected @endif>En desacuerdo</option>   
                  <option value=1 @if($Encuesta->ncr19==1) selected @endif>Totalmente  en desacuerdo</option>
                  <option value=0  hidden></option>
               </select>
            </td>
            <td>
               <h2 class="reactivo">80.- ¿Cuántos trabajos tiene actualmente?  </h2>
               <select class="select" id="ncr20" name="ncr20"  >
                  <option selected="selected" value="">
                     <option value=1 @if($Encuesta->ncr20==1) selected @endif>Uno
                  </option>
                  <option value=2 @if($Encuesta->ncr20==2) selected @endif>Dos</option>
                  <option value=3 @if($Encuesta->ncr20==3) selected @endif>Tres o más</option>
                  <option value=0  hidden></option>
               </select>
            </td>
         </tr>
         <tr>
            <td>
               <h2 class="reactivo"> 81.- ¿Cuáles son sus ingresos mensuales promedio en su o sus trabajos?  </h2>
               <INPUT type="text" class="texto"  id="ncr21" name="ncr21" size="10" maxlength="6" value="{{$Encuesta->ncr21}}"  onKeyPress="return acceptNum(event)" > 
               (solo enteros, sin centavos, comas, ni puntos) 
            </td>
            <td>
               <h2 class="reactivo"> 82.- Desde que terminó sus estudios de licenciatura,
                  ¿ha dejado de trabajar? 
               </h2>
               <select class="select" id="ncr22" name="ncr22"  onchange="bloquear('ncr22',[2],[ncr24,ncr24a,ncr24porque,ncr23]) ">
                  <option value="" selected="selected"></option>
                  <option value=1 @if($Encuesta->ncr22==1) selected @endif>Sí</option>
                  <option value=2 @if($Encuesta->ncr22==2) selected @endif>No</option>
                  <option value=0  hidden></option>
               </select>
            </td>
            <td>
               <h2 class="reactivo"> 83.-¿Actualmente cuál es la razón principal por la que usted no está trabajando o 
                  ha dejado de trabajar? 
               </h2>
               <select class="select" id="ncr24" name="ncr24" onchange="porque()">
                  <option value=""> </option>
                  <option value=1 @if($Encuesta->ncr24==1) selected @endif> Estar estudiando</option>
                  <option value=13 @if($Encuesta->ncr24==13) selected @endif>Embarazo </option>
                  <option value=11 @if($Encuesta->ncr24==11) selected @endif>Razones de salud </option>
                  <option value=4 @if($Encuesta->ncr24==4) selected @endif> Obligaciones familiares</option>
                  <option value=10 @if($Encuesta->ncr24==10) selected @endif>No le interesaba trabajar </option>
                  <option value=5 @if($Encuesta->ncr24==5) selected @endif>Las ofertas eran poco atractivas con relación al salario </option>
                  <option value=6 @if($Encuesta->ncr24==6) selected @endif>Las ofertas eran poco atractivas con relación a las actividades profesionales </option>
                  <option value=2 @if($Encuesta->ncr24==2) selected @endif>Falta de ofertas de trabajo </option>
                  <option value=7 @if($Encuesta->ncr24==7) selected @endif>Falta de experiencia laboral</option>
                  <option value=3 @if($Encuesta->ncr24==3) selected @endif>No tenía las competencias necesarias para el trabajo al que aspiraba </option>
                  <option value=8 @if($Encuesta->ncr24==8) selected @endif> No tener el título de licenciatura</option>
                  <option value=9 @if($Encuesta->ncr24==9) selected @endif>No tener estudios de posgrado </option>
                  <option value=12 @if($Encuesta->ncr24==12) selected @endif> Perdió o dejó su trabajo (¿por qué?)</option>
                  <option value=13 @if($Encuesta->ncr24==13) selected @endif>Embarazo</option> 
                  <option value=15 @if($Encuesta->ncr24==15) selected @endif>Hacer la tesis o trámites de titulación </option> 
                  <option value=16 @if($Encuesta->ncr24==16) selected @endif>Servicio social o prácticas profesionales</option> 
                  <option value=17 @if($Encuesta->ncr24==17) selected @endif>Cambio de residencia</option> 
                  <option value=18 @if($Encuesta->ncr24==18) selected @endif>Emprender un negocio o empresa propios</option> 
                  <option value=19 @if($Encuesta->ncr24==19) selected @endif>Motivos personales</option> 
                  <option value=20 @if($Encuesta->ncr24==20) selected @endif>Derivado de la pandemia</option> 
                  <option value=14 @if($Encuesta->ncr24==14) selected @endif>Otra </option>
                  <option value=0 @if($Encuesta->ncr24==0) selected @endif> </option>
               </select>
            </td>
            <td>
               <br>(Especifíque)
               Otra:
               <input type="text" class="texto" id="ncr24a" name="ncr24a" value="{{$Encuesta->ncr24a}}" maxlength="55" > 
            </td>
         </tr>
         <tr>
            <td>
               <h2 class="reactivo"> 83a):-Perdió o dejó su trabajo, ¿por qué? </h2>
               <select class="select" id="ncr24porque" name="ncr24porque" >
                  <option  value="" selected></option>
                  <option value=1 @if($Encuesta->ncr24porque==1) selected @endif>Cerró la empresa</option> 
                  <option value=2 @if($Encuesta->ncr24porque==2) selected @endif>Liquidación</option> 
                  <option value=3 @if($Encuesta->ncr24porque==3) selected @endif>Término de contrato o proyecto</option> 
                  <option value=4 @if($Encuesta->ncr24porque==4) selected @endif>Renuncia</option> 
                  <option value=15 @if($Encuesta->ncr24porque==15) selected @endif>Renuncia debido a la  pandemia</option>
                  <option value=16 @if($Encuesta->ncr24porque==16) selected @endif>Despido debido a la pandemia</option>
                  <option value=17 @if($Encuesta->ncr24porque==17) selected @endif>Cerro la empresa debido a la pandemia</option>
                  <option value=5  @if($Encuesta->ncr24porque==5) selected @endif>Otra</option> 
                  <option value=9  @if($Encuesta->ncr24porque==9) selected @endif>Jubilarse o Pensionarse</option> 
                  <option value=0   @if($Encuesta->ncr24!=12) selected @endif hidden></option>   
               </select>
            </td>
            <td>
               <h2 class="reactivo"> 84.- ¿Cuál es el periodo más largo que ha permanecido sin laborar? </h2>
               <select class="select" id="ncr23" name="ncr23" >
                  <option selected="selected" value="">
                     <option value=1 @if($Encuesta->ncr23==1) selected @endif>De 1 a 3 meses
                  </option>
                  <option value=2 @if($Encuesta->ncr23==2) selected @endif>Más de 3 y hasta 6 meses</option> 
                  <option value=3 @if($Encuesta->ncr23==3) selected @endif>Más de 6 y hasta un año</option> 
                  <option value=4 @if($Encuesta->ncr23==4) selected @endif>Más de un año</option> 
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
   unhide('C');
   //   reactivos=document.getElementById("forma_sagrada").elements
   //   for (var i=0, item; item = reactivos[i]; i++) {
   //   // Look no need to do list[i] in the body of the loop
   //   console.log("'"+item.name+"' => 'required',");
   // }
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
   function seccionc2(){
     c1_value=document.getElementById("ncr1").value;
     console.log("C1 value:"+c1_value);
     switch(c1_value){
       case '1':
         reactivosPorCerrar=[giro_especifico,ncr2,ncr2a,ncr3,ncr4,ncr4a,ncr5,ncr6a,ncr6otra,ncr6a2,ncr7a,ncr7b,ncr8,ncr9,ncr10,ncr11,ncr12_a,ncr15,ncr16,ncr17,ncr18,ncr19,ncr20,ncr21,ncr22,ncr23];
         reactivosPorCerrar.forEach(visibilizar);

       break;
       case '2':
         reactivosPorCerrar=[giro_especifico,ncr2,ncr2a,ncr3,ncr4,ncr4a,ncr5,ncr6a,ncr6otra,ncr6a2,ncr7a,ncr7b,ncr8,ncr9,ncr10,ncr11,ncr12_a,ncr15,ncr16,ncr17,ncr18,ncr19,ncr20,ncr21,ncr22,ncr23];
         reactivosPorCerrar.forEach(visibilizar);

       break;
       case '3':
         reactivosPorCerrar=[giro_especifico,ncr2,ncr2a,ncr2ext,ncr3,ncr4,ncr5,ncr4a,ncr6a,ncr6otra,ncr6a2,ncr7a,ncr7b,ncr8,ncr9,ncr10,ncr11,ncr12_a,ncr15,ncr16,ncr17,ncr18,ncr19,ncr20,ncr21,ncr22];
         reactivosPorCerrar.forEach(ocultar);

         reactivosPorAbrir=[ncr24,ncr24a,ncr24porque,ncr23];
         reactivosPorAbrir.forEach(visibilizar);
       break;
       case '4':
         reactivosPorCerrar=[giro_especifico, ncr2,ncr2a,ncr2ext,ncr3,ncr4,ncr5,ncr4a,ncr6a,ncr6otra,ncr6a2,ncr7a,ncr7b,ncr8,ncr9,ncr10,ncr11,ncr12_a,ncr15,ncr16,ncr17,ncr18,ncr19,ncr20,ncr21,ncr22];
         reactivosPorCerrar.forEach(ocultar);

         reactivosPorAbrir=[ncr24,ncr24a,ncr24porque,ncr23];;
         reactivosPorAbrir.forEach(visibilizar);
       break;
       case '5':
         reactivosPorAbrir=[giro_especifico,ncr2,ncr2a,ncr3,ncr4,ncr5,ncr4a,ncr6a,ncr6otra,ncr6a2,ncr7a,ncr7b,ncr8,ncr9,ncr10,ncr11,ncr12_a,ncr15,ncr16,ncr17,ncr18,ncr19,ncr20,ncr21,ncr22];
         reactivosPorAbrir.forEach(visibilizar);
         reactivosPorCerrar=[ncr3,ncr4,ncr5,ncr4a,ncr6a,ncr6otra,ncr6a2,ncr7a,ncr7b,ncr8,ncr9,ncr10,ncr12_a,ncr15,ncr16,ncr17,ncr18,ncr19,ncr20,ncr22,ncr24,ncr24a,ncr24porque,ncr23];
         reactivosPorCerrar.forEach(ocultar);
       break;
       case '6':
         reactivosPorCerrar=[giro_especifico, ncr2,ncr2a,ncr2ext,ncr3,ncr4,ncr5,ncr4a,ncr6a,ncr6otra,ncr6a2,ncr7a,ncr7b,ncr8,ncr9,ncr10,ncr11,ncr12_a,ncr15,ncr16,ncr17,ncr18,ncr19,ncr20,ncr21,ncr22,ncr23];
         reactivosPorCerrar.forEach(ocultar);
         
         reactivosPorAbrir=[ncr24,ncr24a,ncr24porque,ncr23];
         reactivosPorAbrir.forEach(visibilizar);
       break;
       case '7':
         reactivosPorAbrir=[giro_especifico,ncr2,ncr2a,ncr3,ncr4,ncr5,ncr4a,ncr6a,ncr6otra,ncr6a2,ncr7a,ncr7b,ncr8,ncr9,ncr10,ncr11,ncr12_a,ncr15,ncr16,ncr17,ncr18,ncr19,ncr20,ncr21,ncr22];
         reactivosPorAbrir.forEach(visibilizar);
         reactivosPorCerrar=[ncr3,ncr4,ncr5,ncr4a,ncr6a,ncr6otra,ncr6a2,ncr7a,ncr7b,ncr8,ncr9,ncr10,ncr12_a,ncr15,ncr16,ncr17,ncr18,ncr19,ncr20,ncr22,ncr24,ncr24a,ncr24porque,ncr23];
         reactivosPorCerrar.forEach(ocultar);
       break;
       case '8':
         reactivosPorCerrar=[giro_especifico, ncr2,ncr2a,ncr2ext,ncr3,ncr4,ncr5,ncr4a,ncr6a,ncr6otra,ncr6a2,ncr7a,ncr7b,ncr8,ncr9,ncr10,ncr11,ncr12_a,ncr15,ncr16,ncr17,ncr18,ncr19,ncr20,ncr21,ncr22];
         reactivosPorCerrar.forEach(ocultar);

         reactivosPorAbrir=[ncr24,ncr24a,ncr24porque,ncr23];
         reactivosPorAbrir.forEach(visibilizar);
       break;
     }
   }
   function funcion_ncr24(){
     bloquear('ncr24',[1,2,3,4,5,6,7,8,9,10,11,13,14,15,16,17,18,19,20,29],[ncr24porque]);
     bloquear('ncr24',[1,2,3,4,5,6,7,8,9,10,11,12,13,15,16,17,18,19,20,29],[ncr24a])
   } 
   function autoempleo(){
     ncr6_val=document.getElementById('ncr6a2').value;
     console.log('func autoempleo '+ncr6_val);
     switch(ncr6_val){
       case '1': ocultar(ncr6otra);visibilizar(ncr6a);
       break;
       case '4': ocultar(ncr6otra);ocultar(ncr6a);
       break;
       case '5': ocultar(ncr6a);visibilizar(ncr6otra);
       break;
     }
   }
   function porque(){
     ncr24_val=document.getElementById('ncr24').value;
     console.log('func porque '+ncr24_val);
     ocultar(ncr24a);
     switch(ncr24_val){
       case '12': ocultar(ncr24a);visibilizar(ncr24porque);
       break;
       case '14': visibilizar(ncr24a);ocultar(ncr24porque);
       break;
       default: ocultar(ncr24a);ocultar(ncr24porque);
       break;
     }
   }
   
   function func_ncr11(){
     bloquear('ncr11',[1,2,0],[ncr15]);
     bloquear('ncr11',[3,0],[ncr16]);
   }
   // inicializar 
   bloquear('ncr4',[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,22,23,24],[ncr4a])
   autoempleo();
   bloquear('ncr8',[0,2],[ncr9]); 
   porque();
   //bloquear('ncr22',[2,0],[ncr24,ncr24a,ncr24porque,ncr23])
   seccionc2();
   
   console.log('FIN DE FUNCION NCR1-------------------------');
   bloquear('ncr4',[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,22,23,24],[ncr4a])
   bloquear('ncr2a',[0,1,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33],[ncr2ext])
   @if($Encuesta->ncr1==3 |$Encuesta->ncr1==4)
   bloquear('ncr22',[2],[ncr24,ncr24a,ncr24porque,ncr23]);
   @else
   bloquear('ncr22',[2,0],[ncr24,ncr24a,ncr24porque,ncr23]);
   
   @endif
   autoempleo();
   func_ncr11();
   @if($Encuesta->ncr1==1 |$Encuesta->ncr1==2)
   bloquear('ncr11',[1,2],[ncr15]);
   @endif
   bloquear('ncr8',[2,0],[ncr9])
   porque();
   var warning = false;


</script>
<script>
    @foreach ($errors->all() as $error)
                   document.getElementsByName( "{{str_replace(' ', '_',str_replace('The ','',str_replace(' field is required.', '', $error))) }}")[0].style="border: 0.3vw  solid red";
                   console.log( "{{str_replace(' ', '_',str_replace('The ','',str_replace(' field is required.', '', $error))) }}");
     @endforeach
   
</script>
@if(in_array($Encuesta->ncr1,array(5,7)))
<script>
   document.getElementById('ncr16').value={{$Encuesta->ncr16}};
</script>
@endif
@endpush