<div class="container" name="{{$Reactivo->clave}}" style="width: 25vmax; color:white">
    @foreach($Opciones->sortBy('orden') as $opcion)
        <div class="form-check">
            <input 
                class="form-check-input" 
                type="checkbox" 
                name="{{ $Reactivo->clave }}opcion{{ $opcion->clave }}" 
                id="{{ $Reactivo->clave }}-{{ $opcion->clave }}"
                value="{{ $opcion->clave }}"
                onclick="checkBloqueos('{{ $Reactivo->clave }}')"
                @if(in_array($opcion->clave, $respuestas_anteriores))
                    checked
                @endif
            >
            <label class="form-check-label" for="{{ $Reactivo->clave }}-{{ $opcion->clave }}">
                {{ $opcion->descripcion }}
            </label>
        </div>
    @endforeach
</div>
