<!-- need to remove -->

<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Dashboard </p>
    </a>
</li>
@if(Auth::user()->confidential>=2)
<li class="nav-item">
    <a href="{{ route('stats') }}" class="nav-link {{ Request::is('stats') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chart-bar"></i>
        <p>Conteo</p>
    </a>
</li>
@endif
@if(Auth::user()->confidential>=1)
<li class="nav-item">
    <a href="{{ route('reactivos.index') }}" class="nav-link {{ Request::is('reactivos.index') ? 'active' : '' }}">
        <i class="nav-icon fas fa-question"></i>
        <p>Reactivos</p>
    </a>
</li>
@endif
<li class="nav-item">
    <a href="{{ route('links') }}" class="nav-link {{ Request::is('links') ? 'active' : '' }}">
        <i class="nav-icon fas fa-link"></i>
        <p>Links</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('2019') }}" class="nav-link {{ Request::is('2019') ? 'active' : '' }}">
    <i class="nav-icon fas fa-paper-plane"></i>
        <p>2019 progreso </p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('recados.index') }}" class="nav-link {{ Request::is('recados.index') ? 'active' : '' }}">
    <i class="fas fa-poll"></i>
        <p>Recados Lista</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('muestras.index') }}" class="nav-link {{ Request::is('muestras') ? 'active' : '' }}">
    <i class="nav-icon fas fa-table"></i>
        <p>Muestras</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('revision') }}" class="nav-link {{ Request::is('revision') ? 'active' : '' }}">
    <i class="nav-icon fas fa-eye"></i>
        <p>Revisar mis encuestas</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('aviso') }}" class="nav-link {{ Request::is('aviso') ? 'active' : '' }}">
    <i class="nav-icon fas fa-paper-plane"></i>
        <p>Enviar aviso </p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('buscar') }}" class="nav-link {{ Request::is('buscar') ? 'active' : '' }}">
    <i class="fas fa-eye"></i>
        <p>Buscar numero  </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('empresas.index') }}" class="nav-link {{ Request::is('empresas') ? 'active' : '' }}">
        <i class="fas fa-building"></i>
        <p> Empresas   </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('switch_mode') }}" class="nav-link">
    <button  class="btn" style="color:white">
    @if(Auth::user()->dark_mode==1)    
    <i class="fas fa-sun"></i>
        <p>  desactivar <br>Modo oscuro </p>
        @else
        <i class="fas fa-moon"></i>
        <p>  activar <br>Modo oscuro </p>
        @endif
    </button>

    </a> 
    
</li>
