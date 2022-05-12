<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use Inertia\Inertia;
//MODELS
use App\Models\Usuario;
use App\Models\Permiso;
use App\Models\Permiso_usuario;


class PrincipalController extends Controller
{
    public function Login()
    {
        session()->forget('usuario_dni');
        session()->forget('nombres');
        session()->forget('usuario');
        session()->forget('clave');
        session()->forget('id_sede');
        session()->forget('nombre_sede');
        session()->forget('nombre_cargo');
        // return view('welcome');

        return view('login');
        // return  redirect()->route('prin.welcome');
    }

    public function validarUsuario(Request $request)
    {
        $usuario = $request->usuario;
        $clave = $request->clave;
        $validando_usuario = Usuario::select(
            'usuario',
            'clave',
            'nombres',
            'dni',
            'apellidoPaterno',
            'apellidoMaterno',
            'telefono',
            'id_sede',
            's.sedes as nombre_sede',
            'ca.cargo as nombre_cargo'
        )
            ->join('sedes as s', 'usuarios.id_sede', '=', 's.id')
            ->join('cargos as ca', 'usuarios.id_cargo', '=', 'ca.id')
            ->where('usuario', $usuario)
            ->get();
        if (count($validando_usuario) == 1) {
            if ($clave == $validando_usuario[0]['clave']){
                $usuario_encontrado = $validando_usuario[0];
                $dni = $usuario_encontrado['dni'];
                $nombres = $usuario_encontrado['nombres'] . " " . $usuario_encontrado['apellidoPaterno'] . " " . $usuario_encontrado['apellidoMaterno'];
                $usuario = $usuario_encontrado['usuario'];
                $clave = $usuario_encontrado['clave'];
                $id_sede = $usuario_encontrado['id_sede'];
                $nombre_sede = $usuario_encontrado['nombre_sede'];
                $nombre_cargo = $usuario_encontrado['nombre_cargo'];
                session(['usuario_dni' => $dni]);
                session(['nombres' => $nombres]);
                session(['usuario' => $usuario]);
                session(['clave' => $clave]);
                session(['id_sede' => $id_sede]);
                session(['nombre_sede' => $nombre_sede]);
                session(['nombre_cargo' => $nombre_cargo]);

                Session::put('dni_registrado', $dni);
                Session::put('nombre_usuario', $nombres);
                return redirect('/menu_principal');
            }else
            
            if (Hash::check($clave, $validando_usuario[0]['clave'])) {
                // dd($clave);
                // dd("ingreso");
                $usuario_encontrado = $validando_usuario[0];
                $dni = $usuario_encontrado['dni'];
                $nombres = $usuario_encontrado['nombres'] . " " . $usuario_encontrado['apellidoPaterno'] . " " . $usuario_encontrado['apellidoMaterno'];
                $usuario = $usuario_encontrado['usuario'];
                $clave = $usuario_encontrado['clave'];
                $id_sede = $usuario_encontrado['id_sede'];
                $nombre_sede = $usuario_encontrado['nombre_sede'];
                $nombre_cargo = $usuario_encontrado['nombre_cargo'];
                session(['usuario_dni' => $dni]);
                session(['nombres' => $nombres]);
                session(['usuario' => $usuario]);
                session(['clave' => $clave]);
                session(['id_sede' => $id_sede]);
                session(['nombre_sede' => $nombre_sede]);
                session(['nombre_cargo' => $nombre_cargo]);

                Session::put('dni_registrado', $dni);
                Session::put('nombre_usuario', $nombres);
                return redirect('/menu_principal');
                // return Inertia::render('principal');
            } else {
                Session::flash('usuario_no_valido', 'Contraseña incorrecta, intente nuevamente');
                return redirect('/');
                exit();
            }

        } else {
            Session::flash('usuario_no_valido', 'Usuario incorrecto, intente nuevamente');
            return redirect('/');
            exit();
        }
    }

    public function home($mensaje = "ACEPTADO")
    {
        $x = session()->all();

        // $dni_registrado = Session::get('dni_registrado');

        // $existe_usuario = Usuario::select('dni')->where('dni', $dni_registrado)->get();


        if (empty($x['usuario_dni'])) {
            return view('welcome');
        } else {
            return view('menu')->with('mensaje', $mensaje);
        }
    }

    public function Sistema()
    {
        $x = session()->all();
        // dd($x);
        if (empty($x['usuario_dni'])) {
            return redirect('/');
        } else {
            $band = $this->verificarPermiso($x['usuario_dni'], 'VENTAS', 'SISTEMA');
            // dd($band);
            if ($band == 1) {
                return Inertia::render('principal');
            } else {
                $mensaje = 'RECHAZADO';
                return $this->home($mensaje);
                die();
            }
        }

        // return  redirect()->route('prin.welcome');
    }
    public function cerrar_sesion()
    {
        session()->forget('usuario_dni');
        session()->forget('nombres');
        session()->forget('usuario');
        session()->forget('clave');
        session()->forget('id_sede');
        session()->forget('nombre_sede');
    }

    public function verificarPermiso($dni, $modulo, $area)
    {
        // dd($dni, $modulo,"modulo", $area);
        $band = 0;

        $id_permiso = Permiso::select('id')->where('modulo', $modulo)->where('area', $area)->get();
        // dd($id_permiso);
        $result = Permiso_usuario::select('id')
            ->where('permisos_usuarios.id_permiso', $id_permiso[0]['id'])->where('permisos_usuarios.dni_usuario', $dni)->get();
        // dd($result);
        if (empty($result[0]['id'])) {
            $band = 0;
        } else {
            $band = 1;
        }

        return $band;
    }
}
