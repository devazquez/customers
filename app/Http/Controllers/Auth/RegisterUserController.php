<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
use App\Models\User;
use App\Models\DatosUser;
use App\Models\Vehiculo;
use App\Models\Edificio;
use App\Models\Area;
use App\Models\Color;
use Intervention\Image\Facades\Image;
use File;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\Password;

class RegisterUserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    //use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/';
    public $endPoint;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->endPoint ="http://psvseminterqa1.scjn.pjf.gob.mx:8185/directorio?";
    }

    /**
     * Desplegamos el formulario para registrar a un usuario en el sistema de huella de carbono
     */
    protected function showRegistrationForm($dependencia){
        
        //$catEdificios = Edificio::All();
        if($dependencia != "scjn" ){
            abort(404);
        }

        $catAreas = Area::All();
        $catEdificios = Edificio::where('dependencia_gob', $dependencia)->get();
        $dependencia = strtoupper($dependencia);
        
        //dd($catAreas);        
        return view('auth.register', compact('catEdificios', 'dependencia','catAreas'));
    }

    /**
     * Desplegamos el formulario para registrar a un usuario conductor
     */
    protected function showRegistrationPasajeroForm($dependencia){
        //dd($dependencia);
        //$catEdificios = Edificio::All();
        $tipoUsuario = 'P';
        return view('auth.registerPasajero', compact('tipoUsuario'));
    }
    
    /**
     * Desplegamos el formulario para registrar a un usuario conductor
     */
    protected function registerPublic(){
        //dd($dependencia);
        //$catEdificios = Edificio::All();
        return view('auth.registerPublic');
    }
    /**
     * Desplegamos el formulario para registrar a un usuario conductor
     */
    protected function registerPublicPost(Request $request){         
        $this->validatorUPublico($request);
        return redirect()->route('registrarUsuarioForm', $request->dependencia);            
    }
     /**
     * Creamos un usuario conductor desde formulario
     */
    protected function register(Request $request){
        //dd($request->all());
        //dd($request->nacimiento);        
        //dd(strtolower($request->email));

        $username = substr($request->email, 0, strpos($request->email, '@'));
        $username = strtolower($username);
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

        if($request->password != strip_tags($request->password)) {
            // contains HTML
            return back()->with('error',"Lo sentimos no se permiten ingresar etiquetas de HTML en la contraseña.");
        }
       
        $this->validatorUsuarioSCJN($request);        
        $datosSCJN =  json_decode($responseDASCJN)[0];    
        //dd($datosSCJN);

        //$catEdificios = Edificio::All();
        //dd($datosSCJN->cargo ." ".  $datosSCJN->numeroEmpleado . "  ". $datosSCJN->alcaldia . " " . trim($datosSCJN->nombre) . " ".  $datosSCJN->apellido1 . " " . $datosSCJN->apellido2 . " ".  $datosSCJN->idsexo . " " . $datosSCJN->cp . " " .  $datosSCJN->colonia . " " . $datosSCJN->edificio . " ". str_replace(',',' ',trim($datosSCJN->adscripcion)));
        
        $user = User::create([
            "name"               => trim($datosSCJN->nombre), 
            "email"              => strtolower($request->email),
            "password"           => Hash::make($request->password),
            "email_verified_at"  =>  Carbon::now(),
        ]);
        $user_id = User::select('id')->where('email', $request->email)->first();
        
        $datosuser = DatosUser::create([
            "user_id"              => $user_id->id,
            "cargo"                => trim($datosSCJN->cargo),
            "numero_trabajador"    => trim($datosSCJN->numeroEmpleado),
            "alcaldia"             => trim($datosSCJN->alcaldia),
            "nombres"              => trim($datosSCJN->nombre),
            "apellido1"            => trim($datosSCJN->apellido1),
            "apellido2"            => $datosSCJN->apellido2,
            "sexo"                 => $datosSCJN->idsexo,
            "cp"                   => $datosSCJN->cp,
            "colonia"              => trim($datosSCJN->colonia),
            "edificio"             => trim($datosSCJN->edificio),
            "area"                 => str_replace(',',' ',$datosSCJN->adscripcion),
        ]);
        
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
        }

        // termina verificacion del vehiculo en la tabla cat_vehiculos
        return redirect()->route('login')->with('success','¡Registro exitoso!');
        
        //return back()->with('error',"Lo sentimos el registro no se completo, favor de volver a intentarlo más tarde.");
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function view(){
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


    /**
     * Buscar la marca v1 usando ajax 
     */
     public function buscarMarcaV1($marcav1){
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
                'marcav1' => $marcav1,
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
    public function buscarSubMarcaV1($submarcav1, $marcav1){
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
                'anio' => '',
                'submarcav1_completo' => $submarcav1 ." no se encuentró en el catálogo. Continua llenando la información para agregarlo al sistema.",
            ]];
            return \response()->json($respuesta); 
        }
        return \response()->json($submarcas);
        //return $this->availableTags;
    }
    
    /**
     * Validar el tipo de usuario
    */
    private function validatorUPublico(Request $request){
        $rules = [
            'dependencia'    => 'required',            
        ];

        //custom validation error messages.
        $messages = [            
            'dependencia.required'  => 'Indicar la dependecia es requerido',            
        ];

        //validate the request.ss
        $request->validate($rules, $messages);
    }

    /**
     * Validación para el fomrulario de crear usuario de la SCJN
     *
     * @param \Illuminate\Http\Request $request
     * @return
     */
    private function validatorUsuarioSCJN(Request $request){

        //dd($request); 'email' => 'required|string|email|max:255|ends_with:scjn.gob.mx,cjf.gob.mx'
        $rules = [
            'email'                => 'required|string|email|max:255|unique:users|ends_with:scjn.gob.mx,scjn.pjf.gob.mx,mail.scjn.gob.mx,cjf.gob.mx,mail.cjf.gob.mx',
            'password' => [
                'required',
                'max:20',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            "password_confirmation" => "required|min:8|max:20|same:password",
            //'password'             => 'required|string|min:8|confirmed',
            //'password_confirmation'=> 'required|string|min:8',      
            
            
        ];

        //custom validation error messages.
        $messages = [
            'email.unique'                  => "El correo electrónico se encuentra registrado",
            'email.email'                   => "El correo electrónico debe tener una estructura valida, ej: usuario@domino.com",
            'email.ends_with'               => "El correo electrónico no es válido, se trata de un ingreso restringido", 
            'password.required'             => 'La contraseña es requerida',
            'password.confirmed'            => 'La contraseña debe coincidir',
            'password_confirmation.required'=> 'La confirmación de contraseña es requerida',
            'password.min'                  => 'La contraseña debe tener un mínimo de 8 caracteres',
            'password.max'                  => 'La contraseña debe tener un máximo de 8 caracteres',
            'password_confirmation.min'     => 'La confirmación de contraseña debe tener un mínimo de 8 caracteres',
            'password_confirmation.max'     => 'La confirmación de contraseña debe tener un máximo de 8 caracteres',
            //'manejoInformacion.required'    => 'Es requerido indicar que acepta el acuerdo de confidencialidad sobre el resguardo de datos personales',
        ];

        //validate the request.ss
        $request->validate($rules, $messages);
    }

     /**
     * Validación para el fomrulario de crear usuario conductor
     *
     * @param \Illuminate\Http\Request $request
     * @return
     */
    private function validatorUsuario(Request $request){

        //validation rules.
        $beforeNac = Carbon::now()->subYears(18)->format('Y-m-d');
        $afterNac  = Carbon::now()->subYears(100)->format('Y-m-d');
        //dd($dt. " ". $beforeNac. " ". $afterNac);

        //dd($request); 'email' => 'required|string|email|max:255|ends_with:scjn.gob.mx,cjf.gob.mx'
        $rules = [
            'name'                 => 'required|string|max:255|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/',
            'apellido1'            => 'required|string|max:255|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/',
            'apellido2'            => 'nullable|string|max:255|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/',
            'sexo'                 => 'required',
            'nacimiento'           => 'required|numeric|integer|min:1900|max:2024',
            'email'                => 'required|string|email|max:255|unique:users|ends_with:scjn.gob.mx,mail.scjn.gob.mx,cjf.gob.mx,mail.cjf.gob.mx',
            'password'             => 'required|string|min:8|confirmed',
            'password_confirmation'=> 'required|string|min:8',
            'alcaldia'             => 'nullable|string',
            'entidad_federativa'   => 'nullable|string',
            'edificio_id'          => 'required',
            'area_id'              => 'required',
            'numero_trabajador'    => 'required|numeric|unique:datosusers',
            'personascasa'         => 'required|numeric',
            'gascasa'              => 'required|string',
            'manejoInformacion'   => 'required',
        ];

        //custom validation error messages.
        $messages = [
            'name.regex'                    => 'El nombre debe estar compuesto solo por letras',
            'name.required'                 => 'El nombre es requerido',
            'apellido1.required'            => 'El primer apellido es requerido',
            'apellido1.regex'               => 'El apellido debe estar compuesto solo por letras',
            'apellido2.regex'               => 'El apellido debe estar compuesto solo por letras',
            'sexo.required'                 => 'El sexo es un campo requerido',
            'nacimiento.required'           => 'El año de nacimiento es requerido',
            'nacimiento.numeric'            => "El año debe ser numérico",
            'nacimiento.min'                => 'El año de nacimiento debe ser valido',
            'nacimiento.max'                => 'El año de nacimiento debe ser valido',
            'email.unique'                  => "El correo electrónico debe ser único",
            'email.email'                   => "El correo electrónico debe tener una estructura valida, ej: usuario@domino.com",
            'email.ends_with'               => "El correo electrónico no es válido, se trata de un ingreso restringido", 
            'password.required'             => 'La contraseña es requerida',
            'password.confirmed'            => 'La contraseña debe coincidir',
            'password_confirmation.required'=> 'La confirmación de contraseña es requerida',
            'password.min'                  => 'La contraseña debe tener un mínimo de 8 caracteres',
            'password_confirmation.min'     => 'La confirmación de contraseña debe tener un mínimo de 8 caracteres',
            'edificio_id.required'          => "El edificio de trabajo es requerido",
            'area_id.required'              => "El área de adscripción es requerida",

            'personascasa.required'         => "El número de personas con las vives en el mismo hogar es un campo obligatorio",
            'personascasa.numeric'          => "El número de personas con las vives en el mismo hogar debe ser numérico",
            'gascasa.required'              => "El tipo de gas que empleas en tu hogar es un campo obligatorio",
            'gascasa.string'                => "El tipo de gas que empleas en tu hogar debe ser una de las opciones desplegadas",

            'numero_trabajador.required'    => "El número de trabajador es requerido",
            'numero_trabajador.numeric'     => "El número de trabajador debe ser numérico",
            'numero_trabajador.unique'      => "El número de trabajador debe ser único",
            'manejoInformacion.required'    => 'Es requerido indicar que acepta el acuerdo de confidencialidad sobre el resguardo de datos personales',
        ];

        //validate the request.ss
        $request->validate($rules, $messages);
    }

    /**
     * Validación para el fomrulario de crear usuario Pasajero
     *
     * @param \Illuminate\Http\Request $request
     * @return
     */
    private function validatorUsuarioPasajero(Request $request){
        //validation rules.
        //dd($request); 'email' => 'required|string|email|max:255|ends_with:scjn.gob.mx,cjf.gob.mx'
        $beforeNac = Carbon::now()->subYears(18)->format('Y-m-d');
        $afterNac  = Carbon::now()->subYears(100)->format('Y-m-d');

        $rules = [
            'name'                 => 'required|string|max:255|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/',
            'apaterno'             => 'required|string|max:255|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/',
            'amaterno'             => 'required|string|max:255|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/',
            'sexo'                 => 'required',
            'nacimiento'           => 'required|date_format:Y-m-d|after:'.$afterNac.'|before:'.$beforeNac,
            'telefono'             => 'numeric|digits:10',
            'foto'                 => 'required|mimes:jpeg,jpg,png|max:2048',
            'credencial'           => 'required|mimes:jpeg,jpg,png|max:2048',
            'email'                => 'required|string|email|max:255|unique:users|ends_with:scjn.gob.mx,mail.scjn.gob.mx,cjf.gob.mx,mail.cjf.gob.mx',
            'password'             => 'required|string|min:8|confirmed',
            'password_confirmation'=> 'required|string|min:8',
            'calle'                => 'nullable|string',
            'colonia'              => 'nullable|string',
            'alcaldia'             => 'nullable|string',
            'entidad_federativa'   => 'nullable|string',
            'edificio_id'          => 'required',
            'codigo_postal'        => 'numeric',
            'ubicacion_domicilio'  => 'required|string',
            'area_id'              => 'required',
            'numero_trabajador'    => 'required|numeric|unique:datosusers',
            'hora_entrada'         => 'required|date_format:H:i',
            'hora_salida'          => 'required|date_format:H:i',            
        ];

        //custom validation error messages.
        $messages = [
            'name.regex'                    => 'El nombre debe estar compuesto solo por letras',
            'name.required'                 => 'El nombre es requerido',
            'apaterno.required'             => 'El apellido paterno es requerido',
            'apaterno.regex'                => 'El apellido paterno debe estar compuesto solo por letras',
            'amaterno.required'             => 'El apellido materno es requerido',
            'amaterno.regex'                => 'El apellido materno debe estar compuesto solo por letras',
            'sexo.required'                 => 'El sexo es un campo requerido',
            'nacimiento.required'           => 'La fecha de nacimiento es requerida',
            'nacimiento.date_format'        => 'La fecha de nacimiento debe tener el formato dd/mm/aaaa',
            'nacimiento.after'              => "La fecha de nacimiento debe ser valida",
            'nacimiento.before'             => 'La fecha de nacimiento debe ser valida',
            'telefono.numeric'              => 'El teléfono debe contener solo números',
            'telefono.digits'               => 'El teléfono debe contar con 10 digitos',
            'email.unique'                  => 'El correo electrónico debe ser único',
            'email.email'                   => 'El correo electrónico debe tener una estructura valida, ej: usuario@domino.com',
            'email.ends_with'               => 'El correo electrónico no es válido, se trata de un ingreso restringido', 
            'password.required'             => 'La contraseña es requerida',
            'password.confirmed'            => 'La contraseña debe coincidir',
            'password_confirmation.required'=> 'La confirmación de contraseña es requerida',
            'password.min'                  => 'La contraseña debe tener un mínimo de 8 caracteres',
            'password_confirmation.min'     => 'La confirmación de contraseña debe tener un mínimo de 8 caracteres',
            'foto.required'                 => 'La fotografía es requerida',
            'foto.mimes'                    => 'La fotografía debe ser en formato jpeg, jpg o png',
            'foto.max'                      => 'La fotografía debe pesar máximo 2MB',
            'credencial.required'           => 'La credencial es requerida',
            'credencial.mimes'              => 'La credencial debe ser en formato jpeg, jpg o png',
            'credencial.max'                => 'La credencial debe pesar máximo 2MB',
            'ubicacion_domicilio.required'  => 'La ubicación de lugar de interés recurrente es requerida',
            'codigo_postal.numeric'         => 'El código postal debe ser numérico',
            'edificio_id.required'          => 'El edificio de trabajo es requerido',
            'area_id.required'              => 'El área de adscripción es requerida',
            'numero_trabajador.required'    => 'El número de expediente es requerido',
            'numero_trabajador.numeric'     => 'El número de expediente debe ser numérico',
            'numero_trabajador.unique'      => 'El número de expediente debe ser único',
            'hora_entrada.required'         => 'La hora de entrada habitual es requerida',
            'hora_entrada.date_format'      => 'La hora de entrada habitual debe tener un formato de tipo hh:mm',
            'hora_salida.required'          => 'La hora de salida es requerida',
            'hora_salida.date_format'       => 'La hora de salida debe tener un formato de tipo hh:mm',
        ];

        //validate the request.ss
        $request->validate($rules, $messages);
    }
}
