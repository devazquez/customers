<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
    <img class="navbar-brand-full app-header-logo" src="{{ asset('img/logo-scjn-h.png') }}" width="170"
             alt="Logo Carpool">
        <!--
        @if( Session::get('depGob') == "scjn" )        
        <img class="navbar-brand-full app-header-logo" src="{{ asset('img/logo-scjn-h.png') }}" width="170"
             alt="Logo Carpool">
        @else
        <img class="navbar-brand-full app-header-logo" src="{{ asset('img/logo_cjf.png') }}" width="170"
            alt="Logo Carpool">
        @endif
-->
        
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        
    </div>
    <ul class="sidebar-menu">
        @include('layouts.menu')
    </ul>
</aside>
