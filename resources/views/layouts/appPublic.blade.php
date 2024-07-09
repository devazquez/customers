<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('img/favicon.ico') }}">
    
    <!-- Bootstrap 4.1.1 -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Ionicons -->
    <link href="//fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/@fortawesome/fontawesome-free/css/all.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css') }}">
    <link href="{{ asset('assets/css/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    @yield('page_css')
    <!-- Template CSS -->
    <link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css">
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/components.css')}}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/leaflet.css') }}"  crossorigin=""/>

</head>
<body>
<div id="app" class="appPublic">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            <img class="navbar-brand-full app-header-logo" src="{{ asset('img/logomapa.svg') }}" width="170"
                alt="mapa">
            <a href="{{ url('/') }}"></a>
            <form class="form-inline mr-auto" action="#">
                <ul class="navbar-nav mr-3">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"></a></li>
                </ul>
            </form>
            <ul class="navbar-nav navbar-right">            
                                
            </ul>     
                   
        </nav>
        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
        <footer class="main-footer">
            @include('layouts.footer')
        </footer>
    </div>
</div>

</body>

<!-- General JS Scripts -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
<!-- JS Libraies -->

<!-- Template JS File -->
<!-- <script src="{{ asset('web/js/stisla.js') }}"></script>
<script src="{{ asset('web/js/scripts.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>-->


<!-- Template JS File -->
<script src="{{ asset('web/js/stisla.js') }}"></script>
<script src="{{ asset('web/js/scripts.js') }}"></script>
<script src="{{ mix('assets/js/profile.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom.js') }}"></script>

<!--  biblioteca para leaflet  -->
<script src="{{ asset('web/js/leaflet.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>


@yield('page_js')   
@stack('page_js')   
<!-- Page Specific JS File -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@include('layouts.flash-message')
</html>
