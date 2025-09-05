<div class="container" name="{{$Reactivo->clave}}" style="width: 25vmax; color:white">
    @foreach($Opciones->sortBy('orden') as $opcion)
        <div class="form-check">
            <input 
                class="form-check-input" 
                type="checkbox" 
                name="{{ $Reactivo->clave }}opcion{{ $opcion->clave_opcion }}" 
                id="{{ $Reactivo->clave }}-{{ $opcion->clave_opcion }}"
                @if(in_array($opcion->clave_opcion, $respuestas_anteriores))
                    checked
                @endif
            >
            <label class="form-check-label" for="{{ $Reactivo->clave }}-{{ $opcion->clave_opcion }}">
                {{ $opcion->descripcion }}
            </label>
        </div>
    @endforeach
</div>
