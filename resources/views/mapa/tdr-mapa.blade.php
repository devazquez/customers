@extends('layouts.appPublic')

@section('content')
<span class="uisheet screen-darken"></span>
 
<section class="der-lab-trabajadores  w-100 p-0 my-3 col col-md-12 col-lg-12 col-12 mx-auto">
    <div class="row w-100 p-0 col-12 my-3">
        <div class="list-group" id="result-list">
        </div>
        <!--
        <div class="w-100 vozlaboral-mapa_map-filter-big">
                <form class ="w-100" action="#">
                        <label for="filter_type-presentados">
                            <div class="big-numbers">
                                <div><img decoding="async" class="w-100" src="{{ asset('img/casos-presentados-icon.svg') }}" alt=""></div>
                                <div>
                                    <span id="valPresentados">{{ count($cclsUbicaciones) }}</span>
                                    <h5>Casos presentados</h5>
                                </div>
                                
                            </div>
                            <div class="radio-botones my-2">
                                <input id="filter_type-presentados" class="form-check-input" type="radio" name="filtro_map" value="presentados" checked="">
                                <span class=""></span>
                            </div>
                            
                        </label>
                        <label for="filter_type-activos">
                            <div class="big-numbers">
                                <div><img decoding="async"   class="w-100" src="{{ asset('img/casos-activos-icon.svg') }}"  alt=""></div>
                                <div>
                                    <span id="valActivos">{{ $cclsUbicaciones->where("estatus", "Activo")->count() }}</span>
                                    <h5>Activos</h5>
                                </div>
                            </div>
                            <div class="radio-botones my-2">
                                <input id="filter_type-activos" class="form-check-input" type="radio" name="filtro_map" value="Activo">
                                <span class=""></span>
                            </div>
                        </label>
                        <label for="filter_type-cerrados">
                            <div class="big-numbers">
                                <div><img decoding="async" class="w-100" src="{{ asset('img/casos-cerrados-icon.svg') }}" alt=""></div>
                                <div>
                                    <span id="valCerrados">{{ $cclsUbicaciones->where("estatus", "Cerrado")->count() }}</span>
                                    <h5>Cerrados</h5>
                                </div>
                            </div>
                            <div class="radio-botones my-2">
                                <input id="filter_type-cerrados"  class="form-check-input" type="radio" name="filtro_map" value="Cerrado">
                                <span class=""></span>
                            </div>
                        </label>
                        <label for="filter_type-paneles">
                            <div class="big-numbers">
                                <div><img decoding="async" class="w-100" src="{{ asset('img/casos-paneles-icon.svg') }}"  alt=""></div>
                                <div>
                                    <span id="valPaneles">{{ $cclsUbicaciones->where("estatus", "Panel")->count() }}</span>
                                    <h5>Paneles</h5>
                                </div>
                            </div>
                            <div class="radio-botones my-2">
                                <input id="filter_type-paneles" class="form-check-input" type="radio" name="filtro_map" value="Panel">
                                <span class=""></span>                          
                            </div>
                        </label>
                        <label for="filter_type-fecha">
                            <div class="big-numbers fechas">
                                <div><img decoding="async" class="w-100" src="{{ asset('img/icon-date.svg') }}" alt=""></div>
                                <div>
                                    <h5>Por Fecha</h5>
                                </div>
                            </div>
                            <div>
                                <div> 
                                    <span >  De: </span>
                                    <input  type="date" id="filter_type-fecha" name="date" min="{{ ($cclsUbicaciones->where('fecha_estatus')->first())->fecha_estatus}}"  max="{{ ($cclsUbicaciones->where('fecha_estatus')->last())->fecha_estatus}}" value="{{ ($cclsUbicaciones->where('fecha_estatus')->first())->fecha_estatus }}"> 
                                </div>
                                <div class="mt-2" > 
                                    <span class="pl-2 ml-1"> a: </span>
                                    <input  type="date"  id="filter_type-fecha2" name="date2" min="{{ ($cclsUbicaciones->where('fecha_estatus')->first())->fecha_estatus}}" max="{{ ($cclsUbicaciones->where('fecha_estatus')->last())->fecha_estatus}}" value="{{($cclsUbicaciones->where('fecha_estatus')->last())->fecha_estatus}}">                           
                                </div>
                            </div>
                        </label>
                    </form>
            </div>
        <div class="col-12 p-0">      
        -->
        <div class="w-100 ">
            <!--
            <form class="w-100 filter-grid pantallasGrandes" action="#">
                <label for="filter_type-presentados" class="filter-label">
                    <div class="big-numbers">
                        <div class="filter-img">
                            <img decoding="async"  class="w-100" src="{{ asset('img/casos-presentados-icon.svg') }}" alt="">
                        </div>
                        <div class="filter-texto">
                            <span id="valPresentados">{{ count($cclsUbicaciones) }}</span>
                            <h5>Casos presentados</h5>
                        </div>
                    </div>
                    <div class="radio-botones">
                        <input id="filter_type-presentados" class="form-check-input"  type="radio" name="filtro_map" value="presentados" >
                        <span></span>
                    </div>
                </label>
                <label for="filter_type-activos" class="filter-label">
                    <div class="big-numbers">
                        <div class="filter-img">
                            <img decoding="async"  class="w-100" src="{{ asset('img/casos-activos-icon.svg') }}" alt="">
                        </div>
                        <div class="filter-texto">
                            <span id="valActivos">{{ $cclsUbicaciones->where("estatus", "Activo")->count() }}</span>
                            <h5>Paneles activos</h5>                            
                        </div>
                    </div>
                    <div class="radio-botones">
                        <input id="filter_type-activos" class="form-check-input"  type="radio" name="filtro_map" value="Activo" >
                        <span class=""></span>
                    </div>
                </label>
                <label for="filter_type-cerrados" class="filter-label">
                    <div class="big-numbers">
                        <div class="filter-img">    
                            <img decoding="async"  class="w-100" src="{{ asset('img/casos-cerrados-icon.svg') }}" alt="">
                        </div>
                        <div class="filter-texto">
                            <span id="valCerrados">{{ $cclsUbicaciones->where("estatus", "Cerrado")->count() }}</span>
                            <h5>Cerrados</h5>                            
                        </div>
                    </div>
                    <div class="radio-botones">
                        <input id="filter_type-cerrados" class="form-check-input"  type="radio" name="filtro_map" value="Cerrado" >
                        <span class=""></span>
                    </div>
                </label>
                <label for="filter_type-paneles" class="filter-label">
                    <div class="big-numbers">
                        <div class="filter-img">
                            <img decoding="async" class="w-100" src="{{ asset('img/casos-paneles-icon.svg') }}" alt="">
                        </div>
                        <div class="filter-texto">
                            <span id="valPaneles">{{ $cclsUbicaciones->where("estatus", "Panel")->count() }}</span>
                            <h5>Paneles</h5>                            
                        </div>
                    </div>
                    <div class="radio-botones">
                        <input id="filter_type-paneles" class="form-check-input"  type="radio" name="filtro_map" value="Panel" >
                        <span class=""></span>
                    </div>
                </label>
               
                <label for="filter_type-fecha" class="filter-label labelFechas">
                    <div class="big-numbers fechas">
                        <div class="filter-img">
                            <img decoding="async"  class="w-100" src="{{ asset('img/icon-date.svg') }}" alt="">
                        </div>
                        <div class="filter-texto">
                            <h5>Por Fecha</h5>                            
                        </div>
                    </div>
                    <div class="divsFechas">
                        <div> 
                            <span >  De: </span>
                            <input  type="date" id="filter_type-fecha" name="date" min="{{ ($cclsUbicaciones->where('fecha_estatus')->first())->fecha_estatus}}"  max="{{ ($cclsUbicaciones->where('fecha_estatus')->last())->fecha_estatus}}" value="{{ ($cclsUbicaciones->where('fecha_estatus')->first())->fecha_estatus }}"> 
                        </div>
                        <div class="mt-2" > 
                            <span class="pl-2 ml-1"> a: </span>
                            <input  type="date"  id="filter_type-fecha2" name="date2" min="{{ ($cclsUbicaciones->where('fecha_estatus')->first())->fecha_estatus}}" max="{{ ($cclsUbicaciones->where('fecha_estatus')->last())->fecha_estatus}}" value="{{($cclsUbicaciones->where('fecha_estatus')->last())->fecha_estatus}}">                           
                        </div>
                    </div>
                </label>                                
            </form>-->

            <!-- -->
            
            <div class="containerFiltros vozlaboral-mapa_map-filter-big">
                
                <div class="filter-grid  pantallasGrandes row row-cols-1 row-cols-md-5"> 
                    <div class="col ">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-filter-img">
                                        <!-- <img decoding="async" src="{{ asset('img/casos-presentados-icon.svg') }}" alt="">-->
                                        <img decoding="async" src="https://dev.vozlaboral.mx/wp-content/themes/divi-child/images/casos-presentados-icon.svg" alt="">
                                    </div>
                                    <div class="filter-texto">
                                        <span id="valPresentados">{{ count($cclsUbicaciones) }}</span>
                                        <h5>Casos presentados</h5>
                                    </div>                                                       
                                    
                                </div>
                                <div class="card-footer">
                                    <div class="radio-botones">
                                        <input id="filter_type-presentados" class="form-check-input"  type="radio" name="filtro_map" value="presentados" >
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col " >
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-filter-img">
                                        <!-- <img decoding="async" src="{{ asset('img/casos-activos-icon.svg') }}" alt="">-->
                                        <img decoding="async" src="https://dev.vozlaboral.mx/wp-content/themes/divi-child/images/casos-activos-icon.svg" alt="">
                                    </div>
                                    <div class="filter-texto">
                                        <span id="valActivos">{{ $cclsUbicaciones->where("estatus", "Activo")->count() }}</span>
                                        <h5>Casos  activos</h5>                            
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="radio-botones">
                                        <input id="filter_type-activos" class="form-check-input"  type="radio" name="filtro_map" value="Activo" >
                                        <span class=""></span>
                                    </div>
                                </div>
                            </div>
                    </div>                                        
                    <div class="col ">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-filter-img">    
                                        <!-- <img decoding="async" src="{{ asset('img/casos-cerrados-icon.svg') }}" alt=""> -->
                                        <img decoding="async" src="https://dev.vozlaboral.mx/wp-content/themes/divi-child/images/casos-cerrados-icon.svg" alt="">
                                    </div>
                                    <div class="filter-texto">
                                        <span id="valCerrados">{{ $cclsUbicaciones->where("estatus", "Cerrado")->count() }}</span>
                                        <h5>Cerrados</h5>                            
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="radio-botones">
                                        <input id="filter_type-cerrados" class="form-check-input"  type="radio" name="filtro_map" value="Cerrado" >
                                        <span class=""></span>
                                    </div>
                                </div>
                            </div>
                    </div>                    
                    <div class="col ">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-filter-img">
                                        <!-- <img decoding="async" src="{{ asset('img/casos-paneles-icon.svg') }}" alt=""> -->
                                        <img decoding="async" src="https://dev.vozlaboral.mx/wp-content/themes/divi-child/images/casos-paneles-icon.svg" alt="">
                                    </div>
                                    <div class="filter-texto">
                                        <span id="valPaneles">{{ $cclsUbicaciones->where("estatus", "Panel")->count() }}</span>
                                        <h5>Paneles activos</h5>                            
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="radio-botones">
                                        <input id="filter_type-paneles" class="form-check-input"  type="radio" name="filtro_map" value="Panel" >
                                        <span class=""></span>
                                    </div>
                                </div>
                            </div>
                    </div>                                        
                    <div class="col col-fechas">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-filter-img">
                                        <!-- <img decoding="async" src="{{ asset('img/icon-date.svg') }}" alt=""> -->
                                        <img decoding="async" src="https://dev.vozlaboral.mx/wp-content/themes/divi-child/images/icon-date.svg" alt="">
                                    </div>
                                    <div class="filter-texto">
                                        <h5>Por Fecha</h5>                            
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="divsFechas">
                                    <div> 
                                        <span>de:</span>
                                        <input  type="date" id="filter_type-fecha" name="date" min="{{ ($cclsUbicaciones->where('fecha_estatus')->first())->fecha_estatus}}"  max="{{ ($cclsUbicaciones->where('fecha_estatus')->last())->fecha_estatus}}" value="{{ ($cclsUbicaciones->where('fecha_estatus')->first())->fecha_estatus }}">                                        
                                        
                                    </div>
                                    <div class="mt-2" > 
                                        <span>a:</span>
                                        <input  type="date"  id="filter_type-fecha2" name="date2" min="{{ ($cclsUbicaciones->where('fecha_estatus')->first())->fecha_estatus}}" max="{{ ($cclsUbicaciones->where('fecha_estatus')->last())->fecha_estatus}}" value="{{($cclsUbicaciones->where('fecha_estatus')->last())->fecha_estatus}}">                           
                                    </div>
                                </div>
                            </div>
                    </div>                    
                </div>
                
                <!-- se cierra el div que solo se visualiza en pantallas grandes -->
                <div class="filter-grid pantallasChicas row-cols-md-5"> 
                    <div class="row">
                        <div class="col ">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-filter-img">
                                            <!-- <img decoding="async" src="{{ asset('img/casos-presentados-icon.svg') }}" alt="">-->
                                            <img decoding="async" src="https://dev.vozlaboral.mx/wp-content/themes/divi-child/images/casos-presentados-icon.svg" alt="">
                                        </div>
                                        <div class="filter-texto">
                                            <span id="valPresentados">{{ count($cclsUbicaciones) }}</span>
                                            <h5>Casos <br> presentados</h5>
                                        </div>                                                       
                                        
                                    </div>
                                    <div class="card-footer">
                                        <div class="radio-botones">
                                            <input id="filter_type-presentados" class="form-check-input"  type="radio" name="filtro_map" value="presentados" >
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="col " >
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-filter-img">
                                             <!-- <img decoding="async" src="{{ asset('img/casos-activos-icon.svg') }}" alt="">-->
                                            <img decoding="async" src="https://dev.vozlaboral.mx/wp-content/themes/divi-child/images/casos-activos-icon.svg" alt="">
                                        </div>
                                        <div class="filter-texto">
                                            <span id="valActivos">{{ $cclsUbicaciones->where("estatus", "Activo")->count() }}</span>
                                            <h5>Casos <br> activos</h5>                            
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="radio-botones">
                                            <input id="filter_type-activos" class="form-check-input"  type="radio" name="filtro_map" value="Activo" >
                                            <span class=""></span>
                                        </div>
                                    </div>
                                </div>
                        </div> 
                    </div>                                      
                    <div class="row">
                        <div class="col ">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-filter-img">    
                                            <!-- <img decoding="async" src="{{ asset('img/casos-cerrados-icon.svg') }}" alt=""> -->
                                            <img decoding="async" src="https://dev.vozlaboral.mx/wp-content/themes/divi-child/images/casos-cerrados-icon.svg" alt="">
                                        </div>
                                        <div class="filter-texto">
                                            <span id="valCerrados">{{ $cclsUbicaciones->where("estatus", "Cerrado")->count() }}</span>
                                            <h5>Cerrados</h5>                            
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="radio-botones">
                                            <input id="filter_type-cerrados" class="form-check-input"  type="radio" name="filtro_map" value="Cerrado" >
                                            <span class=""></span>
                                        </div>
                                    </div>
                                </div>
                        </div>                    
                        <div class="col ">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-filter-img">
                                            <!-- <img decoding="async" src="{{ asset('img/casos-paneles-icon.svg') }}" alt=""> -->
                                            <img decoding="async" src="https://dev.vozlaboral.mx/wp-content/themes/divi-child/images/casos-paneles-icon.svg" alt="">
                                        </div>
                                        <div class="filter-texto">
                                            <span id="valPaneles">{{ $cclsUbicaciones->where("estatus", "Panel")->count() }}</span>
                                            <h5>Paneles <br> activos</h5>                            
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="radio-botones">
                                            <input id="filter_type-paneles" class="form-check-input"  type="radio" name="filtro_map" value="Panel" >
                                            <span class=""></span>
                                        </div>
                                    </div>
                                </div>
                        </div>           
                    </div>                             
                    <div class="row">
                        <div class="col ">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-filter-img">
                                            <!-- <img decoding="async" src="{{ asset('img/icon-date.svg') }}" alt=""> -->
                                            <img decoding="async" src="https://dev.vozlaboral.mx/wp-content/themes/divi-child/images/icon-date.svg" alt="">
                                        </div>
                                        <div class="filter-texto">
                                            <h5>Por Fecha</h5>                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer ffechas">
                                    <div class="divsFechas">
                                        <div> 
                                            <span >  De: </span>
                                            <input  type="date" id="filter_type-fechapc" name="date" min="{{ ($cclsUbicaciones->where('fecha_estatus')->first())->fecha_estatus}}"  max="{{ ($cclsUbicaciones->where('fecha_estatus')->last())->fecha_estatus}}" value="{{ ($cclsUbicaciones->where('fecha_estatus')->first())->fecha_estatus }}"> 
                                        </div>
                                        <div class="mt-lg-2 mt-md-2 mt-1" > 
                                            <span class="pl-2 ml-1"> a: </span>
                                            <input  type="date"  id="filter_type-fechapc2" name="date2" min="{{ ($cclsUbicaciones->where('fecha_estatus')->first())->fecha_estatus}}" max="{{ ($cclsUbicaciones->where('fecha_estatus')->last())->fecha_estatus}}" value="{{($cclsUbicaciones->where('fecha_estatus')->last())->fecha_estatus}}">                           
                                        </div>
                                    </div>
                                </div>
                        </div>           
                    </div>         
                </div>
            </div> 
            <!-- -->
        </div>
            <div class="col-12 mapOpenStreetMap p-0 mt-1 justify-content-center w-100 sticky-top"  >                    
                <!-- Mapa openstreetmap-->                                                              
                <div class="form-group col-12">
                    <div id="map-container" class="w-100" style="height:500px; border:1px solid #ccc">
                    </div>                                                                                                                                                                                  
                </div>
                <!-- Fin del openstreetmap -->
            </div>                
            
        </div>
    </div>  

    
    
<div class="modal fade" id="markerModal" tabindex="-1" role="dialog" aria-labelledby="markerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header p-0" id="modal-header">
            <!-- <h5 class="modal-title" id="markerModalLabel">Título</h5>-->            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="modalContent">
            <!-- Se agrega el contenido generado por laravel-->

        </div>
        <div class="modal-footer content info_icons">
            <div class="row icons d-flex justify-content-start w-100">
                <div class="col-md-6">
                    <img class="navbar-brand-full app-header-logo" src="{{ asset('img/logomapa.svg') }}" width="190" alt="mapa">
                </div>
                
                <div id ="mailtobtn" class="col-md-1 col-2 px-0" style="margin-left: auto;">
                    
                </div>
                <div id="xbtn"  class="col-md-1 col-2 px-0">
                    <img src="{{ asset('img/share.png') }}" class="img "/>
                </div>
                <div id="facebtn" class="col-md-1 col-3 px-0">
                    <img src="{{ asset('img/share.png') }}" class="img "/>
                </div>
                <div id="whatsbtn" class="col-md-1 col-2 px-0">
                    <img src="{{ asset('img/whatsapp.png') }}" class="img "/>
                </div>
                <div  id="pdfbtn" class="col-md-1 col-2 px-0">
                   
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

</section>


@endsection


@push('page_js')
    <!--  biblioteca para openstreetmap  -->
    <script src="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.umd.js"></script>    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

 
    <!--  biblioteca para leaflet  -->
    <script>
    
    // Loading button plugin (removed from BS4)
    (function ($) {
        //alert("hi");
        //rango dete picker 
        $('#date-range').daterangepicker({
            opens: 'left',
            drops: 'down',
            autoApply: true,
            locale: {
            format: 'YYYY-MM-DD',
            separator: ' - ',
            applyLabel: 'Aceptar',
            cancelLabel: 'Cancelar',
            fromLabel: 'De',
            toLabel: 'a',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Do', 'Lu', 'Ma', 'Mie', 'Je', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            firstDay: 0
            }
        });

        //Filtros

        /*
        Busqueda usando mapa
        */
        let customIcon = {
            iconUrl: "{{asset('images/ccls/marker-icon-2x.png')}}",
            iconSize:[25,42],
        }
        let iconoPin = L.icon(customIcon);
        let iconOptions = {
            title:"ccls",
            draggable:true,
            icon:iconoPin
        }
        
        let searchInput = document.getElementById('search');
        let resultList = document.getElementById('result-list');
        let mapContainer = document.getElementById('map-container');
        let currentMarkers = [];
        let viajesIdaMarkers; 
        let cclsMarkers;
        //viajesIdaMarkers = "viajesCompartidosIda";
        cclsMarkers = @json($cclsUbicaciones);
        
        var map = L.map(mapContainer).setView([23.634501, -102.552784], 6);
        
        //map = L.map(mapContainer).setView([19.4326296, -99.1331785], 8);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);            
        function onClick(e) {
            var popup = e.target.getPopup();
            var content = popup.getContent();
            console.log(content);
        }
        let cclEstado = document.querySelector('#_cclEstados');
        let datosCCL  = document.querySelector('#_datosCCL');
        let markers ;
        function verMapa(){   
            const cclMaps = document.querySelectorAll('#result-list .cclContent a.vermapa');
            //console.log(cclMaps);
            cclMaps.forEach(cclMap => {
                cclMap.addEventListener('click', function handleClick(event) {      
                    const clickedData = JSON.parse(event.target.querySelector('span').innerHTML);          
                    const position = new L.LatLng(clickedData.lat, clickedData.lon);
                    //console.log('lat '+ clickedData.lat + ' long ' + clickedData.lon  );
                    map.flyTo(position, 16);
                    $('html, body').animate({
                        scrollTop: $("#map-container").offset().top - 50
                    }, 50);
                });
            });
        //console.log(e.lat);
        //const clickedData = JSON.parse(elem.querySelector('span').innerHTML);
        //const position = new L.LatLng(e.lat, e.lat);
        //map.flyTo(position, 14);  
        }  
        
        // propuesta de IA
        const cclsUbicaciones = [
            @foreach ($cclsUbicaciones as $ccl)
            {
                latitud: {{ $ccl->latitud }},
                longitud: {{ $ccl->longitud }},
                empresa: "{{ $ccl->empresa }}",
                municipio: "{{ $ccl->municipio }}",
                estado: "{{ $ccl->estado }}",
                estatus: "{{ $ccl->estatus }}",
                sector: "{{ $ccl->sector }}",
                motivos_ficha: "{{ $ccl->motivos_ficha }}",
                texto_ficha: "{{ $ccl->texto_ficha }}"
            },
            @endforeach
        ];

        //Filtros
        const filtropresentados = document.getElementById('filter_type-presentados');
        const filtroactivos = document.getElementById('filter_type-activos');
        const filtrocerrados = document.getElementById('filter_type-cerrados');
        const filtropaneles = document.getElementById('filter_type-paneles');
        const daterange1 = document.getElementById('filter_type-fecha');
        const daterange2 = document.getElementById('filter_type-fecha2');
        const daterangepc1 = document.getElementById('filter_type-fechapc');
        const daterangepc2 = document.getElementById('filter_type-fechapc2');
        
        const valPresentados = document.getElementById('valPresentados');
        const valActivos = document.getElementById('valActivos');
        const valCerrados = document.getElementById('valCerrados');
        const valPaneles = document.getElementById('valPaneles');
        
        //console.log(daterange1.value + " " + daterange2.value);
        var startDate = daterange1.value;
        var endDate = daterange2.value;
        
        //console.log("fecha inicio "+ startDate + " fecha fin "+ endDate);
        let activeFilter = "presentados"; 
        
        document.addEventListener('change', (event) => {
            
            if (event.target.matches('input[name="filtro_map"]') && event.target.checked) {
                activeFilter = event.target.value;
                //alert(activeFilter + " " + daterange1.value + " " + daterange2.value); 
                if(activeFilter == "presentados"){
                    //alert("mapainicial " +activeFilter + " " + daterange1.value + " " + daterange2.value); 
                    mapaInicial( daterange1.value, daterange2.value);
                }else{
                    //alert("mapaInicialFiltro " +activeFilter + " " + daterange1.value + " " + daterange2.value); 
                    mapaInicialFiltro(activeFilter, daterange1.value, daterange2.value);
                }       
                        
            }
            //alert(event.target === daterange1 || event.target === daterange2);
            if (event.target === daterange1 || event.target === daterange2) {
                startDate = daterange1.value;
                endDate = daterange2.value;
                
                valPresentados.innerHTML=  contadorFiltro2(daterange1.value, daterange2.value );
                valActivos.innerHTML= contadorFiltro('Activo',daterange1.value, daterange2.value );
                valCerrados.innerHTML= contadorFiltro('Cerrado',daterange1.value, daterange2.value );
                valPaneles.innerHTML= contadorFiltro('Panel',daterange1.value, daterange2.value );
                

                if(activeFilter == "presentados"){
                    mapaInicial( startDate, endDate);
                }else{
                    mapaInicialFiltro(activeFilter, startDate, endDate);
                }                    
            }
            if (event.target === daterangepc1 || event.target === daterangepc2) {
                //alert(event.target === daterange1);    
                startDate = daterangepc1.value;
                endDate = daterangepc2.value;
                
                valPresentados.innerHTML=  contadorFiltro2(daterangepc1.value, daterangepc2.value );
                valActivos.innerHTML= contadorFiltro('Activo',daterangepc1.value, daterangepc2.value );
                valCerrados.innerHTML= contadorFiltro('Cerrado',daterangepc1.value, daterangepc2.value );
                valPaneles.innerHTML= contadorFiltro('Panel',daterangepc1.value, daterangepc2.value );
                

                if(activeFilter == "presentados"){
                    mapaInicial( startDate, endDate);
                }else{
                    mapaInicialFiltro(activeFilter, startDate, endDate);
                }                    
            }       
        });
        //console.log("fecha inicio "+startDate +" fecha final "+ endDate );
        
        function contadorFiltro(filtro, date1, date2 ){
            currentMarkers = [];            
            cclsMarkers = @json($cclsUbicaciones);
            let cnt=0;
            cclsMarkers.forEach(ccl => {
                if (ccl.estatus == filtro & ccl.fecha_estatus >=  date1 &  ccl.fecha_estatus <=  date2){                    
                    cnt++;                                                  
                }                  
            });
            return cnt;
        }
        
        function contadorFiltro2(date1, date2 ){
            currentMarkers = [];            
            cclsMarkers = @json($cclsUbicaciones);
            let cnt=0;
            cclsMarkers.forEach(ccl => {
                if (ccl.fecha_estatus >=  date1 &  ccl.fecha_estatus <=  date2){                    
                    cnt++;                                                  
                }                  
            });
            return cnt;
        }
        function mapaInicialFiltro(filtro, finicio, ffinal) {
            currentMarkers = [];            
            cclsMarkers = @json($cclsUbicaciones);
            map.remove();
            map = L.map(mapContainer).setView([23.634501, -102.552784], 5);  

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            markers = [];
            resultList.innerHTML = ""; 
            
            cclsMarkers.forEach(ccl => {
                //console.log(ccl.estatus + "  "+ filtro);
                //if( ccl.estatus == filtro){
                //console.log(ccl.fecha_estatus + "  "+ finicio +" "+ ffinal+ " "+ (ccl.fecha_estatus >=  finicio) + " "+(ccl.fecha_estatus <=  ffinal));
                if (ccl.fecha_estatus >=  finicio &  ccl.fecha_estatus <=  ffinal){                    
                    if( ccl.estatus == filtro ){                                                
                         //formateador de fechas
                        const fechaOriginal = new Date(ccl.fecha_estatus);
                        const opciones = { day: 'numeric', month: 'long', year: 'numeric' };
                        const formateador = new Intl.DateTimeFormat('es-ES', opciones);
                        const fechaFormateada = formateador.format(fechaOriginal);
                        //
                        const marker = L.marker([ccl.latitud, ccl.longitud], { icon: iconoPin }).addTo(map);
                        markers.push(marker);           
                        // Event listener for marker click
                        marker.on('click', function () {
                            // Get the modal and content elements
                            const modal = new bootstrap.Modal(document.getElementById('markerModal'));
                            const modalContent = document.getElementById('modalContent');
                            const modalHeader = document.getElementById('modal-header');
                            const pdfbtn = document.getElementById('pdfbtn');
                            const mailtobtn = document.getElementById('mailtobtn');   
                            const whatsbtn = document.getElementById('whatsbtn');
                            const facebtn = document.getElementById('facebtn');
                            const xbtn = document.getElementById('xbtn');
                            
                            // Set the modal content using the ccl data
                            modalHeader.innerHTML = `  
                                <div class="content title">
                                    
                                    <i class="fa-solid fa-industry" style="color: #347c6b;"></i>
                                    
                                    <h2>${ccl.empresa}</h2>
                                    <h4>${ccl.municipio}, ${ccl.estado} / ${ccl.estado} ${ccl.fecha_estatus} </h4>
                                </div>
                            `;
                            modalContent.innerHTML = `                                                            
                                <div class="content info">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>Nombre de la Empresa: ${ccl.empresa} </p>
                                            <p>Ciudad o Municipio: ${ccl.municipio} </p>
                                            <p>Estado: ${ccl.estado}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <P>Fecha: ${ccl.fecha_estatus} </P>
                                            <P>Estatus: ${ccl.estatus} </P>
                                            <p>Sector: ${ccl.sector}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="content info">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 style="font-weight:bold">Motivo de activación</h4>
                                            <p>${ccl.motivos_ficha} </p>
                                            <h4 style="font-weight:bold">Resultados</h4>
                                            <p>${ccl.resultados_ficha} </p>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 style="font-weight:bold">Resumen</h4>
                                            <p>${ccl.texto_ficha}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="content info">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 style="font-weight:bold">Enlace de Solicitud</h4>
                                            <a href="${ccl.link_solicitud_ustr}" target="_blank"  >${ccl.link_solicitud_ustr}</a>
                                        </div>
                                    </div>
                                </div>
                            `;
                            pdfbtn.innerHTML= `
                                <a href="/generar-pdf/${ccl.id}" target="_blank" >
                                    <img src="{{ asset('img/pdf.jpg') }}" class="img "/>
                                </a>
                            `;
                            xbtn.innerHTML =`
                            <a href="https://twitter.com/intent/tweet?text=Mira%20este%20caso%20del%20MLRR&url=https://mapavozlaboral.eastus2.cloudapp.azure.com/generar-pdf/${ccl.id}" target="_blank">
                                <img src="{{ asset('img/xlogo.png') }}" width="40px" height="40px" class="img "/>
                            </a>`;
                            facebtn.innerHTML =`
                            <a href="http://www.facebook.com/sharer.php?u=https://mapavozlaboral.eastus2.cloudapp.azure.com/generar-pdf/${ccl.id}" target="_blank">
                                <img src="{{ asset('img/face.png') }}" class="img "/>
                            </a>`;
                            whatsbtn.innerHTML =`
                            <a href="https://api.whatsapp.com/send?text=Mira%20este%20caso%20del%20MLRR%20https%3A%2F%2Fmapavozlaboral.eastus2.cloudapp.azure.com%2Fgenerar-pdf%2F${ccl.id}" target="_blank">
                                <img src="{{ asset('img/whatsapp.png') }}" class="img "/>
                            </a>`;
                            mailtobtn.innerHTML =`
                            <a href="mailto:?subject=Compartir enlace de descarga&body=Enlace de descarga:%0Ahttps://mapavozlaboral.eastus2.cloudapp.azure.com/generar-pdf/${ccl.id}" target="_blank">
                                <img src="{{ asset('img/mail.png') }}" class="img"/> 
                            </a>`;
                            modal.show();
                        });                                 
                    }                       
                }                                                
            });
        }

        mapaInicialFiltro(activeFilter, daterange1.value, daterange2.value);

        /*
        function mapaInicial2() {
            currentMarkers = [];            
            cclsMarkers = @json($cclsUbicaciones);
            map.remove();
            map = L.map(mapContainer).setView([23.634501, -102.552784], 6);  

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            let  marker= [];
            markers = [];
            resultList.innerHTML = ""; 

            cclsUbicaciones.forEach(ccl => {
                
                //alert(activeFilter + " "+ ccl.status );
                const marker = L.marker([ccl.latitud, ccl.longitud], { icon: iconoPin }).addTo(map);
                markers.push(marker);                            
                
                // Event listener for marker click
                marker.on('click', function () {
                    // Get the modal and content elements
                    const modal = new bootstrap.Modal(document.getElementById('markerModal'));
                    const modalContent = document.getElementById('modalContent');

                    // Set the modal content using the ccl data
                    modalContent.innerHTML = `
                        <p><strong>Empresa:</strong> ${ccl.empresa}</p>
                        <p><strong>Municipio:</strong> ${ccl.municipio}</p>
                        <p><strong>Estado:</strong> ${ccl.estado}</p>
                        <p><strong>Estatus:</strong> ${ccl.estatus}</p>
                        <p><strong>Sector:</strong> ${ccl.sector}</p>
                        <p><strong>Motivos:</strong> ${ccl.motivos_ficha}</p>
                        <p><strong>Texto:</strong> ${ccl.texto_ficha}</p>
                    `;
                    modal.show();
                });
            });
        }
        mapaInicial2();
        */

        // termina propuesta de IA
        function mapaInicial(finicio, ffinal){
            currentMarkers = [];
            cclsMarkers = @json($cclsUbicaciones);
            map.remove();
            map = L.map(mapContainer).setView([23.634501, -102.552784], 5);  
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);     
            markers = new Array();     
            resultList.innerHTML= "";     
            /*
            @foreach($cclsUbicaciones as $ccl)       
                    lat = "{{ $ccl->latitud }}";
                    long= "{{ $ccl->longitud }}";
                
                    marker = new L.Marker([lat, long], {icon:iconoPin})      
                        .bindPopup('<a href="#"' + ' target="_blank"  rel="noopener noreferrer" > ' + 'Empresa:' + "{{$ccl->empresa}} " + '<br>' + 'municipio: ' + "{{$ccl->municipio}}" +  '<br>' + 'Estado: ' +  "{{$ccl->estado}} " + '<br>' + 'estatus: ' +  "{{$ccl->estatus}} " + '<br>' + 'sector: ' +  "{{$ccl->sector}} " + '<br>' + 'Motivos: ' +  "{{$ccl->motivos_ficha}} " + 'Texto: ' +  "{{$ccl->texto_ficha}} " +"</a>")
                        .addTo(map);
                    markers.push(marker);                                        
            @endforeach 
            */
            

            cclsMarkers.forEach(ccl => {
                //console.log(ccl.fecha_estatus +" "+ finicio + (ccl.fecha_estatus >=  finicio));
                if( ccl.fecha_estatus >=  finicio &  ccl.fecha_estatus <=  ffinal ){
                    //formateador de fechas
                    const fechaOriginal = new Date(ccl.fecha_estatus);
                    const opciones = { day: 'numeric', month: 'long', year: 'numeric' };
                    const formateador = new Intl.DateTimeFormat('es-ES', opciones);
                    const fechaFormateada = formateador.format(fechaOriginal);
                    //

                    const marker = L.marker([ccl.latitud, ccl.longitud], { icon: iconoPin }).addTo(map);
                    markers.push(marker);           
                    // Event listener for marker click
                    marker.on('click', function () {
                        // Get the modal and content elements
                        const modal = new bootstrap.Modal(document.getElementById('markerModal'));
                        const modalContent = document.getElementById('modalContent');
                        const modalHeader = document.getElementById('modal-header');
                        const pdfbtn = document.getElementById('pdfbtn');   
                        const mailtobtn = document.getElementById('mailtobtn');   
                        const whatsbtn = document.getElementById('whatsbtn');   
                        const facebtn = document.getElementById('facebtn');
                        const xbtn = document.getElementById('xbtn');
                        
                        // Set the modal content using the ccl data
                        modalHeader.innerHTML = `  
                            <div class="content title">
                                <i class="fa-solid fa-industry" style="color: #347c6b;"></i>                                
                                <h2>${ccl.empresa}</h2>
                                <h4>${ccl.municipio}, ${ccl.estado} / ${ccl.estado} ${fechaFormateada} </h4>
                            </div>
                        `;
                        // Set the modal content using the ccl data
                        modalContent.innerHTML = `
                            <div class="content info datoscabecera">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p> <b> Nombre de la Empresa: </b> ${ccl.empresa} </p>
                                        <p> <b>Ciudad o Municipio:</b> ${ccl.municipio} </p>
                                        <p> <b>Estado:</b> ${ccl.estado}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <P> <b>Fecha:</b> ${ccl.fecha_estatus} </P>
                                        <P> <b>Estatus:</b> ${ccl.estatus} </P>
                                        <p> <b>Sector:</b>  ${ccl.sector}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="content info datoscuerpo">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 style="font-weight:bold">Motivo de activación</h4>
                                        <p>${ccl.motivos_ficha} </p>
                                        <h4 style="font-weight:bold">Resultados</h4>
                                        <p>${ccl.resultados_ficha} </p>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 style="font-weight:bold">Resumen</h4>
                                        <p>${ccl.texto_ficha}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="content info">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 style="font-weight:bold">Enlace de Solicitud</h4>
                                        <a href="${ccl.link_solicitud_ustr}" target="_blank" >${ccl.link_solicitud_ustr}</a>
                                    </div>
                                </div>
                            </div>
                        `;
                        pdfbtn.innerHTML= `
                                <a href="/generar-pdf/${ccl.id}" target="_blank">
                                    <img src="{{ asset('img/pdf.jpg') }}" class="img "/>
                                </a>
                            `;
                        xbtn.innerHTML =`
                        <a href="https://twitter.com/intent/tweet?text=Mira%20este%20caso%20del%20MLRR&url=https://mapavozlaboral.eastus2.cloudapp.azure.com/generar-pdf/${ccl.id}" target="_blank">
                            <img src="{{ asset('img/xlogo.png') }}" width="40px" height="40px" class="img "/>
                        </a>`;
                        facebtn.innerHTML =`
                        <a href="http://www.facebook.com/sharer.php?u=https://mapavozlaboral.eastus2.cloudapp.azure.com/generar-pdf/${ccl.id}" target="_blank">
                            <img src="{{ asset('img/face.png') }}" class="img "/>
                        </a>`;
                        whatsbtn.innerHTML =`
                        <a href="https://api.whatsapp.com/send?text=Mira%20este%20caso%20del%20MLRR%20https%3A%2F%2Fmapavozlaboral.eastus2.cloudapp.azure.com%2Fgenerar-pdf%2F${ccl.id}" target="_blank">
                                <img src="{{ asset('img/whatsapp.png') }}" class="img "/>
                        </a>`;
                        mailtobtn.innerHTML =`
                            <a href="mailto:?subject=Compartir enlace de descarga&body=Enlace de descarga:%0Ahttps://mapavozlaboral.eastus2.cloudapp.azure.com/generar-pdf/${ccl.id}" target="_blank">
                                <img src="{{ asset('img/mail.png') }}" class="img"/> 
                            </a>`;
                        modal.show();
                    });                 
                } 
            });
        }

        mapaInicial(daterange1.value, daterange2.value);

        function colocarCCLEstado(){
            let sectorOp ;
            let textOpSector;
            cclEstado.addEventListener('change', (event) => {                 
                if(cclEstado.value !== "Selecciona un estado"){     
                    customIcon = {
                        iconUrl: "{{asset('images/ccls/edificio.png')}}",
                        iconSize:[35,35],
                    }
                    currentMarkers = [];
                    cclsMarkers = @json($cclsUbicaciones);
                    var estados = @json($estados);
                    var estadoId = parseInt(cclEstado.value);
                    var latMap; 
                    var longMap;

                    @foreach($estados as $estado)
                        if( estadoId == {{$estado->clave}}) {
                            estadoSelNom = "{{$estado->nombre}}";     
                            latMap = {{$estado->lat}};
                            longMap = {{$estado->long}};                          
                        };
                    @endforeach                                    
                    //console.log( "id estado "+ estadoId + " estado nombre "+ estadoSelNom );                 
                    map.remove();
                    map = L.map(mapContainer).setView([latMap, longMap], 5);
                    markers = new Array();     
                    resultList.innerHTML= "";              
                    
                    @foreach($cclsUbicaciones as $ccl)            
                        if( "{{$ccl->estado}}" == estadoSelNom ){
                            lat = "{{ $ccl->latitud }}";
                            long= "{{ $ccl->longitud }}";
                            marker = new L.Marker([lat, long], {icon:iconoPin})      
                                .bindPopup('<a href="#"' + ' target="_blank"  rel="noopener noreferrer" > ' + 'Empresa:' + "{{$ccl->empresa}} " + '<br>' + 'municipio: ' + "{{$ccl->municipio}}" +  '<br>' + 'Estado: ' +  "{{$ccl->estado}} " + '<br>' + 'estatus: ' +  " {{$ccl->estatus}} " + '<br>' + 'sector: ' +  "{{$ccl->sector}} " + '<br>' + 'Motivos: ' +  "{{$ccl->motivos_ficha}} " + 'Texto: ' +  "{{$ccl->texto_ficha}} " +"</a>")
                                .addTo(map);
                            markers.push(marker);    
                            const div = document.createElement('div');
                            div.classList.add('w-100', 'justify-content-between', 'cclContent');
                            const h5 = document.createElement('h5');
                            const p1 = document.createElement('p');
                            const p2 = document.createElement('p');
                            const p3 = document.createElement('p');
                            const p4 = document.createElement('p');
                            const p5 = document.createElement('p');
                            
                            let cad = JSON.stringify({
                                lat: lat,
                                lon: long
                            }, undefined, 10);
                            
                            h5.classList.add('dorada');
                            p1.classList.add('mb-1', 'direccionCCL');
                            p2.classList.add('mb-1', 'ambitoCCL');
                            p3.classList.add('mb-1', 'contactoCCL');
                            p4.classList.add('mb-1', 'contactoCCL');
                            p5.classList.add('mb-1', 'enlaceMapa', 'dorada');
                            
                            console.log('-->',estadoId);                            

                            h5.innerHTML = "Empresa: " + "{{$ccl->empresa}} ";                            
                            /* p5.innerHTML = '<a class="vermapa dorada">' + "Ver mapa" + "<span class='d-none'>"+ cad +'</span> </a>'; */
                            p5.classList.add('mb-1', 'enlaceMapa', 'dorada','row');                                                        
                            p1.innerHTML = "Dirección: "+ "{{$ccl->estado}} "+  "{{$ccl->municipio}} ";
                            p2.innerHTML = "Sector: " + "{{$ccl->sector}}" +  '<br>';
                            p3.innerHTML = "Motivos ficha: " +  "{{$ccl->motivos_ficha}} ";
                            p4.innerHTML = "Generar cita: " +  '<a href="" target="_blank"  rel="noopener noreferrer" class="enlaceSolCita">' + "Solicitar cita en este centro" + '</a>';
                            p5.innerHTML = '<a class="vermapa dorada col-3">' + "Ver en el mapa" + "<span class='d-none'>"+ cad +'</span> </a>' + '<a class="dorada  col-9" href=' +"{{url($ccl->link_solicitud_ustr)}}"+ ' target="_blank"  rel="noopener noreferrer" > ' + " Ir al sitio web del Centro de Conciliación <span class='d-none'>" +' </span> </a>';

                            div.appendChild(h5);
                            div.appendChild(p1);
                            div.appendChild(p2);
                            div.appendChild(p3);
                            div.appendChild(p4);
                            div.appendChild(p5);                                                                                
                            
                            resultList.appendChild(div);
                        }
                    @endforeach   

                    //map = L.map(mapContainer).setView([19.4326296, -99.1331785], 8);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);                    
                    //alert("cosa " +sectorOp);                                    

                    verMapa();
                    datosCCL.classList.remove('ocultar');

                }else{                    
                    Swal.fire({
                            icon: "error",
                            title: "ADVERTENCIA",
                            text: "Debes seleccionar un estado de la república",                        
                    });    
                }                
            });       

        }
        colocarCCLEstado();
    
    }(jQuery));

</script>
@endpush

<!--
<div class="map-popup-inner">
    <div class="popup-header">
        <a href="#" class="close-popup"></a>
        <div class="popup-header-row">
            <div>
                <div class="popup-footer-icon popup-footer-icon-automotriz"></div>
            </div>
            <div>
                <h2>Caso <br>General Motors</h2>
                <div class="popup-subtitle">Silao, Guanajuato / 12 de mayo de 2021</div>
            </div>
        </div>
        
    </div>
    <div class="popup-content">
        <div class="popup-row">
            <div>
                <div><b>Nombre de la empresa:</b> <span id="popup-content-company">General Motors</span></div>
                <div><b>Ciudad o municipio:</b> <span id="popup-content-city">Silao</span></div>
                <div><b>Estado:</b> <span id="popup-content-state">Guanajuato</span></div>
            </div>
            <div>
                <div><b>Fecha:</b> <span id="popup-content-status-date">12 de mayo de 2021</span></div>
                <div><b>Estatus:</b> <span id="popup-content-status">Activo</span></div>
                <div><b>Sector:</b> <span id="popup-content-sector">Automotriz</span></div>
            </div>
        </div>
        <div class="divider-popup"></div>
        <div class="popup-content-inner">
            <div class="popup-row">
                <div>
                    <div>
                        <h5>Motivo de activación</h5>
                        <div id="popup-content-status-motivos">Destrucción de papeletas para la votación, Irregularidades en la consulta a los trabajadores, Escrutinios parciales </div>
                    </div>
                    <div>
                        <h5>Resultados</h5>
                        <div id="popup-content-status-resultados">Salarios más altos, Representación sindical legítima, Reposición de votación vigilada por autoridades, Emisión de criterios generales para todos los procedimientos de democracia sindical, Declaración de neutralidad empresarial</div>
                    </div>
                </div>
                <div>
                    <h5>Resumen</h5>
                    <div id="popup-content-description">"EE.UU. solicitó a México revisar la denegación a los derechos de libertad de asociación y negociación colectiva en GM Silao, debido a la destrucción de papeletas en la votación que organizó el entonces sindicato titular, para legitimar el contrato colectivo vigente. <br>Como resultado del MLRR, los trabajadores de la planta tuvieron una nueva votación para determinar si estaban de acuerdo con legitimar su contrato colectivo de trabajo. En la reposición de la consulta, las personas trabajadoras rechazaron la legitimación y  posteriormente, pudieron votar por un nuevo sindicato que les representara.  Las personas trabajadoras eligieron un nuevo sindicato independiente, que negoció y consiguió salarios más altos en un nuevo contrato colectivo que los trabajadores aprobaron por mayoría, mediante voto personal, libre, secreto y directo."</div>
                </div>
            </div>
            <div>
                <h5>Liga de solicitud</h5>
                <a href="https://ustr.gov/about-us/policy-offices/press-office/press-releases/2023/august/united-states-seeks-mexicos-review-alleged-denial-workers-rights-mexican-airline" id="popup-content-link-resultados" target="_blank" rel="nofollow noreferer">Leer más</a>
            </div>
        </div>
    </div>
    <div class="popup-footer">
        <img decoding="async" src="https://dev.vozlaboral.mx/wp-content/themes/divi-child/images/logo-footer-mapa.svg" class="popup-footer-logo" alt="">
        <div class="popup-footer-actions">                                        
            <a href="#" id="popup-content-download" target="_blank" style="display: none;"></a>
        </div>
    </div>
</div>
-->