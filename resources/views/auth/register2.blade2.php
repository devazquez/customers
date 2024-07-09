@extends('layouts.auth_app')
@section('title')
    Registrar usuario 
@endsection
@section('content')
    <a href="{{ route('registrarPublico') }}"><i class="fas fa-angle-left"></i> regresar</a>
    <div class="card card-primary card-registro">
        <div class="card-header py-0 mt-2"><h4>Registrar usuario de {{$dependencia}}</h4></div>

        <div class="card-body pt-1">
          <ul class="nav nav-pills" id="myTab3" role="tablist">
            <li class="nav-item ">
              <a class="nav-link active show" id="home-tab3" data-toggle="tab" href="#generales" role="tab" aria-controls="generales" aria-selected="false">1</a>
            </li>            
            <li class="nav-item">
              <a class="nav-link" id="contact-tab3" data-toggle="tab" href="#datosTrabajo" role="tab" aria-controls="datosTrabajo" aria-selected="false">2</a>
            </li>
            <li class="nav-item">
              <a id="contact-tab4" data-toggle="tab" href="#datosVeh" role="tab" aria-controls="datosVeh" aria-selected="false" class="nav-link">3</a>
            </li>                        
          </ul>
          <br>
          
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

          <form method="POST" class="needs-validation" novalidate="" action="{{ route('registrarUsuarioPost') }}" enctype="multipart/form-data">
            @csrf
          <div class="tab-content" id="myTabContent2">  
            <div class="tab-pane fade show active" id="generales" role="tabpanel" aria-labelledby="home-tab3">
              <div class="py-0">
                <h4>Datos Generales</h4>
                <div class="row">
                    <div class="form-group col-12">
                      <div class="form-group">
                        <label for="first_name">Nombre:</label><span class="text-danger">*</span>
                        <input id="firstName" type="text"
                          class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                          name="name"
                          tabindex="1" placeholder="Ingresa tu nombre" value="{{ old('name') }}"
                          autofocus required>                                                        
                        <div class="invalid-feedback">
                          El nombre es requerido                                
                        </div>                            
                      </div>
                    </div>
                    <div class="form-group col-md-6 col-12">
                      <label>Primer apellido</label><span class="text-danger">*</span>
                      <input type="text" id="apellido1" name="apellido1" 
                        tabindex="2" placeholder="Ingresa tu primer apellido" 
                        class="form-control{{ $errors->has('apellido1') ? ' is-invalid' : '' }}" 
                        value="{{ old('apellido1') }}" autofocus required>
                       
                      <div class="invalid-feedback">
                        El primer apellido es requerido
                      </div>                       
                    </div>
                    <div class="form-group col-md-6 col-12">
                      <label>Segundo apellido</label>
                      <input type="text" id="apellido2" name="apellido2" 
                        tabindex="3" placeholder="Ingresa tu segundo apellido" 
                        class="form-control{{ $errors->has('apellido2') ? ' is-invalid' : '' }}" 
                        value="{{ old('apellido2') }}" autofocus>                          
                      <div class="invalid-feedback">
                      </div>                          
                    </div>
                </div>
                <div class="row">   
                  <div class="form-group col-12">
                    <label class="form-label">Género</label><span class="text-danger">*</span>
                    <div class="selectgroup  w-100">
                      <label class="selectgroup-item">
                        <input type="radio" name="sexo" name="sexo" value="M" class="selectgroup-input"  
                            {{ old('sexo') == 'M' ? 'checked' : '' }} >
                        <span class="selectgroup-button ">Femenino</span>
                      </label>
                      <label class="selectgroup-item">
                        <input type="radio" tabindex="4" name="sexo" name="sexo" value="H" class="selectgroup-input" 
                            {{ old('sexo') == 'H' ? 'checked' : '' }} >
                          <span class="selectgroup-button " >Masculino</span>
                      </label>                    
                      <label class="selectgroup-item">
                        <input type="radio" name="sexo" name="sexo" value="NB" class="selectgroup-input"  
                            {{ old('sexo') == 'NB' ? 'checked' : '' }} >
                        <span class="selectgroup-button ">No binarie</span>
                      </label>
                      <div class="invalid-feedback">
                        Es un campo requerido
                      </div>                    
                    </div>
                  </div>
                  <div  class="form-group col-lg-4 col-md-4 col-12">
                    <div class="form-group">
                      <label>Año de nacimiento</label><span class="text-danger">*</span>
                      <input type="number" tabindex="5" id="nacimiento" name="nacimiento"  min="1900" max="2024"
                        placeholder="Ingresa su año de nacimiento" 
                        class="form-control{{ $errors->has('nacimiento') ? ' is-invalid' : '' }} nacimiento" 
                        value="{{ old('nacimiento') }}" required>
                      <div class="invalid-feedback">
                        Año de nacimiento válido
                      </div>                        
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="form-group col-12">
                      <div class="form-group">
                          <label for="email">Correo electrónico institucional:</label><span
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
                  <div class="form-group col-md-6 col-12">
                      <div class="form-group">
                          <label for="password" class="control-label">Contraseña (Al menos 8 caracteres)
                              :</label><span
                                  class="text-danger">*</span>
                          <input id="password" type="password"
                              class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}"
                              value ="{{ old('password') }}" placeholder="Contraseña de al menos 8 caracteres" name="password" tabindex="8" required>
                          
                            <div class="invalid-feedback">
                              La contraseña es obligatoria y contar con al menos 8 caracteres
                            </div>
                          
                      </div>
                  </div>
                  <div class="form-group col-md-6 col-12">
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
                
                <div class="col-md-12 mt-4">                        
                  <div class="form-group">
                    <a class="btn btn-primary btn-lg btn-block" id="secDatosTrabajo"  data-toggle="tab" href="#datosTrabajo" role="tab" aria-controls="datosTrabajo" aria-selected="true">Siguiente</a>
                  </div>                                                      
                </div>
              </div>
            </div>    
            <div class="tab-pane fade" id="datosTrabajo" role="tabpanel" aria-labelledby="home-tab3">
                      <div class="py-0">
                        <h4>Datos de Trabajo</h4>
                      </div>
                      <div class="row">
                        <div class="form-group col-12">
                            <label>Edificio de trabajo</label><span class="text-danger">*</span>
                            <select class="form-control"  id="edificio_id" name="edificio_id"  tabindex="17" required>
                              @foreach ($catEdificios as $edificio)
                                <option value="{{ $edificio->id }}" {{ old('edificio_id') == $edificio->id ? 'selected' : '' }}> {{$edificio->edificio }} </option>  
                              @endforeach
                            </select>
                            
                              <div class="invalid-feedback">
                                Debes seleccionar tu edificio laboral
                              </div>
                            
                            
                        </div>
                        <div class="form-group col-md-7 col-7">
                          <label>Área de adscripción</label><span class="text-danger">*</span>
                          <select class="form-control"  id="area_id" name="area_id" tabindex="18" required>
                            <option   value="" > -- </option>  
                            @foreach ($catAreas as $area)
                              <option value="{{$area->id}}" {{ old('area_id') == $area->id ? 'selected' : '' }} > <span> {{$area->area}}: </span> {{ $area->area_completa }} </option>  
                            @endforeach
                          </select>
                          
                            <div class="invalid-feedback">
                              Debes seleccionar tu área de adscripción
                            </div>
                          
                        </div>
                        <div class="form-group  col-md-5 col-5">
                          <label>Número de expediente</label><span class="text-danger">*</span>
                          <input type="text" id="numero_trabajador" name="numero_trabajador" 
                                 placeholder="Ingresa tu No. de expediente" 
                                 class="form-control{{ $errors->has('numero_trabajador') ? ' is-invalid': '' }}"  
                                 value="{{ old('numero_trabajador') }}" tabindex="19" required>
                          
                          
                            <div class="invalid-feedback">
                              El número de expediente es requerido
                            </div>
                          
                        </div>                    
                      </div>                      

                      <div class="col-md-12 mt-4">                        
                        <div class="form-group">
                          <a class="btn btn-primary btn-lg btn-block" id="secDatosVeh"  data-toggle="tab" href="#datosVeh" role="tab" aria-controls="datosVeh" aria-selected="true">Siguiente</a>                                                                                
                        </div>
                      </div>
            </div>
            <div class="tab-pane fade" id="datosVeh" role="tabpanel" aria-labelledby="home-tab3">          
              <div class="py-0">
                <h4>Datos de casa</h4>                
              </div>
              <div class="row">   
                <div class="form-group  col-12 range-slider">
                  <label for="customRange2 d-block">¿Con cuántas personas compartes tu casa? </label><span class="text-danger">*</span>
                  <br>
                  <input class="range-slider__range range-hc" type="range" name="personascasa" value="0" min="0" max="20" required>
                  <span class="range-slider__value">0</span>
                  <div class="invalid-feedback">
                    Es un campo requerido
                  </div>    
                </div>
              </div>
              <div class="row">   
                <div class="form-group col-12">
                  <label class="form-label">¿Qué tipo de gas usas en tu casa? </label><span class="text-danger">*</span>
                  <div class="selectgroup  w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="gascasa" name="gascasa" value="LP" class="selectgroup-input"  
                          {{ old('gascasa') == 'LP' ? 'checked' : '' }} >
                      <span class="selectgroup-button ">Gas LP</span>
                    </label>
                    <label class="selectgroup-item">
                      <input type="radio" tabindex="4" name="gascasa" name="gascasa" value="N" class="selectgroup-input" 
                          {{ old('gascasa') == 'N' ? 'checked' : '' }} >
                        <span class="selectgroup-button " >Gas natural</span>
                    </label>                                          
                    <div class="invalid-feedback">
                      Es un campo requerido
                    </div>                    
                  </div>
                </div>                  
              </div>
                                                                       
              <div class="card-header mb-1 pl-0 pb-0">
                <p class="mb-0"><b> Bajo protesta de decir verdad, por favor confirme lo siguiente: <span class="text-danger">*</span></b></p>
              </div>
              <div class="row" id="divChecks">
                          <div class="form-group col-md-12 col-12 ">
                              <div class="form-check">
                                  <input type="checkbox" class="form-check-input" id="manejoInformacion" name="manejoInformacion" tabindex="32" {{ old('manejoInformacion') == 'on' ? 'checked' : '' }}  required>
                                  <label class="form-check-label" for="manejoInformacion"> <a href="#"> He leído y estoy de acuerdo con el aviso de privacidad de datos personales.</a></label>
                              </div>
                              @if ($errors->has('manejoInformacion'))
                                <div class="invalid-feedback">
                                  {{ $errors->first('manejoInformacion') }}
                                </div>
                              @endif
                          </div>                       
              </div>
              <div class="col-md-12 mt-4">                        
                        <div class="form-group">
                          <button type="submit" class="btn btn-success btn-lg btn-block" tabindex="">
                              Registrar
                          </button>
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
<script src="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.umd.js"></script>
<script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
<script>
    (function ($) { 
      


      

      document.getElementById('home-tab3').onclick = function() {
        
        document.getElementById("generales").classList.add("active");
        document.getElementById("generales").classList.add("show");
        document.getElementById("datosTrabajo").classList.remove("active");
        document.getElementById("datosTrabajo").classList.remove("show");
        document.getElementById("datosVeh").classList.remove("active");
        document.getElementById("datosVeh").classList.remove("show");
      }
      

      document.getElementById('secDatosTrabajo').onclick = function() {
        
        // access properties using this keyword 
        document.getElementById("home-tab3").classList.remove("active");
        document.getElementById("home-tab3").classList.remove("show");
        document.getElementById("contact-tab4").classList.remove("active");
        document.getElementById("contact-tab4").classList.remove("show");
        
        document.getElementById("generales").classList.remove("active");
        document.getElementById("generales").classList.remove("show");

        document.getElementById("contact-tab3").classList.add("active");
        document.getElementById("contact-tab3").classList.add("show");
        
        document.getElementById("datosTrabajo").classList.add("active");
        document.getElementById("datosTrabajo").classList.add("show");
      }

      document.getElementById('secDatosVeh').onclick = function() {
        // access properties using this keyword 
        document.getElementById("contact-tab3").classList.remove("active");
        document.getElementById("contact-tab4").classList.add("active");

        document.getElementById("datosTrabajo").classList.remove("active");
        document.getElementById("datosTrabajo").classList.remove("show");

        document.getElementById("datosVeh").classList.add("active");
        document.getElementById("datosVeh").classList.add("show");
      }           
      
      $(document).on('submit', ".needs-validation", function (event) {
        var form = $(this);
        if (form[0].checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
          Swal.fire({          
            icon: 'warning',
            title: "Revisar los posibles errores entre las secciones del formulario",
            showConfirmButton: false,
            timer: 10500
          })
        }
        form.addClass('was-validated');
      });
    
      var rangeSlider = function(){
      var slider = $('.range-slider'),
          range = $('.range-slider__range'),
          value = $('.range-slider__value');    
        slider.each(function(){
        value.each(function(){
          var value = $(this).prev().attr('value');
          $(this).html(value);
        });

        range.on('input', function(){
            $(this).next(value).html(this.value);
          });
        });
      };

    rangeSlider();
    }(jQuery));   
    
      
</script>


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
