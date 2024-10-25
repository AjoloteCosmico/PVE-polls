@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div>
    <h1 class="text-white-50">Bienvenid@!!  {{Auth::user()->name }} {{Auth::user()->emojis }}</h1>
    <div>-----------------------------------------
        <br><br><br> 
    <a href="{{ route('report','reporte_individual')}}"  > <button class="btn">
    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Reporte Individual 2019
    </button></a>
    
    <a href="{{ route('report','reporte_individual_act2014')}}"  > <button class="btn" >
    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Reporte Individual 2014
    </button></a>
    
    <a href="{{ route('report','correos_inconclusas')}}"  > <button class="btn" >
    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Correos par encuestas inconclusas
    </button></a>

    <a href="{{ route('report','correos_muestra_sin_contestar')}}"  > <button class="btn" >
    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Correos muestra sin contestar
    </button></a>

    <a href="{{ route('report','correos_contestadas')}}"  > <button class="btn" >
    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Correos par encuestas completas
    </button></a>

    <a href="{{ route('report','base20')}}"  > <button class="btn" >
    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; ENCUESTAS 2020 BASE (al dia de hoy)
    </button></a>
    </div>

<br>
</div>
<div >
        <div class="col"> 
            <div class="row"> 
                <div class="col stat-card" >
                    <div class="row"> Total encuestas 2020:  </div>
                    <div class="row  data-card"> {{$total20}} </div>
                    por internet: {{$Internet}}
                </div>
                <div class="col stat-card" >
                    <div class="row"> Total encuestas 2014:  </div>
                    <div class="row  data-card"> {{$total14}}  </div>
                    por internet: {{$Internet14}}
                </div>
                <div class="col">

                </div>
            </div>
            {!! $aplica_chart->container() !!}
        </div>

</div>
        

<script src="{{ $chart->cdn() }}"></script>
{!! $chart->script() !!}


    <script src="{{ $aplica_chart->cdn() }}"></script>
   <div >
    {!! $aplica_chart->script() !!}
    </div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

@endpush

@push('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script>
 
  console.log('script jalando ¿?');
  $(document).ready(function() {
    $('#myTable').DataTable();
} );
 </script>

 @endpush