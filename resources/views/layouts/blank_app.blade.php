<x-laravel-ui-adminlte::adminlte-layout>
<head>
<link rel="shortcut icon" type="image/png" href="{{ asset('img/logoPVE.png') }}">
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
@include('encuesta.estilo_encuesta')
     @stack('css')
     
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
    var elem = document.documentElement;
  function openFullScreen() {
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.webkitRequestFullscreen) { /* Safari */
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) { /* IE11 */
    elem.msRequestFullscreen();
  }
}
</script>

</head>
    <body class="hold-transition sidebar-mini layout-fixed sidebar-collapse"  >
        <div class="wrapper">
            <!-- Main Header -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light" >
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars" ></i></a>
                    </li>
                </ul>
                
                <ul class="navbar-nav ml-auto">
                 <li class="nav-item">
                    <button type="button" class="toggle-expand-btn btn  btn-sm" onclick="openFullScreen()"><i class="fa fa-expand"></i></button>
                </li> 
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <img src="{{asset('img/logoPVE.png')}}"
                                class="user-image img-circle elevation-2" alt="User Image">
                            <span class="d-none d-md-inline"> 
                                
                                {{ Auth::user()->name }}

                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <!-- User image -->
                            <li class="user-header ">
                                <img src="{{asset('img/logoPVE.png')}}"
                                    class="img-circle elevation-2" alt="User Image">
                                <p>
                                    {{ Auth::user()->name }}
                                    <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                <a href="#" class="btn btn-default btn-flat float-right"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sign out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

      <!-- Left side column. contains the logo and sidebar -->
            @include('layouts.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>

            

        
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
  
  @include('encuesta.scripts_encuesta')
   @stack('js')

    </body>
</x-laravel-ui-adminlte::adminlte-layout>

