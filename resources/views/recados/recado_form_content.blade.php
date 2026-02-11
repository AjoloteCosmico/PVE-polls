<div class="recado-form-div">
    <div class="form-group titulos recado-form-div"> <h3 >Deja un recado al num {{$telefono->telefono}}</h3></div>
        <div class="form-group recado-form-div">
            <h6 for="exampleInputEmail1">Selecciona un código de color</h6>
            <br>
            <select name="code" id="{{'code'.$telefono->id}}" class="select input" style="color: white; background-color: {{$Codigos->where('code',$telefono->status)->first()->color_rgb ?? '#000000'}};font-size: 20px;" onchange="codigo({{$telefono->id}})">
                <option value=""> </option>
                @foreach($Codigos as $code)
                    <option style="background-color: {{$code->color_rgb}};color: white; font-size: 20px;" value="{{$code->code}}" @if($telefono->status == $code->code) selected @endif>{{$code->description}}</option>
                @endforeach
            </select>
        </div>
        <input type="text" name="recado" class="form-control input" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Escribe informacion util para localizar a este egresado" >
    
    <br>
        <button type="button" onclick='check_form({{$telefono->id}})'  class="boton-dorado">
            <i class="fas fa-paper-plane"></i> Marcar y guardar recado
        </button>
</div>