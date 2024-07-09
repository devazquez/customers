@extends('layouts.auth_app')
@section('title')
    Ingresar a huella de carbono
@endsection
@section('content')
<!-- <a href="{{ URL::previous() }}"><i class="fas fa-angle-left"></i> Regresar</a>-->
    <div class="card card-primary card-login">        
        <div class="card-header mt-2"><h4>Iniciar Sesión</h4></div>
        <div class="form-group text-muted text-center mt-3">
            <a href="{{ route('registrarUsuarioForm', 'scjn') }}" style="font-size:18px;">Registrarse como usuario SCJN por única vez</a>
        </div> 
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger p-0">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label for="email" class="control-label" style="font-size:14px">Usuario</label>
                    <input aria-describedby="emailHelpBlock" id="email" type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                           placeholder="Ingresa tu correo electrónico institucional" tabindex="1"
                           value="{{ (Cookie::get('email') !== null) ? Cookie::get('email') : old('email') }}" autofocus
                           required>
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label" style="font-size:14px">Contraseña</label>
                       
                    </div>
                    <input aria-describedby="passwordHelpBlock" id="password" type="password"
                           value="{{ (Cookie::get('password') !== null) ? Cookie::get('password') : null }}"
                           placeholder="Ingresa tu contraseña"
                           class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" name="password"
                           tabindex="2" required>
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                </div>
                
                <div class="float-right">
                    <a href="{{ route('password.request') }}" class="text-small">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
                
                <div class="form-group w-50">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                               id="remember"{{ (Cookie::get('remember') !== null) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">Recordar sesión</label>
                    </div>
                    
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg btn-block btn-login-ingresar" tabindex="4">
                        Ingresar
                    </button>
                </div>
                                             
            </form>
        </div>
    </div>
@endsection


@section('page_js')
<script>
    
    //window.onbeforeunload = function() { return "You must login"; };
    /*
    window.addEventListener("beforeunload", function (e) {
        $.ajax({
            url:'{{ route('logout') }}',
            method:'get',
            success: function(){
                console.log("cookie deleted");
            }
        });
    });
    */
   
    function nobackbutton(){
        window.location.hash="no-back-button";
        window.location.hash="Again-No-back-button"
        window.onhashchange=function(){window.location.hash="no-back-button";}   
    }
      
</script>


@stop