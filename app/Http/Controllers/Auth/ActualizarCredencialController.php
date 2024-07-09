<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use App\Models\User;
use App\Models\Edificio;
use App\Models\DatosUser;
use Carbon\Carbon;
use File;


class ActualizarCredencialController extends Controller
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
     * Actualizar fotografia de perfil de usuario
     */
    public function actualizarCredencial(Request $request){
        //dd($request->foto);
        //dd(Hash::check($request->password_current, Auth::user()->password));
        $this->validator($request);
        if(Auth::user()->id == $request->user_id){
            $catEdificios = Edificio::All();        
            $rutaBase= storage_path()."/app/public";
            //$datosuser = DatosUser::find(Auth::user()->id);
            $datosuser = User::find(Auth::user()->id)->datosuser;
            //armamos el archivo de la foto y la credencial
            $credencial = $datosuser->numero_trabajador.'-credencial.'.$request->file('credencial')->getClientOriginalExtension();

            //dd($foto);
            if($catEdificios[$datosuser->edificio_id]->dependencia_gob == "SCJN"){
                //$pathFoto = $request->file('foto')->storeAs('scjn/'. $request->numero_trabajador, $foto, 'public');
                //$pathCredencial = $request->file('credencial')->storeAs('scjn/'. $request->numero_trabajador, $credencial, 'public');
                $rutaCredencial = $rutaBase."/scjn/" . $datosuser->numero_trabajador . "/".$credencial;
                
                $existsDirectorio = Storage::disk('public')->exists('scjn/'. $datosuser->numero_trabajador);
                if(!$existsDirectorio){
                    $rutaDirectorio = $rutaBase."/scjn/" . $datosuser->numero_trabajador;
                    File::makeDirectory($rutaDirectorio, 0777, true, true);
                }
                $existsCredencial = Storage::disk('public')->exists('scjn/'. $datosuser->numero_trabajador .'/'. $datosuser->credencial);
                if($existsCredencial){
                    $borrar = Storage::disk('public')->delete('scjn/'. $datosuser->numero_trabajador .'/'. $datosuser->credencial);
                }
                
                $pathCredencial = Image::make($request->file('credencial'))->resize(600, 450)->save($rutaCredencial);
                
                $datosuser->credencial = $credencial;
                $datosuser->updated_at = Carbon::now();
                $datosuser->update();
                return back()->with('success',"Se actualizó la credencial del usuario ". Auth::user()->name);

            }else{
                //$pathFoto = $request->file('foto')->storeAs('cfj/'. $request->numero_trabajador, $foto, 'public');
                //$pathCredencial = $request->file('credencial')->storeAs('cfj/'. $request->numero_trabajador, $credencial, 'public');
                $rutaCredencial = $rutaBase."/cjf/". $datosuser->numero_trabajador . "/".$credencial;
                $existsDirectorio = Storage::disk('public')->exists('cjf/'. $datosuser->numero_trabajador);
                if(!$existsDirectorio){
                    $rutaDirectorio = $rutaBase."/cjf/" . $datosuser->numero_trabajador;
                    File::makeDirectory($rutaDirectorio, 0777, true, true);
                }
                $existsCredencial = Storage::disk('public')->exists('cjf/'. $datosuser->numero_trabajador .'/'. $datosuser->credencial);
                if($existsCredencial){
                    $borrar = Storage::disk('public')->delete('cjf/'. $datosuser->numero_trabajador .'/'. $datosuser->credencial);
                }
                $pathCredencial = Image::make($request->file('credencial'))->resize(600, 450)->save($rutaCredencial); 
                $datosuser->credencial = $credencial;
                $datosuser->updated_at = Carbon::now();
                $datosuser->update();
                return back()->with('success',"Se actualizó la credencial del usuario ". Auth::user()->name);       
            }
        }else{
            return back()->with('error',"No se puede realizar la acción.");
        }
    }

    //reglas de validación de cambio de contraseña de un usuario
    protected function validator(Request $request)
    {
        $rules = [
            'credencial' => 'required|mimes:jpeg,jpg,png|max:2048',
        ];
        $messages = [
            'credencial.required' => "La credencial es requerida",
            'credencial.mimes'    => "La credencial debe ser en formato jpeg, jpg o png",
            'credencial.max'      => "La credencial debe pesar máximo 2MB",
        ];
        return $request->validate($rules, $messages);
    }

}
