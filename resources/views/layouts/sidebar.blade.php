<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('home') }}" class="brand-link">
        <div class="row">
            <center>
                <img src="{{asset('img/logoPVE.png')}}"
                    alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light">ENCUESTAS <br> PVE UNAM </span> 
            </center>
        </div>
    </a>
    
    <div class="sidebar">
        
        <nav class="mt-2">
            
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.menu')
            </ul>
        </nav>
    </div>
</aside>
