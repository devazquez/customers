<li class="side-menus {{ Request::is('cosumers')  ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('home') }}">
        <i class=" fas fa-building"></i><span>Importar csv</span>
    </a>
</li>
<li class="side-menus {{ Request::is('costumers-import') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('home') }}">
        <i class=" fas fa-building"></i><span>Lista de clientes</span>
    </a>
</li>



<!--
<li class="side-menus {{ Request::is('ayuda') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('ayuda') }}">
        <i class="fa fa-info-circle"></i><span>Ayuda</span>
    </a>
</li>
-->
