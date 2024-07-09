@extends('layouts.auth_app')
@section('title')
    Registrarse en seguimiento de huella de carbono
@endsection
@section('content')
<!-- <a href="{{ URL::previous() }}"><i class="fas fa-angle-left"></i> Regresar</a>-->
    <div class="card card-primary card-login">        
        
        <div class="card-body">
            <ul class="nav nav-pills px-3" id="myTab3" role="tablist">
                <li class="nav-item">
                  <a class="nav-link  active show" id="home-tab3" data-toggle="tab" href="#dependencia" role="tab" aria-controls="generales" aria-selected="false">1</a>
                </li>                             
            </ul>
            <form method="POST" class="needs-validation" novalidate="" action="{{ route('registerPublicPost') }}" >
              @csrf
            <div class="tab-content" id="myTabContent2">  
              <div class="tab-pane fade show active" id="dependencia" role="tabpanel" aria-labelledby="home-tab3">
                  <div class="card-header"><h4>¿Dónde trabajas?</h4></div>
                    <div class="row gutters-sm">
                      <div class="col-12 col-md-4 col-lg-4 px-4 text-center">
                        <label class="imagecheck mb-4 text-center">
                          <input name="dependencia" type="radio" value="scjn" class="imagecheck-input"   {{ old('dependencia') == 'scjn' ? 'checked' : '' }}  onclick="handleClick(this);">
                          <figure class="imagecheck-figure">                            
                            <img src="{{ asset('img/logo-scjn.png') }}" alt="logo" width="250px"
                              class="imagecheck-image">
                          </figure>
                        </label>
                      </div>
                      <div class="col-12 col-md-4 col-lg-4 px-4 text-center">
                        <label class="imagecheck mb-4 text-center">
                          <input name="dependencia" type="radio" value="cjf" class="imagecheck-input"  {{ old('dependencia') == 'cjf' ? 'checked' : '' }} onclick="handleClick(this);" >
                          <figure class="imagecheck-figure">
                            <img src="{{ asset('img/logo-cjf.png') }}" alt="logo" width="250px"
                            class="imagecheck-image">
                          </figure>
                        </label>
                      </div>
                      <div class="col-12 col-md-4 col-lg-4 px-4 text-center">
                        <label class="imagecheck mb-4 text-center">
                          <input name="dependencia" type="radio" value="tepjf" class="imagecheck-input"  {{ old('dependencia') == 'tepjf' ? 'checked' : '' }} onclick="handleClick(this);" >
                          <figure class="imagecheck-figure">
                            <img src="{{ asset('img/logo-tepjf.png') }}" alt="logo" width="250px"
                            class="imagecheck-image">
                          </figure>
                        </label>
                      </div>
                      
                      @if ($errors->has('dependencia'))
                        <div class="invalid-feedback">
                          {{ $errors->first('dependencia') }}
                        </div>
                      @endif
                    </div>                                      
              </div>
              <!-- <div class="col-md-12 mt-4">                        
                <div class="form-group">
                  <input class="btn btn-primary btn-lg btn-block" type="submit" value="Siguiente">                        
                </div>
              </div> -->
            </div> 
            </form>   
        </div>
        <div class="col-md-12 mt-4">                        
          <div class="form-group text-muted text-center">
            ¿Cuenta con credenciales de acceso? <a href="{{ route('login') }}">Ingresar </a>
          </div>
        </div>
    </div>
@endsection

@section('page_js')
<script>
    function handleClick(myRadio) {         
      window.location = "{{ route('registrarUsuarioForm') }}"+"/"+  myRadio.value;          
    }
    
    (function ($) {         
      

      document.getElementById('secDomicilio').onclick = function() {
        // access properties using this keyword 
        document.getElementById("home-tab3").classList.remove("active");
        document.getElementById("profile-tab3").classList.add("active");  
        
        document.getElementById("dependencia").classList.remove("active");
        document.getElementById("dependencia").classList.remove("show");

        document.getElementById("tipoUsuario").classList.add("active");
        document.getElementById("tipoUsuario").classList.add("show");
      }            
    }(jQuery));
    
</script>

@stop