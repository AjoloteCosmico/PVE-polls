<<<<<<< HEAD
@if($Reactivo->archtype=='textarea')
<br>
<textarea placeholder="Escriba su respuesta" name="{{$Reactivo->clave}}"  id="{{$Reactivo->clave}}"  columns="30" rows="4" maxlength="300"> @if($value) {{$value}} @endif</textarea>

@else
<input type="text" placeholder="Escriba su respuesta" name="{{$Reactivo->clave}}"  id="{{$Reactivo->clave}}" value="{{$value}}" >
@endif
=======
<input type="text" placeholder="Escriba su respuesta" name="{{$Reactivo->clave}}"  id="{{$Reactivo->clave}}" value="{{$value}}" >
>>>>>>> 404e8c6f30ab8f2f64983058bcd403f89c362eb5
