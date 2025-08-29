
  
        <table class="table text-lg table-personal" >
         
         <tr>
           <th>Egresad@: </th>
           <td> {{$Egresado->nombre}} {{$Egresado->paterno}} {{$Egresado->materno}}</td>
           <th>Número C:</th>
           <td> {{$Egresado->cuenta}}</td>
           <th> Teléfonos:  <br><br> <a href="{{route('agregar_telefono',[$Egresado->cuenta,$Egresado->carrera,$Encuesta->registro,Session::get('telefono_encuesta')])}}">  <button class="btn boton-dorado" > <i class="fas fa-plus-circle"></i>&nbsp; Nuevo telefono  </button></a></th>
           <td>  
           @foreach($Telefonos as $t)
               <a class="contact_data" style="color: #002b7a;"  href="{{route('editar_telefono',[$t->id,$Egresado->carrera,$Encuesta->registro,Session::get('telefono_encuesta')])}}">{{$t->telefono}} </a>, &nbsp;
            
             @endforeach
            </td>
           <th>Sistema: @if($Egresado->sistema=='E' ) ESCOLARIZADO @elseif($Egresado->sistema=='A') ABIERTO @else A DISTANCIA @endif </th> 
           <th>@if($Egresado->titulado==1)  EN TRAMITES @elseif($Egresado->titulado==2) TITULADO @else SIN TITULO @endif  <br> segun la encuesta anterior</th>
         </tr>
         <tr>
          
         <th>Carrera:</th><td> {{$Carrera}}  </td> 
         <th>Plantel:</th><td> {{$Plantel}}</td> 
         
          <th>Correos: <br><br> <a  href="{{route('agregar_correo',[$Egresado->cuenta,$Egresado->carrera,$Encuesta->registro,Session::get('telefono_encuesta')])}}">  <button class="btn boton-dorado" > <i class="fas fa-plus-circle"></i>&nbsp; Nuevo Correo  </button></a></td> </th>
          <td> @foreach($Correos as $c)
            <a class="contact_data" style="color: #002b7a;" onclick="correos({{$c->id}},'{{$c->correo}}')"> {{$c->correo}} </a> , &nbsp;
           @endforeach </td>
          <th>Fecha en que se encuestó:</th> <td>{{substr($Egresado->actualized,0,10)}}
            
            @if($Encuesta->completed==1)
              <button onclick="send_form('terminar')"> Terminar Encuesta</button>
            @else
              <button onclick="send_form('inconclusa')"> Guardar como inconclusa</button>            
            @endif
            
          </td>
         </tr>
        
        </table>
 @push('css')
 
 <style>
   
   .customSwalBtn{
   padding:0.10vmax;
   margin:0.5vmax;
   background-color: #002b7a;
   }
   .customSwalBtn:hover{
      background-color: #ba800d;
     color:#FFFFFF;
      transform: translateY(-4px);
   }
 </style>
 @endpush

 @push('js')
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
<script type="text/javascript">
 
 function correos(correo_id,correo){
   window.warning=false;
    console.log(window.warning);
   Swal.fire({
     title: correo,
     html: 
           "<br> " +
           '<button type="button" role="button" tabindex="0" class="SwalBtn1 customSwalBtn" onclick="location.href = `/direct_send/'+correo_id +'`">' + 'Enviar Aviso de Privacidad' + '</button>' +
           '<button type="button" role="button" tabindex="0" class="SwalBtn2 customSwalBtn" onclick="location.href = `/editar_correo/'+correo_id +'/{{$Egresado->carrera}}/{{$Encuesta->registro}}/{{ Session::get('telefono_encuesta') }}`">' + 'Editar' + '</button>',
           
     icon: "warning",
     showConfirmButton: false,
     showCancelButton: false
   });
 }

</script>
 @endpush