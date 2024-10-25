@extends('layouts.app')

@section('content')
<div class="container-fluid"  background="{{asset('img/Fondo2.jpg')}}">
    <div>
    <h1 class="text-white-50">  Estas son tus muestras {{Auth::user()->name }} </h1>
        <h1 class="text-white-50"> </h1>
    </div>
    <div class="padding-conteiner">
        <h1 class="text-white-50"> ESTUDIO 2019</h1>
<br><br>
    <!-- aca van los cuadros -->
    <div  class="container">

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        @foreach($Muestras2019 as $m)
        @if($m->id)
        <div class="col"> <a href="{{ route('muestras.show',$m->id) }}">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="true"><title>Placeholder</title><rect width="100%" height="100%" fill="{{Auth::user()->color}}"/>
            <text x="20%" y="50%" fill="#eceeef" dy=".3em"> {{$m->plantel}} </text>
            <text x="20%" y="40%" fill="#eceeef" dy=".10em" > {{$m->carrera}} </text></svg>

            <div class="card-body">
              <p class="card-text">Egresaron {{$m->poblacion}} alumnos de esta carrera, se requiere encuestar a {{$m->requeridas_5}} de ellos. </p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                  <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                </div>
                <small class="text-muted">9 mins</small>
              </div>
            </div>
          </div>
        </a>
        </div>
        @endif
        @endforeach
        </div>
        </div>
    </div>
    <div class="padding-conteiner" >
        <h1 class="text-white-50"> ACTUALIZACION 2014</h1>
    </div>
</div>
@endsection
 

