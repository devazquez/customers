@extends('layouts.appPublic')

@section('content')

<div class="container vh-75">
    <div class="row justify-content-md-center">
        <div class="col-12 col-md-10" id="principal">
            <div class="card px-1 py-3 mt-5 shadow" >
                <div id="calculo" class="px-3 calculo position-relative" style="font-size: 16px">
                            <div class="form-section" style="text-align: justify;">
                                <!-- <h3 class="text-center">Información</h3>-->
                                <p>
                                    Persona trabajadora, la siguiente información  tiene el objetivo de identificar correctamente
                                    el Centro de Conciliación en donde debes iniciar tu solicitud de conciliación. El Centro de
                                    Conciliación correcto para atender tu asunto, lo llamamos <b style="font-weight: bolder; color=#222622">“competente”</b> respecto a tu
                                    conflicto. Esta competencia obedece a la ubicación de tu trabajo, que determina la
                                    competencia territorial, y la industria al que pertenece tu patrón, que determina si tu conflicto
                                    entra en competencia federal, o en competencia local (estatal).

                            </div>

                            <div class="form-section" style="text-align: justify;">
                                <p>
                                    Los Centros de Conciliación tienen dos tipos de competencias: 
                                </p>
                                <ul>
                                    <li>
                                        Federal: asuntos atendidos por el Centro Federal de Conciliación y Registro Laboral (CFCRL).                                    
                                    </li>
                                    <li>
                                        Local: asuntos atendidos por el Centro de Conciliación Laboral (CCL). 
                                    </li>
                                </ul>
                                <p>                                    
                                    Cada uno de estos Centros de Conciliación existe en cada entidad federativa, para atender los conflictos que surgen en cada territorio. 
                                    Así, el lugar de trabajo y la actividad económica del patrón sirven para identificar la competencia territorial y el tipo de Centro de Conciliación (Federal o Local), para que el Centro de Conciliación competente pueda atender tu asunto sin contratiempos. 
                                </p>
                            </div>

                            <div class="form-section" data-calculate="True">
                                <p>
                                    Para identificar el Centro de Conciliación competente para resolver tu conflicto, debes contar con el <b> municipio y entidad federativa</b> donde se localiza tu patrón y la <b> actividad económica principal del patrón </b> al que deseas citar a la conciliación.                                     
                                </p>
                                <p>
                                    <b style="font-weight: bolder; color=#222622">Ojo</b>: es la actividad económica de tu patrón, no la actividad económica que tú como trabajador desempeñaste.
                                </p>
                                <p>                                    
                                    Toma en consideración que el 80% de los asuntos son de competencia local, por lo que es más probable que tu asunto deba ser atendido por un Centro de Conciliación Laboral (CCL) y no por el Centro Federal de Conciliación y Registro Laboral (CFCRL).                                     
                                </p>
                                <p>
                                    También como punto general, es importante notar que la competencia federal está reservada para ciertas industrias, siempre en la producción o manufactura. <b> Es decir, aún cuando la producción es de competencia federal, la distribución, comercialización y servicios relacionados con el producto son de competencia local</b>.                                                                         
                                </p>
                                <p>
                                    Para determinar si tu conflicto es de competencia federal o local, a continuación te pedimos seleccionar la actividad económica principal del patrón para identificar qué Centro de Conciliación debe atender tu asunto:
                                </p>
                            </div>
                            <div class="form-navigation mt-3 pt-4">
                                <button type="button" class="previous btn btn-primary position-absolute bottom-0 start-0 mx-3 btn-sm">&lt; Regresar</button>
                                <button type="button" class="next btn btn-primary position-absolute bottom-0 end-0 mx-3 btn-sm" btn-sm>Continuar &gt;</button>
                                <a class="submit btn btn-primary btn-primary-ccls position-absolute bottom-0 end-0 mx-3 btn-sm" href="{{ route('localizatucclpublic') }}">Continuar</a>
                            </div>
                    </div>
            </div>
        </div>
    </div>
</div>

    
@endsection

@push('js')
<script>

  $(function(){
        $("#btn_prev").hide();
        var $sections=$('.form-section');
        function navigateTo(index){

            $sections.removeClass('current').eq(index).addClass('current');

            $('.form-navigation .previous').toggle(index>0);
            var atTheEnd = index >= $sections.length - 1;
            $('.form-navigation .next').toggle(!atTheEnd);
            $('.form-navigation .submit').toggle(atTheEnd);
        }

        function curIndex(){
            return $sections.index($sections.filter('.current'));
        }

        $('.form-navigation .previous').click(function(){
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#principal").offset().top-50
            }, 100);

            navigateTo(curIndex() - 1);
        });

        $('.form-navigation .next').click(function(){
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#principal").offset().top-50
            }, 100);
            navigateTo(curIndex()+1);
        });

        $sections.each(function(index,section){
            $(section).find(':input').attr('data-parsley-group','block-'+index);
        });

        navigateTo(0);
        $("#btn_next").click(function(){
            $("#btn_next").hide();
            $("#btn_prev").show();
            $(".propuesta_completa").hide();
            $(".propuesta_parcial").removeClass("d-none").show();
        });

        $("#btn_prev").click(function(){
            $("#btn_prev").hide();
            $("#btn_next").show();
            $(".propuesta_parcial").hide();
            $(".propuesta_completa").show();
        });


});

</script>
  @endpush