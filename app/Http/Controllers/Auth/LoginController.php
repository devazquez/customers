<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Edificio;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    use ThrottlesLogins;


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    public $endPoint;
    public $maxAttemps = 3;
    public $decayMinutes= 10;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->endPoint ="http://psvseminterqa1.scjn.pjf.gob.mx:8185/directorio?";
    }

    /**
     * Login the admin.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    
    public function login(Request $request){
        $username = substr($request->email, 0, strpos($request->email, '@'));
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
        
         // Attempt to log the user in

        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // if successful, then redirect to their intendd location
            //creamos una variable de sesion para mantener información importante del usuario
            $datosuser = User::where('email',$request->email)->first()->datosuser;
            //$edificio = Edificio::find($datosuser->edificio_id);
            //$dependenciaGob = strtolower($edificio->dependencia_gob);

            //dd($datosuser[0]->nombre);
            Session::put('datosUser', $datosuser);
            //Session::put('depGob', $dependenciaGob );            
            
            Session::save(); 
            //return redirect()->intended(route('viajescompartidospublico.viajesida'))->with('success','¡Hola usuario: '. $datosuser->nombre .' iniciaste sesión exitosamente!');
            //return redirect()->intended(route('viajescompartidospublico.viajesida'));
            return redirect()->intended(route('profile.show'));
            
        }else{
            return $this->loginFailed();
            return redirect()->intended(route('login'))->with('warning', 'La contraseña es incorrecta.');
        }
        return $this->loginFailed();
    }
    
    /**
     * Redirect back after a failed login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginFailed(){
        
        return redirect()
            ->back()
            ->withInput()
            ->with('error','No se puedo iniciar sesión, la contraseña ingresada es incorrecta');
    }

      /**
     * Logout the admin.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        //Auth::guard('web')->logout(); // se comento
        //Session::flush();             // se comento
        //return redirect()->intended(route('login'))->with('info','Saliste del sistema de viajes compartidos');

        /*Auth::guard('web')->logout();
        Session::flush();
        header("cache-Control:no-store,no-cache, must-revalidate");
        header("cache-Control:post-check=0,pre-check=0",false);
        Session::flush();
        Session::regenerate();
        return redirect()->back();*/

        Auth::guard('web')->logout();
        header("cache-Control:no-store,no-cache, must-revalidate");
        header("cache-Control:post-check=0,pre-check=0",false);
        $cookie = \Cookie::forget('first_time');
        Session::flush();
        Session::regenerate();  
        $request->session()->invalidate();

        return redirect()->back()->withCookie($cookie);
        
        //return $this->loggedOut($request) ?: redirect('/')->withCookie($cookie);
        //return redirect()->intended(route('login'));
    }

    public function sendFailedLoginResponse(Request $request)
    {   
        $attempts = session()->get('login.attempts', 0); // obtener intentos, default: 0
        if ($attempts<=2) {
        session()->put('login.attempts', $attempts + 1); // incrementrar intentos
        return redirect()->back()->with('status','intento :'.$attempts);
        }
    }
 
/**
 * Determine if the user has too many failed login attempts.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return bool
 */
protected function hasTooManyLoginAttempts(Request $request)
{
    $attempts = 5;
    $lockoutMinites = 10;
    return $this->limiter()->tooManyAttempts(
        $this->throttleKey($request), $attempts, $lockoutMinites
    );
}

            
    protected function loggedOut(Request $request)
    {
         $cookie = \Cookie::forget('first_time');

         return redirect('/')->withCookie($cookie);
    }

    
     /**
     * Validate the form data.
     *
     * @param \Illuminate\Http\Request $request
     * @return
     */
    private function validator(Request $request)
    {
        //validation rules.
        
        $rules = [
            'email'     => 'required|string|email|max:255|exists:users|ends_with:mail.scjn.gob.mx,scjn.gob.mx,cjf.gob.mx, mail.cjf.gob.mx',
            'password'  => 'required|string|min:8',
        ];

        //custom validation error messages.
        $messages = [
            'email.exists'                  => "El correo no existe en este sistema, favor de realizar un registro",
            'email.email'                   => "El correo electrónico debe tener una estructura valida, ej: usuario@domino.com",
            'email.ends_with'               => "El correo electrónico no es válido, se trata de un ingreso restringido", 
            'password.required'             => 'Es necesario ingresar su contraseña',
            'password.min'                  => 'El tamaño de la contraseña debe ser mayor o igual a 8 caracteres',
        ];

        //validate the request.

        return  $request->validate($rules, $messages);

    }

}
