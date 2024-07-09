<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;
use App\Models\User;
use Illuminate\Validation\Rules\Password;

class ActualizarContraseniaController extends Controller
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

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Actualizar contraseña
     * @param contraseña actual
     * @param nueva contraseña
     * @param confirmacion de nueva contraseña
     */
    public function actualizarContrasenia(Request $request){
        //dd(Hash::check($request->password_current, Auth::user()->password));
        if(Hash::check($request->password_current, Auth::user()->password)){            
            if($request->password != strip_tags($request->password)) {
                // contains HTML
                return back()->with('error',"Lo sentimos no se permiten ingresar etiquetas de HTML en la contraseña.");
            }
            if (Hash::check($request->password, Auth::user()->password)) {
                return back()->with('error', "La contraseña nueva no puede ser la misma que la contraseña actual");
            }
            $this->validator($request);
            
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->password);
            $user->update();
            return back()->with('success',"Se actualizó la contraseña del usuario ". Auth::user()->name);
        }else{
            return back()->with('error',"La contraseña actual no coincide con la registrada");
        }
    }

    //reglas de validación de cambio de contraseña de un usuario
    protected function validator(Request $request)
    {
        $rules = [
            
            //'password'              => 'required|string|min:8|confirmed',
            //'password_confirmation' => 'required|string|min:8',
            'password_current'      => 'required|string|min:8',
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
        $messages = [
            'password_current.required'       => 'La contraseña actual es requerida',
            'password.required'               => 'La contraseña nueva es requerida',
            'password.mixed'                  => 'La contraseña debe contener al menos una letra mayúscula y una minúscula',
            'password.confirmed'              => 'La contraseña nueva debe coincidir',
            'password_confirmation.required'  => 'La confirmación de contraseña nueva es requerida',
            'password.uncompromised'          => 'La contraseña proporcionada se ha visto comprometida en una filtración de datos. Elija una contraseña diferente.',
            'password_current.min'            => 'La contraseña actual debe tener un mínimo de 8 caracteres',
            'password.min'                  => 'La contraseña nueva debe tener un mínimo de 8 caracteres',
            'password.max'                  => 'La contraseña nueva debe tener un máximo de 20 caracteres',
            'password_confirmation.min'     => 'La confirmación de contraseña nueva debe tener un mínimo de 8 caracteres',
            'password_confirmation.max'     => 'La confirmación de contraseña nueva debe tener un máximo de 20 caracteres',
        ];
        return $request->validate($rules, $messages);
    }

}
