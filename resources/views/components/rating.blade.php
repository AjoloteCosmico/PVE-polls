{{--
    Este componente requiere las siguientes variables:
    - $Reactivo (el objeto reactivo con su clave)
    - $Opciones (Colección de opciones con 'clave' y 'descripcion')
    - $value (valor previamente guardado, si existe)
--}}

<div class="rating-stars-container">
    
    @foreach($Opciones->sortByDesc('clave') as $index => $opcion)
        @php
            // La clave única para el radio button
            $id_radio = $Reactivo->clave . '_' . $opcion->clave;
            
            // Determinar si esta opción debe estar marcada
            $checked = ($value == $opcion->clave);
            
            // Calculamos el tamaño progresivo. Usamos el índice (+1) para escalar el tamaño.
            // Esto se usará en el CSS para hacer las estrellas más grandes.
            $size_class = 'star-size-' . (6-($index + 1));
            
            // Revertir el orden si quieres que la estrella más grande sea la última opción (mayor valor)
            // $total_opciones = $Opciones->count();
            // $size_class = 'star-size-' . ($total_opciones - $index); 

        @endphp

        <div class="rating-option-wrapper">
            {{-- 1. Radio Button (Oculto) --}}
            <input 
                type="radio"
                id="{{ $id_radio }}"
                name="{{ $Reactivo->clave }}"
                value="{{ $opcion->clave }}"
                class="sr-only rating-input" {{-- 'sr-only' para ocultar el radio nativo --}}
                onChange="checkBloqueos('{{$Reactivo->clave}}')"
                @if($checked) checked @endif
            >

            {{-- 2. La Etiqueta (La Estrella Visible) --}}
            <label 
                for="{{ $id_radio }}" 
                class="rating-star {{ $size_class }}"
                data-tooltip="{{ $opcion->descripcion }}"
                style="font-color: #FFF"
            >
                &#9733; {{-- Código Unicode para una estrella sólida (★) --}}
            </label>

            {{-- 3. La Descripción Debajo de la Estrella --}}
            <span class="rating-description">
                {{ $opcion->descripcion }}
            </span>
        </div>
    @endforeach
</div>

{{-- **IMPORTANTE:** Necesitas añadir el CSS en tu hoja de estilos principal. --}}