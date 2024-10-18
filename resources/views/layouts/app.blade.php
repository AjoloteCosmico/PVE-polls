<x-laravel-ui-adminlte::adminlte-layout>
<head>
<link rel="shortcut icon" type="image/png" href="{{ asset('img/logoPVE.png') }}">
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script
    src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet"
    href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet"
    href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    
    <link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet"
    href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap.css">
    <link rel="stylesheet"
    href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.bootstrap.css">
    <style>
        th{
            background-color: {{ Auth::user()->color }};
            color: white;
            position: sticky;
    z-index: 1;
    top:0;
        }
        .content-wrapper {
   
  background: url("{{asset('img/'.Auth::user()->image )}}") 50% 0 no-repeat fixed;
  background-size: cover;
  font-weight: bold;
  size: 1.9vw;
  color: #cdc8d8;
}
.wrapper {
   
   background: #343A40;
    
}
     </style>
     <style>
.panel-fullscreen {
display: block;
z-index: 9999;
position: fixed;
width: 100%;
height: 100%;
top: 0;
right: 0;
left: 0;
bottom: 0;
overflow: auto;
}
</style>
<style>
 
 
    .dataTables_filter {
  position: relative;
  background: transparent;
  color: {{ Auth::user()->color}};
}
.dataTables_filter input  {
 
  width: 10.9vw;
  height: 2.9vw;
  /* background: var(--primary); */
  border: 1px solid rgba(255, 255, 255, 0.937);
  border-radius: 5px;
  box-shadow: 0 0 3px #0A0A0A, 0 10px 15px #ebebeb inset;
  text-indent: 10px;
  font-color: {{ Auth::user()->color}};
  font-size: 1.3vw;
}
 
.dataTables_filter {
  aling: center;
  size: 40px;
  color: {{ Auth::user()->color}} ;

}
    .dataTables_wrapper .dataTables_paginate .paginate_button {
  background:  {{ Auth::user()->color}} !important;
  color: white!important;
  border-radius: 4px;
  border: 1px solid #ffffff;
  font-size: 1.9vw;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background:  white!important;
  color: #9e7205!important;
  weight: bolder;
  border-radius: 4px;
  border: 1px solid #ffffff;
}
 
.dataTables_wrapper .dataTables_paginate .paginate_button:active {
  background: #f9b70f9d!important;
  color: white!important;
}
</style>

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
    <body class="hold-transition sidebar-mini layout-fixed"  >
        <div class="wrapper">
            <!-- Main Header -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background:#343A40; color:white;">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars" style="color:white"></i></a>
                    </li>
                </ul>
                
                <ul class="navbar-nav ml-auto">
                 <li class="nav-item">
                    <button type="button" style="color:white" class="toggle-expand-btn btn  btn-sm" onclick="openFullScreen()"><i class="fa fa-expand"></i></button>
                </li> 
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <img src="{{asset('img/logoPVE.png')}}"
                                class="user-image img-circle elevation-2" alt="User Image">
                            <span class="d-none d-md-inline" style="color:white;"> 
                                <!-- aki iba el nombre de usuario pero lo quite  -->
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

            <!-- Main Footer -->
            <footer class="main-footer" style="background:#343A40">
                <div class="float-right d-none d-sm-block" >
                    <b>Version</b> 3.1.0
                </div>
                <strong>Copyright &copy; 2022-2023 <a href="https://www.pveu.unam.mx/">PVE-UNAM</a>.</strong> All rights
                reserved.
            </footer>
        </div>

        
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
  

        @stack('js')
    </body>
</x-laravel-ui-adminlte::adminlte-layout>

