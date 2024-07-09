<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    //protected $redirectTo = RouteServiceProvider::LOGIN;

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function resetPassword($user, $password){

        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));
        $user->save();
        //event(new PasswordReset($user));
        //return redirect('login')->with('success', 'La contraseña se actualizó exitosamente');
        //return redirect()->route('login')->with('notification','¡La contraseña se actualizó exitosamente!');
        return redirect('/login')->with('success','¡La contraseña se actualizó exitosamente!');
    }


    public function rules()
    {
        return [
            'token'    => 'required',
            'email'    => 'required|string|email|max:255|ends_with:scjn.gob.mx,scjn.pjf.gob.mx,mail.scjn.gob.mx,cjf.gob.mx,mail.cjf.gob.mx',
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

        ];
    }

    public function validationErrorMessages()
    {
        return [
            'email.email'                   => "El correo electrónico debe tener una estructura valida, ej: usuario@domino.com",
            'email.ends_with'               => "El correo electrónico no es válido, se trata de un ingreso restringido", 
            'password.required'             => 'La contraseña es requerida',
            'password.confirmed'            => 'La contraseña debe coincidir',
            'password_confirmation.required'=> 'La confirmación de contraseña es requerida',
            'password.min'                  => 'La contraseña debe tener un mínimo de 8 caracteres',
            'password.max'                  => 'La contraseña debe tener un máximo de 8 caracteres',
            'password_confirmation.min'     => 'La confirmación de contraseña debe tener un mínimo de 8 caracteres',
            'password_confirmation.max'     => 'La confirmación de contraseña debe tener un máximo de 8 caracteres',
        ];
    }


    /**
     * Validación para el fomrulario de crear usuario de la SCJN
     *
     * @param \Illuminate\Http\Request $request
     * @return
     */
    private function validatorPssd(Request $request){

        //dd($request); 'email' => 'required|string|email|max:255|ends_with:scjn.gob.mx,cjf.gob.mx'
        $rules = [
            'email'                => 'required|string|email|max:255|ends_with:scjn.gob.mx,scjn.pjf.gob.mx,mail.scjn.gob.mx,cjf.gob.mx,mail.cjf.gob.mx',
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
}
