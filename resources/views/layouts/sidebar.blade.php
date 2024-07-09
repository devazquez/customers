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
        <a href="{{ url('/home') }}"></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ url('/home') }}" class="small-sidebar-text">
            <img class="navbar-brand-full " src="{{ asset('img/logo-reduce-huella.png') }}" width="45px" alt="logo seguimiento huella de carbono"/>
        </a>
    </div>
    <ul class="sidebar-menu">
        @include('layouts.menu')
    </ul>
</aside>
