<li class="side-menus {{ Request::is('home') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('home') }}">
        <i class=" fas fa-building"></i><span>Inicio</span>
    </a>
</li>

<li class="nav-item dropdown active {{ Request::is('huella-carbono/*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown " data-toggle="dropdown"><i class="fas fa-pen-square"></i> <span>Huella de carbono</span></a>    
        <ul class="dropdown-menu" >  
            
            <li class="{{ Request::is('huella-carbono/form-seg-casa') ? 'active' : '' }} " ><a class="nav-link " href="{{ route('formSegCasa') }} ">1) Vivienda</a> </li>
            <li class="{{ Request::is('huella-carbono/form-seg-traslados') ? 'active' : '' }}" ><a class="nav-link" href="{{ route('formSegTraslados') }} ">2) Traslados </a></li>   
            <li class="{{ Request::is('huella-carbono/form-seg-alimentos') ? 'active' : '' }}" ><a class="nav-link" href="{{ route('formSegAlimentos') }} ">3) Alimentos </a></li>                        
            <li class="{{ Request::is('huella-carbono/form-seg-consumos-varios') ? 'active' : '' }}" ><a class="nav-link" href="{{ route('formSegMateriales') }} ">4) Consumos varios </a></li>                                              
            <li class="{{ Request::is('huella-carbono/form-seg-reciclaje') ? 'active' : '' }}" ><a class="nav-link" href="{{ route('formSegReciclaje') }} ">5) Reciclaje </a></li>               
            <li class="{{ Request::is('huella-carbono/mi-huella-carbono') ? 'active' : '' }}" ><a class="nav-link" href="{{ route('huellacarbono.index') }} ">6) Mi huella de carbono </a></li>
        </ul>    
</li>

<!--
<li class="side-menus {{ Request::is('ayuda') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('ayuda') }}">
        <i class="fa fa-info-circle"></i><span>Ayuda</span>
    </a>
</li>
-->
