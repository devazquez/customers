@extends('layouts.appPublic')

@section('content')
<span class="uisheet screen-darken"></span>

<section class="der-lab-trabajadores  my-5 col col-md-10 col-lg-10 col-12 ">
    <a href="{{ url()->previous() }}" class="btn btn-primary btn-primary-ccls rounded-pill"> 
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
        </svg>
        Regresar
    </a>
    <div class="row w-100">
        <div class="col-12  justify-content-center w-100">
            
            <h4 class="h4 dorada my-3">
                1) Selecciona el sector industrial con el que te identificas. 
            </h4>                        

            <div class="bd-example galeriaActLab">
                <div class="row  row-cols-1 row-cols-md-4 g-lg-3 g-md-3 g-1">
                    @php
                    $cnt= 1;
                    @endphp
                    
                    @foreach( $datosGaleria as $actividadLaboral )
                    <div class="col cardActlab rounded-bottom  card-{{$cnt}}">
                        <div class="card ">
                            
                            <div class="card-head">                                
                                <img src="{{asset('images/ccls/actividad/')}}/{{$actividadLaboral['img']}}"   alt="">
                                <div class="textCardAct p-1 ">
                                    <p class="card-text rounded p-2">{{ $actividadLaboral['descripcion'] }}</p>
                                    <a class="dorada rounded selecc" href="{{route('localizatucclambitopublic', 'Federal')}}">Seleccionar </a>
                                </div>
                                <div class="textCardAct2 p-2 w-100">
                                    <h5 class="card-title" >{{ $actividadLaboral['titulo'] }} </h5>                                        
                                </div>
                            </div>           
                            <!--
                            <div class="card-body  rounded-bottom">
                                <h5 class="card-title">{{ $actividadLaboral['titulo'] }} <i onclick="mostrarContenido({{$cnt}});" class="fa-solid fa-circle-question indicator"></i></h5>    
                                <p class="card-text overflow-auto">{{ $actividadLaboral['descripcion'] }}</p>                                
                            </div>-->
                            <!--
                            <div class="card-footer  rounded-bottom">
                                <a class="dorada" href="{{route('localizatucclambitopublic', 'Federal')}}">Continuar </a>                                
                            </div>-->
                        </div>
                    </div>
                    @php
                        $cnt++;
                    @endphp
                    @endforeach

                    <div class="col cardActlab rounded-bottom ">
                        <div class="card ">
                            
                            <div class="card-head">                                
                                <img src="{{asset('images/ccls/actividad/negocio.jpg')}}"   alt="">
                                <div class="textCardAct p-1 ">
                                    <p class="card-text rounded p-2" style ="font-size:16px; line-height:20px;">¿No te identificas con ninguna de estas actividades económicas de competencia federal?</p>
                                    <a class="dorada rounded selecc" style ="font-size:18px; line-height:30px" href="{{route('localizatucclambitopublic', 'Local')}}">Da clic aquí </a>
                                </div>                                
                            </div>           
                            <!--
                            <div class="card-body  rounded-bottom">
                                <h5 class="card-title">{{ $actividadLaboral['titulo'] }}</h5>    
                                <p class="card-text overflow-auto">{{ $actividadLaboral['descripcion'] }}</p>                                
                            </div>-->
                            <!--
                            <div class="card-footer  rounded-bottom">
                                <a class="dorada" href="{{route('localizatucclambitopublic', 'Federal')}}">Continuar </a>                                
                            </div>-->
                        </div>
                    </div>
                </div>        
                <!--
                <div class="row">                    
                    <a href="{{route('localizatucclambitopublic', 'Local')}}" class="btn btn-primary w-lg-75 w-md-75 w-sm-75 w-100 mx-auto sinSector p-3 ">No te identificas con ninguno de estos sectores, da clic aquí</a>                            
                </div>
                -->
            </div>         
                
        </div>
    </div>  
</section>

@endsection

@push('page_js')

    <!--  biblioteca para leaflet  -->
    <script src="{{asset('js/leaflet.js') }}"></script>
    <!--  biblioteca para openstreetmap  -->
    <script src="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.umd.js"></script>
    <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function mostrarContenido(e){
            //alert(".card-"+e);
            const card = document.querySelector(".card-"+e +" "+ " .card .card-head .textCardAct");
            var hasOcultar = card.classList.contains( 'ocultar' );
            if(hasOcultar){
                card.classList.remove("ocultar");
            }else{
                card.classList.add("ocultar");
            }
            

        }
    </script>
  

@endpush



