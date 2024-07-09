@extends('layouts.auth_app')
@section('title')
    Registrar usuario 
@endsection
@section('content')
    <div class="card card-primary card-registro">
      <div class="card-header py-0 mt-5"><h4>Registrar usuario de {{$dependencia}} por única vez</h4></div>

        <div class="card-body pt-1">          
          @if ($errors->any())
            <div class="alert alert-danger p-0">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
          <div class="col-md-12">                        
            <div class="form-group text-primary mb-0">
              Los campos con  ( <span class="text-danger">*</span> ) son obligatorios
            </div>
          </div>  

          <form method="POST"  class="needs-validation form-registro"  action="{{ route('registrarUsuarioPost') }}" enctype="multipart/form-data">
            @csrf
                <div class="tab-content">  
                  <div class="tab-pane active" id="generales" >
                    <div class="py-0">
                                                                  
                      <div class="row">
                        <div class="form-group col-12">
                            <div class="form-group">
                                <label for="email" class="control-label">Correo electrónico institucional:</label><span
                                        class="text-danger">*</span>
                                <input id="email" type="email"
                                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    placeholder="Ingresa el correo electrónico institucional" name="email" tabindex="6"
                                    value="{{ old('email') }}"
                                    required autofocus>
                              
                                <div class="invalid-feedback">
                                    El correo electrónico es obligatorio, debe ser institucional
                                </div>                        
                            </div>
                        </div>                      
                      </div>
                      <div class="row">
                        <div class="form-group col-md-12 col-12">
                            <div class="form-group">
                                <label for="password" class="control-label">Contraseña (Al menos 8 caracteres, una letra mayúscula, un número sin dígitos consecutivos y un símbolo):<span class="text-danger">*</span></label>
                                <input id="password" type="password"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}"
                                    value ="{{ old('password') }}" placeholder="Contraseña de al menos 8 caracteres" name="password" tabindex="8" required>
                                
                                  <div class="invalid-feedback">
                                    La contraseña es obligatoria y contar con al menos 8 caracteres
                                  </div>
                                
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-12">
                            <div class="form-group">
                                <label for="password_confirmation"
                                    class="control-label">Confirmar Contraseña:</label><span class="text-danger">*</span>
                                <input id="password_confirmation" type="password" placeholder="Confirma la misma contraseña"
                                    class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}"
                                  value ="{{ old('password_confirmation') }}" name="password_confirmation" tabindex="9" required> 
                                  
                                <div class="invalid-feedback">
                                  Debes confirmar la contraseña
                                </div>                          
                            </div>
                        </div>
                      </div>
                      <div class="row" id="divChecks">
                          <div class="form-group col-md-12 col-12 ">
                              <div class="form-check">
                                  <input type="checkbox" class="form-check-input my-2" id="manejoInformacion" name="manejoInformacion" tabindex="32" {{ old('manejoInformacion') == 'on' ? 'checked' : '' }}  required>
                                  <label class="form-check-label"  for="manejoInformacion"> <a href="https://datos-personales.scjn.gob.mx/sites/default/files/avisos-de-privacidad/X_DGPSI_X4_0.pdf" class="text-decoration-underline aviso"> He leído y estoy de acuerdo con el aviso de privacidad de datos personales.</a></label>
                              </div>
                              @if ($errors->has('manejoInformacion'))
                                <div class="invalid-feedback">
                                  {{ $errors->first('manejoInformacion') }}
                                </div>
                              @endif
                          </div>                       
                          <p>
                          Los datos recabados son confidenciales y serán utilizados con fines estadísticos. La confidencialidad y protección de los mismos están garantizadas de conformidad con los estándares establecidos en la Ley General de Protección de Datos Personales en Posesión de Sujetos Obligados.  
                          </p>
                      </div>
                            <div class="col-md-12 mt-4">                        
                              <div class="form-group">
                                <button class="btn btn-primary btn-lg btn-block"  type="submit"  aria-selected="true">Registrar</button>
                              </div>                                                      
                            </div>
                    </div>
                  </div>    
                                          
                  <div class="col-md-12 mt-4">                        
                        <div class="form-group text-muted text-center">
                          ¿Cuenta con credenciales de acceso? <a href="{{ route('login') }}">Ingresar </a>
                        </div>
                  </div>

                </div>
              </div>
            </div>
            </form>
      </div>
    </div>     

@endsection

@section('page_js')

@if ($message = $errors->any())
<script>
    Swal.fire({
       
        icon: 'question',
        title: @json($errors->all()),
        showConfirmButton: false,
        timer: 10500
    })
    console.log(@json($errors));
</script>
@endif

@stop
