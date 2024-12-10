
<select name="" id="" style="color:black">
    @foreach($Opciones as $opcion)
        <option value="{{$opcion->clave}}">{{$opcion->descripcion}}</option>
    @endforeach
</select>