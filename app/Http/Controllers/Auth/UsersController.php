<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Carbon\Carbon;
use Hash;
use App\Models\DatosUser;
use App\Models\User;
use App\Models\Edificio;
use App\Models\Vehiculo;
use App\Models\Color;
use App\Models\Area;
use App\Models\ViajeCompartido;
use Illuminate\Support\Facades\Http;



class UsersController extends Controller
{
  
    public $endPoint;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->endPoint ="http://psvseminterqa1.scjn.pjf.gob.mx:8185/directorio?";
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {
        //dd(Auth::user()->id);
        $datosuser = User::find(Auth::user()->id)->datosuser;
        if($datosuser->datosiniciales == 0){
            return redirect()->route('formdatosiniciales');
        }
        //dd($datosuser->numero_trabajador);
        //$sql = "select * from Directorio where PERNR ='$datosuser->numero_trabajador' ";
        //if( empty(DB::connection('sqlsrv')->select($sql)) ){
        //    dd("vacio");
        //}
        //dd($datosuser);
        
        Carbon::setLocale('es');
        $fechaRegistro = Carbon::parse($datosuser->created_at)->diffForHumans();
        $user = User::find(Auth::user()->id);

        $username = substr($user->email, 0, strpos($user->email, '@'));
        try {
            $responseDASCJN = Http::get($this->endPoint, [
                'correo' => $username,            
            ]);
            if(empty(json_decode($responseDASCJN))){
                return back()->with('error',"Lo sentimos no encontramos esa cuenta en la SCJN.");
            }            
        } catch (Exception $e) {
            return $e;
        }       
                
        $datosSCJN =  json_decode($responseDASCJN)[0];   
        /*
        if( empty($datosuser->edificio)){
            $datosuser->edificio = $datosSCJN->edificio;
            $datosuser->update();
        }
        if( empty($datosuser->cargo)){
            $datosuser->cargo = $datosSCJN->cargo;
            $datosuser->update();
        }
        if( empty($datosuser->area)){
            $datosuser->area = $datosSCJN->adscripcion;
            $datosuser->update();
        }
        if( empty($datosuser->colonia)){
            $datosuser->colonia = $datosSCJN->colonia;
            $datosuser->update();
        }
        if( empty($datosuser->cp)){
            $datosuser->cp = $datosSCJN->cp;
            $datosuser->update();
        }*/
        //dd($datosuser);
        //dd($datosSCJN);
        //$edificio = Edificio::find($datosuser->edificio_id);
        //$catEdificios = Edificio::where('dependencia_gob', $edificio->dependencia_gob)->get();
        //$catEdificios = Edificio::All();
        //$dependenciaGob = strtolower($edificio->dependencia_gob);
        $catAreas = Area::All();
        $nacimiento = $datosuser->nacimiento;
        //$nacimiento = Carbon::createFromFormat('Y-m-d', $datosuser->nacimiento);   
        //$nacimiento =  Carbon::createFromFormat('dmY', $datosuser->nacimiento)->format('Y-m-d');  
        //dd($user->id);
        return view('profile.show_profile', compact('datosuser', 'user',  'fechaRegistro',  'catAreas', 'nacimiento'));        
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DatosUser  $datosUser
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $this->validatorUpdate($request);
        //dd($request->all());
        //$datosUser = DatosUser::find(Auth::user()->id);
        $this->validator($request);
        
        $datosUser = User::find(Auth::user()->id)->datosuser;
            
        $nacimiento = $request->nacimiento;
        $user = User::find(Auth::user()->id);
        $user->name = $request->nombre;
        $user->update();
        $datosUser->personas_casa  = $request->personascasa + 1 ;
        $datosUser->gas_casa = $request->gascasa;
        $datosUser->pago_luz = $request->pagoluz;
        $datosUser->pago_gas = $request->pagogas;
        $datosUser->distancia = $request->distancia;
        $datosUser->update();

        //return redirect()->action('${App\Http\Controllers\HomeController@index}', ['parameterKey' => 'value']);
        return back()->with('success',"Se actualizó el perfil del usuario $user->name");
        //dd($request->all());
    }


    /**
     * Buscar la marca v1 usando ajax 
     */
    public function perfilBuscarMarcaV1($marcav1){
        \DB::statement("SET SQL_MODE=''");
        $marcas=\DB::table('cat_vehiculos')
        ->select('id','marca','modelo', 'anio', 'marca as marcav1_completo',
            DB::raw("CONCAT(marca, ' ',modelo) as marcav1_submarcav1"), )
        ->where([[DB::raw("CONCAT(marca, ' ',modelo )"),'like','%'.$marcav1.'%'],['estado','=','1']])
        ->orderBy('modelo','asc')
        ->groupBy('marca')
        ->get();

        // No se encuentra el profesor
        if($marcas->isEmpty()){    
            $respuesta = [[
                'marca' => '',
                'modelo' => '',
                'anio' => '',
                'emisiones' => '',
                'estado'  => '',
                'marcav1_completo' => $marcav1 ." no se encuentró en el catálogo. Continua llenando los campos para agregarlo al sistema.",
            ]];
            return \response()->json($respuesta); 
        }
        return \response()->json($marcas);
        //return $this->availableTags;
    }
    /**
     * Buscar la marca v1 usando ajax 
     */
    public function perfilBuscarSubMarcaV1($submarcav1, $marcav1){
        \DB::statement("SET SQL_MODE=''");
        $submarcas=\DB::table('cat_vehiculos')
        ->select('id','marca','modelo', 'anio', 'modelo as submarcav1_completo')
        ->where([["modelo",'like','%'.$submarcav1.'%'],["marca", "=", $marcav1]])
        ->orderBy('modelo','asc')
        ->groupBy('modelo')
        ->get();

        // No se encuentra el profesor
        if($submarcas->isEmpty()){    
            $respuesta = [[
                'marca' => '',
                'modelo' => '',
                //'modelo' => $submarcav1 ." no se encuentró en el catálogo. Continua llenando la información para agregarlo al sistema.",
                'anio' => '',
                'submarcav1_completo' => $submarcav1 ." no se encuentró en el catálogo. Continua llenando la información para agregarlo al sistema.",
            ]];
            return \response()->json($respuesta); 
        }
        return \response()->json($submarcas);
        //return $this->availableTags;
    }

    /**
     * Funcion para eliminar la cuenta de un usuario, se confirma la contraseña del usuario y se realiza la eliminación logica del usuario
     * @param \Illuminate\Http\Request $request
     * 
     */
    public function eliminarCuenta(Request $request){        
        $this->validatorEliminarCuenta($request);
        if(Hash::check($request->password, Auth::user()->password)){
            $whereData = [['user_id',  Auth::user()->id],  ['status_viaje_id', '<', '4']];
            //$viajesUsuario = ViajeCompartido::where($whereData)->whereBetween('fecha_hra_partida', [$fechaPartidaOrigen, $fechaPartidaOrigen2])->get();
            $viajesUsuario = ViajeCompartido::where($whereData)->get();
            if(count($viajesUsuario) > 0){
                return back()->with('error',"Para continuar el proceso, primero debes eliminar tus viajes compartidos vigentes.");
            }
            $user = User::find(Auth::user()->id);
            $cuentas = User::where("email", 'like', '%'. $user->email .'%')->get();
            $cntCuentas = count($cuentas) +1;                        
            $datosUser = User::find(Auth::user()->id)->datosuser; 
            $user->email = "des
            'codigo_postal'        => 'required|regex:/^(?:\d{5})$/i', activado-".$cntCuentas."-".$user->email;
            $user->password = Hash::make("11235813");           
            $user->name = "desconocido";
            $user->update();
            $datosUser->nombre = "desconocido";
            $datosUser->apaterno = "desconocido";
            $datosUser->amaterno = "desconocido";
            $datosUser->calle = "cuenta eliminada";
            $datosUser->colonia = "cuenta eliminada";
            $datosUser->alcaldia = "cuenta eliminada";
            $datosUser->codigo_postal = "00000";
            $datosUser->numero_trabajador = $cntCuentas."d".$datosUser->numero_trabajador;
            $datosUser->update();
            //dd($request->all());
            // Log the user out
            Auth::logout();
            return redirect('/login')->with('success',"Cuenta eliminada exitosamente");
            //$user->password = Hash::make($request->password);
            //$user->update();
            //return back()->with('success',"Se actualizó la contraseña del usuario ". Auth::user()->name);
        }else{
            return back()->with('error',"La contraseña no coincide con la registrada. No se puede continuar con el proceso");
        }
        //dd($request->all());
    }
     /**
     * Validación para el fomrulario de actualizacion de datos del usuario
     *
     * @param \Illuminate\Http\Request $request
     * @return
     */
    private function validator(Request $request){
        //validation rules.
        //dd($request);
        $beforeNac = Carbon::now()->subYears(18)->format('Y-m-d');
        $afterNac  = Carbon::now()->subYears(100)->format('Y-m-d');
        $rules = [
            'nombre'               => 'required|string|max:255|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/',
            'apaterno'             => 'required|string|max:255|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/',
            'amaterno'             => 'required|string|max:255|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/',
            'sexo'                 => 'required',
            'nacimiento'           => 'required|date_format:Y-m-d|after:'.$afterNac.'|before:'.$beforeNac,
            'telefono'             => 'numeric|digits:10',
            'email'                => 'required|string|email|max:255|unique:users|ends_with:scjn.gob.mx,mail.scjn.gob.mx,cjf.gob.mx',
            'calle'                => 'nullable|string',
            'colonia'              => 'nullable|string',
            'alcaldia'             => 'nullable|string',
            'entidad_federativa'   => 'nullable|string',
            'codigo_postal'        => 'digits:5',
            'ubicacion_domicilio'  => 'required|string',
            'area_id'              => 'required',
            'numero_trabajador'    => 'required|numeric',
            'hora_entrada'         => 'required|date_format:H:i',
            'hora_salida'          => 'required|date_format:H:i',
            'color_v1'             => 'required',
            'placa_v1'             => 'required|string|min:3|max:10',
            'marca_v1'             => 'required|string',
            'submarca_v1'          => 'required|string',
            'asientos_disp_v1'     => 'required|numeric',
            'color_v2'             => 'nullable',
            'placa_v2'             => 'nullable|string|min:3|max:10',
            'marca_v1'             => 'nullable|string',
            'submarca_v1'          => 'nullable|string',
            'asientos_disp_v2'     => 'nullable|numeric',
            'cobertura_seg_vig'    => 'required',
            'licencia_cond_vig'    => 'required',
            'tarjeta_circ_vig'     => 'required',
            'verificacion_veh_vig' => 'required',
            'no_impedimento_med'   => 'required',
        ];

        //custom validation error messages.
        $messages = [
            'nombre.regex'                  => "El nombre debe estar compuesto solo por letras",
            'nombre.required'               => "El nombre es requerido",
            'apaterno.required'             => "El apellido paterno es requerido",
            'apaterno.regex'                => "El apellido paterno debe estar compuesto solo por letras",
            'amaterno.required'             => "El apellido materno es requerido",
            'amaterno.regex'                => "El apellido materno debe estar compuesto solo por letras",
            'sexo.required'                 => "El sexo es un campo requerido",
            'nacimiento.required'           => 'La fecha de nacimiento es requerida',
            'nacimiento.date_format'        => "La fecha de nacimiento debe tener el formato dd/mm/aaaa",
            'nacimiento.after'              => 'La fecha de nacimiento debe ser valida',
            'nacimiento.before'             => 'La fecha de nacimiento debe ser valida',
            'telefono.numeric'              => "El teléfono debe contener solo números",
            'telefono.digits'               => "El teléfono debe contar con 10 digitos",
            'email.unique'                  => "El correo electrónico debe ser único",
            'email.email'                   => "El correo electrónico debe tener una estructura valida, ej: usuario@domino.com",
            'calle.required'                => "La calle es requerida",
            'colonia.required'              => "La colonia es requerida",
            'alcaldia.required'             => "La alcaldia es requerida",
            'entidad_federativa.required'   => "La entidad federativa  es requerida",
            'codigo_postal.numeric'         => "El código postal debe ser numérico",
            'ubicacion_domicilio.required'  => 'La ubicación de lugar de interés recurrente es requerida',
            'area_id.required'              => "El área de adscripción es requerida",
            'numero_trabajador.required'    => "El número de expediente es requerido",
            'numero_trabajador.numeric'     => "El número de expediente debe ser numérico",
            'hora_entrada.required'         => "La hora de entrada habitual es requerida",
            'hora_entrada.date_format'      => "La hora de entrada habitual debe tener un formato de tipo hh:mm",
            'hora_salida.required'          => "La hora de salida es requerida",
            'hora_salida.date_format'       => "La hora de salida debe tener un formato de tipo hh:mm",
            'placa_v1.min'                  => "El tamaño de la placa 1 es muy pequeña",
            'placa_v2.min'                  => "El tamaño de la placa 2 es muy pequeña",
            'placa_v1.max'                  => "El tamaño de la placa 1 es muy grande",
            'placa_v2.max'                  => "El tamaño de la placa 2 es muy grande",
            'color_v1.required'             => "El color del vehículo 1 es requerido",
            'marca_v1.required'             => "La marca del vehículo 1 es requerida",
            'submarca_v1.required'          => "La submarca del vehículo 1 es requerida",
            'asientos_disp_v1.required'     => "Los asientos disponibles del vehículo 1 son requeridos",
            'asientos_disp_v1.numeric'      => "Los asientos disponibles del vehículo 1 deben ser numéricos",
            'asientos_disp_v2.numeric'      => "Los asientos disponibles del vehículo 2 deben ser numéricos",
            'cobertura_seg_vig.required'    => "Es requerido indicar que cuentas con cubertura de seguro vigente",
            'licencia_cond_vig.required'    => "Es requerido indicar que cuentas con la tarjeta de circulación vigente",
            'tarjeta_circ_vig.required'     => "Es requerido indicar que cuentas con tarjeta de circulación vigente",
            'verificacion_veh_vig.required' => "Es requerido indicar que cuentas con verificación vehicular vigente",
            'no_impedimento_med.required'   => "Es requerido indicar que no tiene impedimento médico alguno para conducir",
        ];

        //validate the request.ss
        $request->validate($rules, $messages);
    }

    /**
     * Validación para el fomrulario de actualizacion de datos del usuario
     *
     * @param \Illuminate\Http\Request $request
     * @return
     */
    private function validatorUpdate(Request $request){
        //validation rules.
        //dd($request);
        $rules = [
            'personascasa'     => 'required|numeric|gt:0',            
            'gascasa'          => 'required|string',       
            'pagoluz'          => 'required|date_format:Y-m-d',     
            'pagogas'          => 'required|date_format:Y-m-d',     
            'distancia'        => 'required|numeric|gt:0',
            'manejoInformacion'=> 'required',
        ];

        //custom validation error messages.
        $messages = [
            'personascasa.required'       => "La cantidad de personas es requerida",  
            'personascasa.gt'             => "La cantidad de personas debe ser mayor a 0",  
            'gascasa.required'            => "El tipo de gas en casa es un campo requerido",  
            'pagoluz.required'            => "La fecha de pago de luz es requerido",            
            'pagogas.required'            => "La fecha de pago de gas es requerida",   
            'distancia.required'          => "La distancia de tu domicilio al edificio de trabajo  es requerido",
            'distancia.numeric'           => "La distancia de tu domicilio al edificio de trabajo debe ser numérica", 
            'distancia.gt'                => "La distancia de tu domicilio al edificio de trabajo debe ser mayor a cero",            
            'manejoInformacion.required'  => 'De aceptar el aviso de privacidad para continuar',
        ];

        //validate the request.ss
        $request->validate($rules, $messages);
    }

    /**
     * Validación para el fomrulario de actualizacion de datos del usuario
     *
     * @param \Illuminate\Http\Request $request
     * @return
     */
    private function validatorUpdatePasajero(Request $request){
        //validation rules.
        //dd($request);
        $beforeNac = Carbon::now()->subYears(18)->format('Y-m-d');
        $afterNac  = Carbon::now()->subYears(100)->format('Y-m-d');

        $rules = [
            'nombre'               => 'required|string|max:255|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/',
            'apaterno'             => 'required|string|max:255|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/',
            'amaterno'             => 'required|string|max:255|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/',
            'sexo'                 => 'required',
            'nacimiento'           => 'required|date_format:Y-m-d|after:'.$afterNac.'|before:'.$beforeNac,
            'telefono'             => 'numeric|digits:10',
            'email'                => 'string|email|max:255',
            'calle'                => 'nullable|string',
            'colonia'              => 'nullable|string',
            'alcaldia'             => 'nullable|string',
            'entidad_federativa'   => 'nullable|string',
            'codigo_postal'        => 'numeric',
            'ubicacion_domicilio'  => 'required|string',
            'area_id'              => 'required',
            'numero_trabajador'    => 'required|numeric',
            'hora_entrada'         => 'required|date_format:H:i',
            'hora_salida'          => 'required|date_format:H:i',
        ];

        //custom validation error messages.
        $messages = [
            'nombre.regex'                  => 'El nombre debe estar compuesto solo por letras',
            'nombre.required'               => 'El nombre es requerido',
            'apaterno.required'             => 'El apellido paterno es requerido',
            'apaterno.regex'                => 'El apellido paterno debe estar compuesto solo por letras',
            'amaterno.required'             => 'El apellido materno es requerido',
            'amaterno.regex'                => 'El apellido materno debe estar compuesto solo por letras',
            'sexo.required'                 => 'El sexo es un campo requerido',
            'nacimiento.required'           => 'La fecha de nacimiento es requerida',
            'nacimiento.date_format'        => "La fecha de nacimiento debe tener el formato dd/mm/aaaa",
            'nacimiento.after'              => 'La fecha de nacimiento debe ser valida',
            'nacimiento.before'             => 'La fecha de nacimiento debe ser valida',
            'telefono.numeric'              => "El teléfono debe contener solo números",
            'telefono.digits'               => "El teléfono debe contar con 10 digitos",
            'email.unique'                  => "El correo electrónico debe ser único",
            'email.email'                   => "El correo electrónico debe tener una estructura valida, ej: usuario@domino.com",
            'calle.required'                => 'La calle es requerida',
            'colonia.required'              => 'La colonia es requerida',
            'alcaldia.required'             => 'La alcaldia es requerida',
            'entidad_federativa.required'   => 'La entidad federativa  es requerida',
            'codigo_postal.numeric'         => 'El código postal debe ser numérico',
            'ubicacion_domicilio.required'  => 'La ubicación de lugar de interés recurrente es requerida',
            'area_id.required'              => "El área de adscripción es requerida",
            'numero_trabajador.required'    => "El número de expediente es requerido",
            'numero_trabajador.numeric'     => "El número de expediente debe ser numérico",
            'hora_entrada.required'         => "La hora de entrada habitual es requerida",
            'hora_entrada.date_format'      => "La hora de entrada habitual debe tener un formato de tipo hh:mm",
            'hora_salida.required'          => "La hora de salida es requerida",
            'hora_salida.date_format'       => "La hora de salida debe tener un formato de tipo hh:mm",
        ];

        //validate the request.ss
        $request->validate($rules, $messages);
    }

    private function validatorEliminarCuenta(Request $request){
        
        //dd($request); 'email' => 'required|string|email|max:255|ends_with:scjn.gob.mx,cjf.gob.mx'
        $rules = [
            'password'             => 'required|string|min:8|confirmed',
            'password_confirmation'=> 'required|string|min:8',
        ];
        //custom validation error messages.
        $messages = [
            'password.required'             => 'La contraseña es requerida',
            'password.confirmed'            => 'La contraseña debe coincidir',
            'password_confirmation.required'=> 'La confirmación de contraseña es requerida',
        ];

        //validate the request.ss
        $request->validate($rules, $messages);
    }
}
