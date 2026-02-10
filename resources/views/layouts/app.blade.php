<x-laravel-ui-adminlte::adminlte-layout>
<head>
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/logoPVE.png') }}"> 
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    
    @stack('css')
    @include('layouts.identidad_grafica')
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
<body class="hold-transition sidebar-mini layout-fixed" >
    <div class="wrapper">
        <!-- Main Header -->
        <nav class="main-header navbar navbar-expand" >
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars fa-lg" style="color:white"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <button type="button"  class="toggle-expand-btn btn  btn-sm" onclick="openFullScreen()">
                        <i style="color:white" class="fa fa-expand"></i>
                    </button>
                </li>
                 
                <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    @if(auth()->user()->unreadNotifications->count())
                        <span class="badge badge-warning navbar-badge">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">
                        {{ auth()->user()->unreadNotifications->count() }} Notificaciones
                    </span>
                    <div class="dropdown-divider"></div>
                    
                    @foreach(auth()->user()->unreadNotifications->take(5) as $notification)
                        <a href="{{ $notification->data['action_url'] ?? '#' }}" 
                        class="dropdown-item">
                            <i class="{{ $notification->data['icon'] ?? 'fas fa-bell' }} mr-2"></i>
                            {{ $notification->data['message'] }}
                            <span class="float-right text-muted text-sm">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </a>
                        <div class="dropdown-divider"></div>
                    @endforeach
                    
                    <a href="{{ route('notifications.index') }}" class="dropdown-item dropdown-footer">
                        Ver todas las notificaciones
                    </a>
                </div>
            </li> 
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="{{asset('img/logoPVE.png')}}" class="user-image img-circle elevation-2" alt="User Image">
                        <span class="d-none d-md-inline" > 
                            <!-- aki iba el nombre de usuario pero lo quite  -->
                            {{ Auth::user()->name }}
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header ">
                            <img src="{{asset('img/logoPVE.png')}}" class="img-circle elevation-2" alt="User Image">
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
        <footer class="main-footer">
            <div class="float-right  >
                <b>Version</b> 3.1.0
            </div>
            <strong>Copyright &copy; 2024-2025 <a href="https://www.pveaju.unam.mx/">PVEAJU-UNAM</a>.</strong> All rights
            reserved. Version 1.1.2 april  25 2025
        </footer>
    </div>
    @stack('js')
</body>
</x-laravel-ui-adminlte::adminlte-layout>

