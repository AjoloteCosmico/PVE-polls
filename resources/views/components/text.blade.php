@if($Reactivo->archtype=='textarea')
<br>
<textarea placeholder="Escriba su respuesta" name="{{$Reactivo->clave}}"  id="{{$Reactivo->clave}}"  columns="30" rows="4" maxlength="300"> @if($value) {{$value}} @endif</textarea>

@else
<input type="text" placeholder="Escriba su respuesta" name="{{$Reactivo->clave}}"  id="{{$Reactivo->clave}}" value="{{$value}}" >
@endif
