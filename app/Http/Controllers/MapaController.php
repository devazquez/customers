<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\AuthHelper;
use App\Models\User;
// use Illuminate\Http\Post;
// use Illuminate\Http\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class MapaController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Vista de localiza tu CCL informativo
     */
    public function   localizaTuCCLInfo(Request $request)
    {                  
        return view('mapa.localiza-ccl-info');
    }
     /**
     * Vista de localiza tu CCL
     */
    public function   localizaTuCCL(Request $request)
    {                  
        $cclsUbicaciones = \DB::table('ccls as t1')
             ->select('t1.id', 't1.estado','t1.municipio', 't1.ambito','t1.direccion', 
             't1.url_google', 't1.lat','t1.long', 't1.contacto', 't1.cp', 't1.link')->get();              
        
        $sector_ccl = \DB::table('sector_ccl as t1')
            ->select('t1.id', 't1.sector','t1.subsector', 't1.rama','t1.subrama', 't1.tipo')->get();   
        
        $estados = \DB::table('estados as t1')
            ->select('t1.clave', 't1.nombre', 't1.abreviacion', 't1.cp_min','t1.cp_max', 't1.lat','t1.long')->get();   

        $sectores =  $sector_ccl->unique('sector');
        $subsectores = $sector_ccl->unique('subsector');
        $ramas = $sector_ccl->unique('rama');
        $subramas = $sector_ccl->unique('subrama');

        $datosGaleria = [  ['titulo' => 'Textil', 'descripcion' => 'Empresas que se dedican a la fabricación de hilo y tela son de competencia federal', 'descripcion2' => 'Empresas de venta de telas, hilos, artículos de mercería, o de confección y maquila de prendas de ropa', 'img' => 'textil.png'],
                           ['titulo' => 'Eléctrica', 'descripcion' => 'Centrales eléctricas dedicadas principalmente a la generación y distribución de energía eléctrica', 'descripcion2'=>'Empresas que se dedican a la venta de materiales para trabajo eléctrico o que venden artículos electrónicos.', 'img' => 'electrica.png'], 
                           ['titulo' => 'Cinematográfica', 'descripcion' => 'Empresas que se dedican a la producción, distribución y proyección de películas, como Cinépolis y Cinemex', 'descripcion2'=>'Empresas que no producen o proyectan, sino venden o distribuyen películas en formato físico, como librerías y tiendas departamentales cuya actividad principal es el comercio de productos en general y no solamente la venta de películas', 'img' => 'cinematografica.png'], 
                           ['titulo' => 'Hulera', 'descripcion' => 'Empresas que se dedican al cultivo de la planta de guayule y a la extracción del hule de la planta y a la fabricación de llantas ', 'descripcion2'=>'Empresas que no fabrican, sino solamente distribuyen o venden productos de hule, incluyendo llantas.', 'img' => 'hulera.png'], 
                           ['titulo' => 'Azucarera', 'descripcion' => 'Empresas que se dedican a la producción de azúcar en ingenios azucareros', 'descripcion2'=>'Empresas que no manufacturan el azúcar, sino solamente lo distribuyen o lo comercializan', 'img' => 'azucarera.png'], 
                           ['titulo' => 'Minera', 'descripcion' => 'Empresas que se dediquen a la explotación de minerales metálicos y no metálicos, así como a la extracción de gas y petróleo en minas, canteras y bancos de materiales; así como operaciones en pozos.', 'descripcion2'=>'Empresas que solamente proveen servicios o productos a las empresas extractoras.', 'img' => 'minera.png'], 
                           ['titulo' => 'Metalúrgica y siderúrgica', 'descripcion' => 'Empresas que se dedican a la explotación de los minerales básicos, el beneficio y la fundición de los mismos, así como la obtención de hierro metálico y acero a todas sus formas y ligas y los productos laminados de los mismos, son de competencia federal.', 'descripcion2'=>'Cualquier empresa que compra hierro y lo utiliza para diversa manufactura como maquinaria, muebles, instalaciones y partes para industria.', 'img' => 'metalurgica.png'], 
                           ['titulo' => 'Hidrocarburos', 'descripcion' => 'Empresas que producen gasolina, diésel y gas por medio de la extracción en pozos de explotación, plataformas marinas y refinerías como Pemex', 'descripcion2'=>'Empresas que comercializan la gasolina o el gas natural, como las gasolineras o las gaseras, como G500 o Hidrosina.', 'img' => 'hidrocarburos.png'], 
                           ['titulo' => 'Petroquímica', 'descripcion' => 'Empresas que se dedican a la extracción de combustibles fósiles para su transformación del gas natural y los derivados del petróleo en materias primas.', 'descripcion2'=>'Empresas que no manufacturan sino solamente distribuyen y comercializan productos químicos.', 'img' => 'petroquimica.png'], 
                           ['titulo' => 'Cementera', 'descripcion' => ': Empresas que se dedican a la fabricación de la mezcla de caliza y arcilla calcinada y molida, como Cemex y Holcim-Apasco.', 'descripcion2'=>'Empresas que comercializan cemento para la construcción, como tlapalerías y tiendas dedicadas a materiales para la construcción y mejoras del hogar, como Home Depot.', 'img' => 'cementera.png'], 
                           ['titulo' => 'Calera', 'descripcion' => 'Empresas que se dedican a la calcinación de piedra caliza para producir cal', 'descripcion2'=>'Empresas que solamente distribuyen o comercializan la cal, como tiendas de materiales de construcción', 'img' => 'calera.png'], 
                           ['titulo' => 'Automotriz', 'descripcion' => 'Empresas que se dedican a la fabricación de automóviles, incluyendo autopartes mecánicas o eléctricas. En general, cualquier manufacturera de autopartes es probable que sea de competencia federal. ', 'descripcion2'=>'Empresas que fabrican aditamentos para automóviles, que no son parte del automóvil, como son tapetes, cubiertas de muebles, etc. Empresas que diseñan o programan sistemas electrónicos para coches. Empresas de distribución y ventas de automóviles, como agencias automotrices.', 'img' => 'automotriz.png'], 
                           ['titulo' => 'Química', 'descripcion' => 'Empresas que se dedican a la fabricación de productos químicos, incluyendo la química farmacéutica y medicamentos. ', 'descripcion2'=>'Empresas que distribuyen o comercializan productos químicos o farmacéuticos, farmacias y laboratorios para estudios clínicos.', 'img' => 'quimica.png'], 
                           ['titulo' => 'De celulosa y papel', 'descripcion' => 'Empresas que se dedican a la producción de celulosa y papel, que producen pulpa, papel, cartón y otros productos a base de celulosa. ', 'descripcion2'=>'Empresas que se dedican a la distribución y comercialización de productos de papel, como papelerías o a la fabricación de cajas y material de embalaje en cartón y papel.', 'img' => 'celulosa.png'], 
                           ['titulo' => 'Aceites y grasas vegetales', 'descripcion' => 'Empresas que se dedican a la producción de aceites y grasas vegetales comestibles, extraídos de las oleaginosas, principalmente de soya, canola y cártamo.', 'descripcion2'=>'Empresas que distribuyen o comercializan aceites y grasas vegetales para empresas, tiendas, restaurantes, hoteles, etc.', 'img' => 'aceites.png'], 
                           ['titulo' => 'Productora de alimentos', 'descripcion' => 'Empresas que se dedican a la producción de alimentos, abarcando exclusivamente la fabricación de los que sean empacados, enlatados o envasados al alto vacío o que se destinen a ello.', 'descripcion2'=>'Empresas que no manufacturan ni producen, sino distribuyen o comercializan en una tienda, centro comercial u otra instancia o distribuye alimentos enlatados o envasados al alto vacío.', 'img' => 'alimentos.png'],
                           ['titulo' => 'Elaboradora de bebidas', 'descripcion' => 'Empresas que se dedican a la elaboración de bebidas que sean envasadas o enlatadas al alto vacío o que se destinen a ello, como Coca Cola y Jumex o que purifiquen agua para envasarla.', 'descripcion2'=>'Empresas que distribuyen o comercializan bebidas en un autoservicio, depósitos o alguna otra entidad.', 'img' => 'bebidas.png'], 
                           ['titulo' => 'Ferrocarrilera', 'descripcion' => 'Empresas ferrocarrileras, dedicadas a la industria ferroviaria, incluyendo las actividades de infraestructura, material rodante, señalización, control de tráfico, etc.', 'descripcion2'=>'Empresas que proveen servicios para ferrocarriles, como alimentos, servicios de limpieza, seguridad y combustibles.', 'img' => 'ferrocarrilera.png'], 
                           ['titulo' => 'Maderera', 'descripcion' => 'Empresas que se dedican a la madera básica, que comprende la explotación, extracción, corte y procesado de las maderas, para la producción de aserradero y la fabricación de triplay o aglutinados de madera.', 'descripcion2'=>'Puntos de venta al mayoreo o menudeo de productos de madera básica, empresas que utilizan la madera como insumo para fabricar muebles, casas, laminados de madera, etc.', 'img' => 'maderera.png'], 
                           ['titulo' => 'Vidriera', 'descripcion' => 'Empresas que se dedican a la fabricación de vidrio plano, liso o labrado o envases de vidrio, como Vitro.', 'descripcion2'=>'Puntos de venta al mayoreo o menudeo de productos de vidrio plano, liso, labrado o envases, empresas de construcción que utilizan e instalan vidrio para edificios o casas.', 'img' => 'vidriera.png'], 
                           ['titulo' => 'Tabacalera', 'descripcion' => 'Empresas que comprenden el beneficio o fabricación de productos de tabaco como Philip Morris o British American Tobacco México. ', 'descripcion2'=>'Puntos de venta al mayoreo o menudeo de productos de tabaco.', 'img' => 'tabacalera.png'], 
                           ['titulo' => 'Servicios banca y crédito', 'descripcion' => 'Empresas dedicadas a la Banca comercial, que ofrecen productos financieros como tarjetas bancarias, créditos bancarios, servicios de cuentas bancarias, créditos prendarios (como Nacional Monte de Piedad) etc. ', 'descripcion2'=>'Empresas financieras que no se dedican a la banca múltiple y de desarrollo, como las Sociedades Financieras de Objeto Múltiple (SOFOM), empresas de arrendamiento financiero, casas de bolsa.', 'img' => 'banca.png']];
         
        //dd($datosGaleria->sortBy('titulo'));
        $datosGaleria = collect($datosGaleria)->sortBy('titulo');
        
        
        return view('mapa.localiza-ccl',  compact("cclsUbicaciones", "sector_ccl", "sectores", "subsectores","ramas", "subramas", "estados", "datosGaleria"));
    }
    /**
     * metodo que muestra el CCL dado  el ambito Federal o Local
     */
    public function   tdrMapa(){       
        
        $cclsUbicaciones = \DB::table('general as t1')
            ->select('t1.id', 't1.empresa', 't1.latitud', 't1.longitud', 't1.municipio', 't1.estado','t1.fecha_estatus', 't1.estatus', 't1.sector', 't1.motivos_ficha', 't1.resultados_ficha', 't1.texto_ficha', 't1.link_solicitud_ustr', 't1.link_resultados_ustr')
            ->get();              
        
        $sector_ccl = \DB::table('sector_ccl as t1')
            ->select('t1.id', 't1.sector','t1.subsector', 't1.rama','t1.subrama', 't1.tipo')->get();   
        
        $estados = \DB::table('estados as t1')
            ->select('t1.clave', 't1.nombre', 't1.abreviacion', 't1.cp_min','t1.cp_max', 't1.lat','t1.long')->get();   

        $sectores =  $sector_ccl->unique('sector');
        $subsectores = $sector_ccl->unique('subsector');
        $ramas = $sector_ccl->unique('rama');
        $subramas = $sector_ccl->unique('subrama');

        $datosGaleria = [['titulo' => 'Textil', 'descripcion' => 'Empresas que se dedican a la fabricación de hilo y tela.', 'img' => 'textil.png'],
                           ['titulo' => 'Eléctrica', 'descripcion' => 'Centrales eléctricas dedicadas principalmente a la generación y distribución de energía eléctrica', 'img' => 'electrica.png'], 
                           ['titulo' => 'Cinematográfica', 'descripcion' => 'Empresas que se dedican a la producción, distribución y proyección de película', 'img' => 'cinematografica.png'], 
                           ['titulo' => 'Hulera', 'descripcion' => 'Entidades que se dedican al cultivo de la planta de guayule y a la extracción del hule de la planta. Empresas que se dedican a la fabricación de llantas.', 'img' => 'hulera.png'], 
                           ['titulo' => 'Azucarera', 'descripcion' => 'Empresas que se dedican a la producción de azúcar', 'img' => 'azucarera.png'], 
                           ['titulo' => 'Minera', 'descripcion' => 'Empresas dedicadas principalmente a la extracción de petróleo y gas, y a la explotación de minerales metálicos y no metálicos', 'img' => 'minera.png'], 
                           ['titulo' => 'Metalúrgica y siderúrgica', 'descripcion' => 'Empresas que se dedican a la explotación de minerales básicos, la fundición de los mismos, la obtención de hierro, acero y los productos laminados.', 'img' => 'metalurgica.png'], 
                           ['titulo' => 'Hidrocarburos', 'descripcion' => 'Empresas que se dedican a la producción de gasolina, diésel y gas', 'img' => 'hidrocarburos.png'], 
                           ['titulo' => 'Petroquímica', 'descripcion' => 'Empresas que se dedican a la extracción de combustibles fósiles. Empresas petroquímicas que transforman el gas natural y los derivados del petróleo.', 'img' => 'petroquimica.png'], 
                           ['titulo' => 'Cementera', 'descripcion' => 'Empresas que se dedican a la fabricación de la mezcla de caliza y arcilla calcinada y molida', 'img' => 'cementera.png'], 
                           ['titulo' => 'Calera', 'descripcion' => 'Empresas que se dedican a la calcinación de piedra caliza y/o que producen cal.', 'img' => 'calera.png'], 
                           ['titulo' => 'Automotriz', 'descripcion' => 'Empresas que se dedican a la fabricación de automóviles incluyendo autopartes mecánicas o eléctricas', 'img' => 'automotriz.png'], 
                           ['titulo' => 'Química', 'descripcion' => 'Empresas que se dedican a la fabricación de productos químicos, incluyendo la química farmacéutica y medicamentos', 'img' => 'quimica.png'], 
                           ['titulo' => 'De celulosa y papel', 'descripcion' => 'Empresas que producen pulpa, papel, cartón y otros productos a base de celulosa.', 'img' => 'celulosa.png'], 
                           ['titulo' => 'De aceites y grasas vegetales', 'descripcion' => 'Empresas que se dedican a la industria alimentaria, para producir aceite extraído de las oleaginosas, principalmente de soya, canola y cártam', 'img' => 'aceites.png'], 
                           ['titulo' => 'Productora de alimentos', 'descripcion' => 'Empresas que se dedican a la producción de alimentos, abarcando exclusivamente la fabricación de los que sean empacados, enlatados o envasados al alto vacío o que se destinen a ello.', 'img' => 'alimentos.png'],
                           ['titulo' => 'Elaboradora de bebidas', 'descripcion' => 'Empresas que se dedican a la elaboración de bebidas que sean envasadas o enlatadas al alto vacío o que se destinen a ello.', 'img' => 'bebidas.png'], 
                           ['titulo' => 'Ferrocarrilera', 'descripcion' => 'Empresas dedicadas a la industria ferroviaria, incluyendo las actividades de infraestructura, material rodante, señalización, control de tráfico, etc.', 'img' => 'ferrocarrilera.png'], 
                           ['titulo' => 'Maderera', 'descripcion' => 'Empresas que se dedican a la explotación, extracción, corte y procesado de las maderas para la fabricación de diversos productos.', 'img' => 'maderera.png'], 
                           ['titulo' => 'Vidriera', 'descripcion' => 'Empresas que se dedican a la fabricación exclusivamente de vidrio plano, liso o labrado o envases de vidrio.', 'img' => 'vidriera.png'], 
                           ['titulo' => 'Tabacalera', 'descripcion' => 'Empresas que se dedican a la fabricación de productos de tabaco', 'img' => 'tabacalera.png'], 
                           ['titulo' => 'Servicios de banca y crédito', 'descripcion' => 'Bancos que ofrecen productos financieros como tarjetas bancarias, créditos bancarios y servicios de cuentas bancaria', 'img' => 'banca.png']];
         
        //dd($cclsUbicaciones);
        //dd($cclsUbicaciones->where('fecha_estatus')->first()->fecha_estatus);
        //dd($cclsUbicaciones->where('fecha_estatus')->last()->fecha_estatus);

        return view('mapa.tdr-mapa',  compact("cclsUbicaciones", "sector_ccl", "sectores", "subsectores","ramas", "subramas", "estados"));
    }

    //Generar el PDF de una tarjeta
    public function generarPDF($id){
        $baseUrl = url('/');
        //dd($baseUrl."/img/logomapa.svg");
        Carbon::setLocale('es');
        
        $ccl = \DB::table('general as t1')
            ->select('t1.id', 't1.empresa', 't1.latitud', 't1.longitud', 't1.municipio', 't1.estado','t1.fecha_estatus', 't1.estatus', 't1.sector', 't1.motivos_ficha', 't1.resultados_ficha', 't1.texto_ficha', 't1.link_solicitud_ustr', 't1.link_resultados_ustr')
            ->where("t1.id", '=', $id)
            ->get();   
        $ccl = $ccl->toArray();
        $ccl = $ccl[0];
        //dd($ccl);
        $fecha = Carbon::parse($ccl->fecha_estatus);
        //dd($fecha . " " .$fecha->month );
        $meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
        $mes = $meses[$fecha->month - 1]; // Los meses en Carbon empiezan en 0
        $fechaFormateada = " $fecha->day  de  $mes del $fecha->year" ;

        $data = [
            'id'  => $ccl->id,
            'empresa' => $ccl->empresa,
            'latitud' => $ccl->latitud,
            'longitud' => $ccl->longitud,
            'municipio' => $ccl->municipio,
            'estado'   => $ccl->estado,
            'fecha_estatus' => $fechaFormateada,
            'estatus' => $ccl->estatus,
            'sector' => $ccl->sector,
            'motivos_ficha' => $ccl->motivos_ficha,
            'resultados_ficha' => $ccl->resultados_ficha,
            'texto_ficha' => $ccl->texto_ficha,
            'link_solicitud_ustr' => $ccl->link_solicitud_ustr,
            'link_resultados_ustr' => $ccl->link_resultados_ustr
        ];

        //$pdf->setBasePath(public_path()); // Establecer la ruta base a la carpeta "public"

        // Si la imagen está en la carpeta public/img:
        //$pdf->setBasePath(public_path('img')); // Establecer la ruta base a la carpeta "img" (dentro de public)
        //dd(public_path());
        $path = public_path('img/logomapa2.png');
        //dd($path);

        $pdf = Pdf::loadView('mapa.cardPdf', compact('data','path'))->setOptions(['defaultFont' => 'sans-serif',
            'letter' => 'landscape',
            'margin-top' => '10mm',
            'margin-right' => '10mm',
            'margin-bottom' => '10mm',
            'margin-left' => '10mm',
            'isPhpEnabled' => true
        ]);    
        
        return $pdf->download('Caso_MLRR.pdf');
        return view('mapa.cardPdf', compact('data'));
        //$pdf = PDF::loadView('mapa.cardPdf', compact('data')); // 'tu_vista_blade' es el nombre de tu vista
        //return $pdf->download('documento.pdf'); // Descargar el PDF
        return $pdf= PDF::loadView('mapa.cardPdf', compact('data'));
        // O puedes usar: return $pdf->stream('nombre_del_archivo.pdf'); para mostrar el PDF en el navegador
    }



    /*
     * Error Page Routs
     */

    public function error404(Request $request)
    {
        return view('errors.error404');
    }

    public function error500(Request $request)
    {
        return view('errors.error500');
    }
    public function maintenance(Request $request)
    {
        return view('errors.maintenance');
    }

    
}
