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
use File;



class ActualizarFotoController extends Controller
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
    public function actualizarFoto(Request $request){
        //dd($request->foto);
        //dd(Hash::check($request->password_current, Auth::user()->password));
        $this->validator($request);
        if(Auth::user()->id == $request->user_id){
            $catEdificios = Edificio::All();        
            $rutaBase= storage_path()."/app/public";
            $datosuser = User::find(Auth::user()->id)->datosuser;
            //$datosuser = DatosUser::find(Auth::user()->id);
            //dd($datosuser->numero_trabajador);
            //armamos el archivo de la foto y la credencial
            $foto = $datosuser->numero_trabajador.'-foto.'.$request->file('foto')->getClientOriginalExtension();

            //dd($foto);
            if($catEdificios[$datosuser->edificio_id]->dependencia_gob == "SCJN"){
                //$pathFoto = $request->file('foto')->storeAs('scjn/'. $request->numero_trabajador, $foto, 'public');
                //$pathCredencial = $request->file('credencial')->storeAs('scjn/'. $request->numero_trabajador, $credencial, 'public');
                $rutaFoto = $rutaBase."/scjn/" . $datosuser->numero_trabajador . "/".$foto;
                
                $existsFoto = Storage::disk('public')->exists('scjn/'. $datosuser->numero_trabajador .'/'. $datosuser->foto);
                $existsDirectorio = Storage::disk('public')->exists('scjn/'. $datosuser->numero_trabajador);
                
                if(!$existsDirectorio){
                    $rutaDirectorio = $rutaBase."/scjn/" . $datosuser->numero_trabajador;
                    File::makeDirectory($rutaDirectorio, 0777, true, true);
                }
                if($existsFoto){
                    $borrar = Storage::disk('public')->delete('scjn/'. $datosuser->numero_trabajador .'/'. $datosuser->foto);
                }
                
                $pathFoto = Image::make($request->file('foto'))->resize(300, 300)->save($rutaFoto);
                
                $datosuser->foto = $foto;
                $datosuser->update();
                return back()->with('success',"Se actualizó la fotografía del usuario ". Auth::user()->name);

            }else{
                //$pathFoto = $request->file('foto')->storeAs('cfj/'. $request->numero_trabajador, $foto, 'public');
                //$pathCredencial = $request->file('credencial')->storeAs('cfj/'. $request->numero_trabajador, $credencial, 'public');
                $rutaFoto = $rutaBase."/cjf/". $datosuser->numero_trabajador . "/".$foto;
                $existsFoto = Storage::disk('public')->exists('cjf/'. $datosuser->numero_trabajador .'/'. $datosuser->foto);
                $existsDirectorio = Storage::disk('public')->exists('cjf/'. $datosuser->numero_trabajador);
                if(!$existsDirectorio){
                    $rutaDirectorio = $rutaBase."/cjf/" . $datosuser->numero_trabajador;
                    File::makeDirectory($rutaDirectorio, 0777, true, true);
                }
                if($existsFoto){
                    $borrar = Storage::disk('public')->delete('cjf/'. $datosuser->numero_trabajador .'/'. $datosuser->foto);
                }
                $pathFoto = Image::make($request->file('foto'))->resize(300, 300)->save($rutaFoto); 
                $datosuser->foto = $foto;
                $datosuser->update();
                return back()->with('success',"Se actualizó la fotografía del usuario ". Auth::user()->name);       
            }
        }else{
            return back()->with('error',"No se puede realizar la acción.");
        }
    }

    //reglas de validación de cambio de contraseña de un usuario
    protected function validator(Request $request)
    {
        $rules = [
            'foto' => 'required|mimes:jpeg,jpg,png|max:2048',
        ];
        $messages = [
            'foto.required' => "La fotografía es requerida",
            'foto.mimes'    => "La fotografía debe ser en formato jpeg, jpg o png",
            'foto.max'      => "La fotografía debe pesar máximo 2MB",
        ];
        return $request->validate($rules, $messages);
    }

}
