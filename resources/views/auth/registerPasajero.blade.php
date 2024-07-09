@extends('layouts.auth_app')
@section('title')
    Registrar usuario Pasajero
@endsection
@section('content')
    <a href="/"><i class="fas fa-angle-left"></i> regresar</a>
    <div class="card card-primary card-registro">
        <div class="card-header mt-2"><h4>Registrar usuario pasajero </h4></div>

        <div class="card-body pt-1">
          <ul class="nav nav-pills" id="myTab3" role="tablist">
            <li class="nav-item">
              <a class="nav-link active show" id="profile-tab3" data-toggle="tab" href="#domicilio" role="tab" aria-controls="domicilio" aria-selected="true">1</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="home-tab3" data-toggle="tab" href="#generales" role="tab" aria-controls="generales" aria-selected="false">2</a>
            </li>            
            <li class="nav-item">
              <a class="nav-link" id="contact-tab3" data-toggle="tab" href="#datosTrabajo" role="tab" aria-controls="datosTrabajo" aria-selected="false">3</a>
            </li>
             <li class="nav-item">
              <a class="btn  btn-secondary ml-3" href="javascript:void(0);" onclick="startIntro();">Ayuda</a>
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
            <form method="POST" class="needs-validation" novalidate="" action="{{ route('registrarPasajeroPost') }}" enctype="multipart/form-data">
                @csrf
          <div class="tab-content" id="myTabContent3"> 
            <div class="tab-pane fade show active" id="domicilio" role="tabpanel" aria-labelledby="home-tab3">                      
              <div class="text-center py-0">
                <h4>¿De dónde sales?</h4>
              </div>
              <input type="hidden" id="calle" name="calle" placeholder="Ingresa la calle y número exterior" 
                class="form-control{{ $errors->has('calle') ? ' is-invalid': '' }}" 
                value="{{ old('calle') }}" tabindex="12" >
              <input type="hidden" id="colonia" name="colonia" 
                placeholder="Ingresa la colonia" 
                class="form-control{{ $errors->has('colonia') ? ' is-invalid': '' }}" 
                value="{{ old('colonia') }}" tabindex="13" >  
              <input type="hidden" id="alcaldia" name="alcaldia" 
                placeholder="Ingresa la alcaldia" 
                class="form-control{{ $errors->has('alcaldia') ? ' is-invalid': '' }}"  
                value="{{ old('alcaldia') }}" tabindex="14" > 
              <input type="hidden" id="entidad_federativa" name="entidad_federativa" 
                placeholder="Ingresa la entidad federativa" 
                class="form-control{{ $errors->has('entidad_federativa') ? ' is-invalid': '' }}"  
                value="{{ old('entidad_federativa') }}" tabindex="15" >
              <input type="hidden" id="codigo_postal" name="codigo_postal"  
                placeholder="Ingresa el código postal" 
                class="form-control{{ $errors->has('codigo_postal') ? ' is-invalid': '' }}"  
                value="{{ old('codigo_postal') }}"  tabindex="16"  >
              <div class="form-group col-md-6 col-12">
                  <input type="hidden" id="ubicacion_domicilio"  name="ubicacion_domicilio" class="form-control" value="">                          
                  <div class="invalid-feedback">
                  La ubicación de lugar de interés recurrente es requerida
                  </div>                          
              </div>                       

              <!-- Seccion del mapa -->
                  <!-- Mapa openstreetmap-->                                        
                  <div class="form-group col-12 px-0"> 
                    <label>Para elegir tu punto de partida.<span class="text-danger">*</span> <br> Arrastra el mapa con el dedo para buscar una zona de tu interés, haz zoom y cuando encuentres el lugar da clic/toca una vez en el mapa. <br> Elige un punto cercano a tu domicilio que sea conocido y común para las personas que viven cerca, por ejemplo: parques, plazas, centros comerciales, monumentos, etc.</label>
                    <div class="row">
                            <input id="search" name="search" style="width: 70%;" class="form-control" type="text" placeholder="Ubica tu lugar recurrente de partida" value="{{ old('search') }}" >
                            <button type="button" class="ml-2 btn btn-primary" id="search-button">Buscar</button>
                            <div class="invalid-feedback" role="alert">
                                Ubica el lugar de tu interés recurrente
                            </div>
                    </div>
                    <div class="col-12 resultBuscadorMap mt-1" id="resultBuscadorMap">  
                        <ul id="result-list" class="list-group">
                        </ul>        
                    </div>
                  </div>
                  <div class="form-group col-12">                                             
                    <div id="map-container" style="height:400px;"></div>                                                                                                                                                                                  
                  </div>
                  <!-- Fin del openstreetmap -->
              <!-- Fin de seccion de mapa-->


              <div class="col-md-12 mt-4">                        
                <div class="form-group">                  
                  <a class="btn btn-primary btn-lg btn-block" id="secGenerales"  data-toggle="tab" href="#generales" role="tab" aria-controls="datosTrabajo" aria-selected="true">Siguiente</a>
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
      
    
     
    /*
        Busqueda usando mapa
        */
        const searchInput = document.getElementById('search');
        const resultList = document.getElementById('result-list');
        const mapContainer = document.getElementById('map-container');
        const currentMarkers = [];

        const map = L.map(mapContainer).setView([19.43295,-99.13328], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        document.getElementById('search-button').addEventListener('click', () => {
            const query = searchInput.value + ', México';
            //console.log(query);
            fetch('https://nominatim.openstreetmap.org/search?format=json&polygon=1&addressdetails=1&q=' + query)
                .then(result => result.json())
                .then(parsedResult => {
                    setResultList(parsedResult);
                });
        });
        
        map.on('click', function(e) {
            //alert("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng + ",  ");
            console.log(e);
            fetch('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat='+e.latlng.lat +'&lon='+e.latlng.lng)
                .then(result => result.json())
                .then(parsedResult => {
                    for (const marker of currentMarkers) {
                      map.removeLayer(marker);
                    }
                    resultList.innerHTML="";
                    const position = new L.LatLng(parsedResult.lat, parsedResult.lon);
                    currentMarkers.push(new L.marker(position).addTo(map));
                    const li = document.createElement('li');
                    console.log( parsedResult.lat  + ", " + parsedResult.lon);
                    for(const child of resultList.children) {
                          child.classList.remove('active');
                    }
                    li.classList.add('list-group-item', 'list-group-item-action','active');
                    let cad = JSON.stringify({
                      displayName: parsedResult.display_name,
                      lat: parsedResult.lat,
                      lon: parsedResult.lon
                    }, undefined, 10);
                    li.innerHTML = parsedResult.display_name + "<span class='d-none'>"+ cad +"</span>";
                    resultList.prepend(li);
                    var elem = document.getElementById('resultBuscadorMap');
                    elem.scrollTop = 0;
                    
                    li.addEventListener('click', (event) => {
                      for(const child of resultList.children) {
                          child.classList.remove('active');
                      }
                      event.target.classList.add('active');
                      const clickedData = JSON.parse(event.target.querySelector('span').innerHTML);
                      document.getElementById("codigo_postal").setAttribute('value', parsedResult['address']['postcode'] );
                      document.getElementById("calle").setAttribute('value', parsedResult['address']['road'] );
                      document.getElementById("colonia").setAttribute('value', parsedResult['address']['highway'] );
                      document.getElementById("alcaldia").setAttribute('value', parsedResult['address']['neighbourhood'] );
                      document.getElementById("entidad_federativa").setAttribute('value', parsedResult['address']['city'] );                    
                      document.getElementById("ubicacion_domicilio").setAttribute('value', clickedData.lat  + ", " + clickedData.lon);                    
                      Swal.fire(parsedResult.display_name);                      
                      //const clickedData = JSON.parse(event.target.innerHTML);
                      const position = new L.LatLng(clickedData.lat, clickedData.lon);
                      map.flyTo(position, 16);
                    })
                    

                    //alert(parsedResult.display_name);
                    Swal.fire(parsedResult.display_name);
                    //console.log(parsedResult.display_name);
                    //console.log(parsedResult['address']['road'] );
                    document.getElementById("codigo_postal").setAttribute('value', (parsedResult['address']['postcode'] == undefined ? "":parsedResult['address']['postcode']) );
                    document.getElementById("calle").setAttribute('value', (parsedResult['address']['road'] == undefined ? "": parsedResult['address']['road']));
                    document.getElementById("colonia").setAttribute('value', ( parsedResult['address']['highway'] == undefined ? "":  parsedResult['address']['highway']));
                    document.getElementById("alcaldia").setAttribute('value', (parsedResult['address']['neighbourhood'] == undefined? "": parsedResult['address']['neighbourhood']));
                    document.getElementById("entidad_federativa").setAttribute('value', (parsedResult['address']['city'] == undefined ?"": parsedResult['address']['city'] ));
                    document.getElementById("ubicacion_domicilio").setAttribute('value', parsedResult.lat  + ", " + parsedResult.lon);

            });
        });
        
        function setResultList(parsedResult) {
            resultList.innerHTML = "";
            for (const marker of currentMarkers) {
                map.removeLayer(marker);
            }
            if (parsedResult.length === 0) {
                const li = document.createElement('li');
                li.classList.add('list-group-item','alert', 'alert-danger');
                li.innerHTML = "Sin resultado, favor de volver a buscar";   
                resultList.appendChild(li);                             
            }
            
            map.flyTo(new L.LatLng(19.4326296, -99.1331785), 6);
            for (const result of parsedResult) {
                const li = document.createElement('li');
                li.classList.add('list-group-item', 'list-group-item-action');
                let cad = JSON.stringify({
                    displayName: result.display_name,
                    lat: result.lat,
                    lon: result.lon
                }, undefined, 10);
                li.innerHTML = result.display_name + "<span class='d-none'>"+ cad +"</span>";
                li.addEventListener('click', (event) => {
                    for(const child of resultList.children) {
                        child.classList.remove('active');
                    }
                    event.target.classList.add('active');
                    const clickedData = JSON.parse(event.target.querySelector('span').innerHTML);
                    document.getElementById("codigo_postal").setAttribute('value', result['address']['postcode'] );
                    document.getElementById("calle").setAttribute('value', result['address']['road'] );
                    document.getElementById("colonia").setAttribute('value', result['address']['highway'] );
                    document.getElementById("alcaldia").setAttribute('value', result['address']['neighbourhood'] );
                    document.getElementById("entidad_federativa").setAttribute('value', result['address']['city'] );                    
                    document.getElementById("ubicacion_domicilio").setAttribute('value', result.lat + ", "+result.lon);                    
                    Swal.fire(result.display_name);
                    //const clickedData = JSON.parse(event.target.innerHTML);
                    const position = new L.LatLng(clickedData.lat, clickedData.lon);
                    map.flyTo(position, 16);
                })
                const position = new L.LatLng(result.lat, result.lon);
                currentMarkers.push(new L.marker(position).addTo(map));
                resultList.appendChild(li);
            }
        }
        // Fin de busqueda de mapa


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
<script type="text/javascript">

  searchInput = document.getElementById('search');
  resultList = document.getElementById('result-list');
  mapContainer = document.getElementById('map-container');
  currentMarkers = [];
  let viajesIdaMarkers; 
   // Agregar los markers de los viajes compartidos de ida        
  
  let ubiPartida;
  let arrUbiPartida;
  let markers = new Array();
  let ubiText ="";
  let ubiText2 ="";


  function setResultList(parsedResult) {            
    resultList.innerHTML = "";
    let cnt = 1;
    for (const result of parsedResult) {
        const li = document.createElement('li');
        li.classList.add('list-group-item', 'list-group-item-action', 'ubi-'+cnt );
        li.setAttribute('id', 'ubi-'+cnt);
        if(cnt == 1){
          ubiText = result.display_name;
        }
        ubiText2 = result.display_name;
        cnt++;
        let cad = JSON.stringify({
            displayName: result.display_name,
            lat: result.lat,
            lon: result.lon
        }, undefined, 10);
        li.innerHTML = result.display_name + "<span class='d-none'>"+ cad +"</span>";
        resultList.appendChild(li);
    }
  }
  
  function refreshPage() {                             
    window.location.reload();                     
  }
  function startIntro(){
    let opciones2 = {
            nextLabel: 'Siguiente', prevLabel: 'Anterior', doneLabel: 'Hecho',  skipLabel: 'X', 
            steps: [
              {
                    intro: "Crear una cuenta como usuario pasajero (Obs. esta cuenta no permite crear viajes compartidos, solo participar como pasajero)."
                },
                {
                  element: document.querySelector('#profile-tab3'),
                  intro: "Información y selección de la ubicación recurrente del usuario",  
                },           
                {
                  element: document.querySelector('#searchDiv'),
                  intro: "Buscar una ubicación recurrente. Se recomienda una ubicación pública como un parque, centro comercial, etc.",
                  busquedaUbicacion: function() { 
                    document.getElementById("search").setAttribute('value', 'Walmart, Gustavo A. Madero, Ciudad de México'); 
                  }
                },   
                {
                  element: '#search-button',
                  intro: 'Elige un punto cercano a tu domicilio que sea conocido y común para las personas que viven cerca, por ejemplo: parques, plazas, centros comerciales, monumentos, etc',
                  position: 'left',
                  btnBusqueda: function() { 
                      const query = document.getElementById("search").value+ ', México';
                      fetch('https://nominatim.openstreetmap.org/search?format=json&polygon=1&addressdetails=1&q=' + query)
                          .then(result => result.json())
                          .then(parsedResult => {
                              setResultList(parsedResult);                        
                      });                     
                    },
                },
                {
                  element: '#result-list',
                  intro: "Lista de ubicaciones que resultaron de la búsqueda",
                  position: 'bottom'
                },
                {
                element: document.querySelector(".swal2-container"),
                intro: "Al seleccionar una ubicacion se despliega la dirección en una ventana emergente.",
                position: 'center',                        
                selectElement: function(){
                    Swal.fire(ubiText);
                }
              },
              {
                element: "#map-container",
                intro: "Se agrega icono indicador de la ubicación en el mapa.",
                position: 'bottom',
                selectElement: function(){
                  swal.close();
                }
              },
              {
                element: "#map-container",
                intro: "Se pueden emplear gestos sobre el mapa para seleccionar una nueva ubicación, tocando o dando clic sobre la ubicación.",
                position: 'center',
              },
              {
                element: document.querySelector(".swal2-container"),
                intro: "Al seleccionar una ubicacion se despliega la dirección en una ventana emergente",
                position: 'bottom',
                selectElement: function(){
                  Swal.fire(ubiText2);
                }
              },
              {
                element: document.querySelector('#home-tab3'),
                intro: "Sección para los datos generales del usuario",
                secGen: function() { 
                    swal.close();
                    document.getElementById("profile-tab3").classList.remove("active");  
                    document.getElementById("home-tab3").classList.add("active");
                    document.getElementById("domicilio").classList.remove("active");
                    document.getElementById("domicilio").classList.remove("show");
                    document.getElementById("generales").classList.add("active");
                    document.getElementById("generales").classList.add("show");  
                },
              },           
              {
                element: "#generales",
                intro: "Se agregan los datos de información general del usuario: Nombre, apellidos, sexo, fecha de nacimiento, etc, así como los  datos de acceso: correo electrónico y contraseña", 
              },
              {
                element: "#email",
                intro: "Se ingresa el correo institucional", 
              },
              {
                element: "#password",
                intro: "Se ingresa una contraseña de al  menos 8 caracteres. Para mayor seguridad se recomienda emplear: mayúsculas, minúsculas y números", 
              },
              {
                element: "#password_confirmation",
                intro: "Se confirma la contraseña para corregir errores en el registro.", 
              },
              {
                element: "#foto",
                intro: "Para la fotografía del usuario. Subir una imagen en formato JPG, JPEG o PNG, con un tamaño máximo de 2MB.", 
              },
              {
                element: "#credencial",
                intro: "Para la credencial del usuario. Subir una imagen en formato JPG, JPEG o PNG, con un tamaño máximo de 2MB.", 
              },

              {
                element: document.querySelector('#contact-tab3'),
                intro: "Sección para los datos laborales del usuario.",
                secGen: function() { 
                    document.getElementById("home-tab3").classList.remove("active");  
                    document.getElementById("contact-tab3").classList.add("active");
                    document.getElementById("generales").classList.remove("active");
                    document.getElementById("generales").classList.remove("show");  
                    document.getElementById("datosTrabajo").classList.add("active");
                    document.getElementById("datosTrabajo").classList.add("show");                  
                },
              },  
              {
                element: "#datosTrabajo",
                intro: "Se puede editar la información del lugar de trabajo del usuario: Edificio laboral, área de adscripción, hora de entrada y salida habituales.", 
              },
              {
                element: "#numero_trabajador",
                intro: "Se ingresa el número de expediente proporcionado por su dependencia laboral.", 
              },             
              {
                element: ".btn-success",
                intro: "Botón para enviar el formulario y crear usuario.", 
              },         
            ]
    }
    
    //search-button
    let intro = introJs();  
    //console.log("{{$tipoUsuario}}");
    intro.setOptions(opciones2);
    //intro.setOptions(opciones1);
    intro.onbeforechange(function(){ 
          // check to see if there is a function on this step 
          if(this._introItems[this._currentStep].busquedaUbicacion){
          this._introItems[this._currentStep].busquedaUbicacion();
        };           
        if(this._introItems[this._currentStep].btnBusqueda){
          this._introItems[this._currentStep].btnBusqueda();
        };
        if(this._introItems[this._currentStep].selectElement){
          this._introItems[this._currentStep].selectElement();
        };
        if(this._introItems[this._currentStep].secGen){
            this._introItems[this._currentStep].secGen();
        };                
        if(this._introItems[this._currentStep].secDatVeh){
            this._introItems[this._currentStep].secDatVeh();
        };
        if(this._introItems[this._currentStep].secDivAgregaV2){
            this._introItems[this._currentStep].secDivAgregaV2();
        };
        
        if(this._introItems[this._currentStep].secFoto){
            this._introItems[this._currentStep].secFoto();
        };
        if(this._introItems[this._currentStep].secFoto2){
            this._introItems[this._currentStep].secFoto2();
        }; 
        if(this._introItems[this._currentStep].secCred){
            this._introItems[this._currentStep].secCred();
        };  
        if(this._introItems[this._currentStep].secCred2){
            this._introItems[this._currentStep].secCred2();
        }; 
        }).onchange(function() {  //intro.js built in onchange function
            if (this._introItems[this._currentStep].myChangeFunction){
                this._introItems[this._currentStep].myChangeFunction();
            }
    }).start();
    intro.oncomplete(refreshPage);
    intro.onexit(refreshPage);
    //intro.start();            
  }
  
</script>
@stop