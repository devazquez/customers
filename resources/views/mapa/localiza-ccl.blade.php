@extends('layouts.appPublic')

@section('content')
<span class="uisheet screen-darken"></span>

<section class="der-lab-trabajadores  my-3 col col-md-10 col-lg-10 col-12 ">
    
    <div class="container-act">
       
        <div class="row justify-content-md-center w-100 h-100 secAct active" id="r1">
            <nav>
            <a href="{{ url()->previous() }}" class="btn btn-primary btn-primary-ccls rounded-pill"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
                Regresar
            </a>
        </nav>
            <div class="col-12 h-100" id="principal">
                <div class=" px-3 py-3 mt-2 shadow " >               
                    <h4 class="h4  my-3">
                        1) Selecciona la opción que mejor describa la actividad económica a la que se dedica la empresa con la que deseas conciliar.
                    </h4>   
                    <!-- <h3 class="text-center">Información</h3>-->
                    <div class="bd-example galeriaActLab">
                        <div class="row  row-cols-1 row-cols-md-4 g-lg-3 g-md-3 g-1">
                            @php
                            $cnt= 0;
                            @endphp
                            
                            @foreach( $datosGaleria->sortBy('titulo') as $id => $actividadLaboral )
                            <button class="pill-act rounded-pill text-bg-secondary dorada selecc m-lg-3 m-md-3 p-lg-3 p-md-3 m-1 p-2  pill-{{$cnt}}" onclick='displayContentr2("r2", {{$id}} );'  >
                                {{ $actividadLaboral['titulo'] }}                                         
                            </button>                                
                                @php
                                    $cnt++;
                                @endphp
                            @endforeach
                            <br>
                            <br>
                            <a class="pill-act rounded-pill text-bg-secondary  selecc  pill-{{$cnt}} m-lg-3 m-md-3 p-lg-3 p-md-3 m-1 p-2" href="{{route('localizatucclambitopublic', 'Local')}}" >                                               
                                Ninguna de esas opciones                                       
                            </a>                                     
                        </div>                                   
                    </div>                                                                        
                </div>
            </div>
        </div>
        <div class="row justify-content-md-center w-100 h-100 secAct" id="r2">
            <nav>
                <button  class="btn btn-primary btn-primary-ccls rounded-pill previous" id="previous" onclick="displayR1()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    Regresar
                </button>                   
            </nav>
            <div class="col-12 h-100" id="principal2">
                <div class=" px-3 py-3 mt-2 shadow " >               
                    <h4 class="h4  my-3">
                        2) ¿Cuál de las siguientes opciones describe mejor las actividades que realiza la empresa con la que deseas conciliar?
                    </h4>   
                    <!-- <h3 class="text-center">Información</h3>-->
                    <div class="bd-example galeriaActLab">
                        <div class="row  row-cols-1 ">
                            <h5 class="dorada">
                                Actividad economica: <span id="nomAct1"> </span>
                            </h5>
                            <ul>
                                <li>
                                    <b > Competencia federal:</b>  <a class="dorada rounded selecc" href="{{route('localizatucclambitopublic', 'Federal')}}" id="descFed1">  Seleccionar Federal</a> 
                                </li>
                                <li>
                                    <b> Competencia local:</b> <a class="dorada rounded selecc" href="{{route('localizatucclambitopublic', 'Local')}}" id="descLoc1" >  Seleccionar Local </a>
                                </li>
                            </ul>                         
                        </div>                                   
                    </div>                                                                        
                </div>
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
        let botones = document.querySelectorAll('[data-bs-target="#exampleModal-1"]');
        botones.forEach(btn => {
            btn.addEventListener('click', function() {
                // Obtener columnas desde TR padre:
                let id = this.dataset.id;
                console.log(id);
                var datosGaleria = @json($datosGaleria->sortBy('titulo'));
                
                // Obtener datos por contenido de TD:
                
                // Asignar datos a ventana modal:
                document.querySelector('#nomAct').innerText =  datosGaleria[id]['titulo'];
                document.querySelector('#descFed').innerText =  datosGaleria[id]['descripcion'];
                document.querySelector('#descLoc').innerText =  datosGaleria[id]['descripcion2'];
                console.log('abrir modal');
                $('#exampleModal-1').modal();
            });
        });
       

    const sectionContent = ["r1", "r2"];
    let currentSection = sectionContent[0];

    const displayContent = (q) => {
        
        document.getElementById(q).classList.add("active");
       
        //document.getElementById(q + "-button").classList.add("button-active");
        currentSection = sectionContent.indexOf(q);
        document.getElementById("r2").classList.remove("active");
    }
    const displayContentr2 = (q, id=null) => {
        
        document.getElementById(q).classList.add("active");
        document.getElementById("r1").classList.remove("active");
        var datosGaleria = @json($datosGaleria->sortBy('titulo'));
        
        document.querySelector('#nomAct1').innerText =  datosGaleria[id]['titulo'];
        document.querySelector('#descFed1').innerText =  datosGaleria[id]['descripcion'];
        document.querySelector('#descLoc1').innerText =  datosGaleria[id]['descripcion2'];
        
        console.log(id);
        //document.getElementById(q + "-button").classList.add("button-active");
        currentSection = sectionContent.indexOf(q);       
    }

const displayR1 = () => displayContent("r1");
const displayR2 = () => displayContent("r2");


const displayNext = () => displayContent(sectionContent[sectionContent.indexOf(currentSection) + 1]);
const displayPrevious = () => displayContent(sectionContent[sectionContent.indexOf(currentSection) - 1]);
    </script>
  

@endpush



