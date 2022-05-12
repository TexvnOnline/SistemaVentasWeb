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

use Inertia\Inertia;
//MODELS
use App\Models\Cargo;
use App\Models\Usuario;
use App\Models\Sede;
use App\Models\Permiso_usuario;
use App\Models\Proveedor;


class MantenimientoController extends Controller
{
    public function Usuarios()
    {
        $x = session()->all();
        if (empty($x['usuario_dni'])) {
            return view('login');
        } else {
            $band = (new PrincipalController)->verificarPermiso($x['usuario_dni'], 'USUARIOS',  'MANTENIMIENTO');
            if ($band == 1) {
                $sedes = Sede::select('id', 'sedes')
                    ->orderby('id', 'asc')
                    ->get();

                $cargos = Cargo::select('id', 'cargo')
                    ->orderby('id', 'asc')
                    ->get();

                $usuarios = Usuario::from('usuarios as u')
                    ->select(
                        'u.id',
                        'u.nombres',
                        'u.apellidoPaterno',
                        'u.apellidoMaterno',
                        'u.usuario',
                        'u.direccion',
                        'u.correo',
                        'u.telefono',
                        'u.genero',
                        'u.dni',
                        'u.clave',
                        'u.id_sede',
                        'u.id_cargo',
                        'u.clinica_dos',
                        'u.clinica_uno',
                        'u.habilitado',
                        'c.cargo',
                        's.sedes'
                    )
                    ->join('cargos as c', 'u.id_cargo', '=', 'c.id')
                    ->join('sedes as s', 'u.id_sede', '=', 's.id')
                    ->whereNotIn('u.id_cargo', [1])
                    ->get();

                return Inertia::render(
                    'mantenimiento/usuarios',
                    [
                        'sedes' => $sedes,
                        'cargos' => $cargos,
                        'usuarios' => $usuarios,
                    ]
                );
            } else {
                $mensajeTitulo = '¡Ups!';
                $mensajeContenido = 'No tienes permitido ver este contenido.';
                return view('cuatrocientoscuatro')->with('mensajeTitulo', $mensajeTitulo)->with('mensajeContenido', $mensajeContenido);
                die();
            }
        }
    }

    public function verificar_usuario(Request $request)
    {
        $modo = $request->modo;
        $dni = $request->dni;
        $usuario = $request->usuario;

        $existe_dni = Usuario::select('dni')->where('dni', $dni)->get();
        $existe_usuario = Usuario::select('usuario')->where('usuario', $usuario)->get();

        if ($modo == 'EDITAR') {

            $existe_usuario = Usuario::select('usuario')->where('dni', $dni)->get();

            if (count($existe_usuario) == 0) {
                return "CORRECTO";
            } else {
                if ($existe_usuario[0]['usuario'] == $usuario) {
                    return "CORRECTO";
                } else {
                    return "INCORRECTO_U";
                }
            }
        } else if ($modo == 'NUEVO') {

            $existe_dni = Usuario::select('dni')->where('dni', $dni)->get();
            $existe_usuario = Usuario::select('usuario')->where('usuario', $usuario)->get();

            if (count($existe_dni) == 0) {
                if (count($existe_usuario) == 0) {
                    return 'CORRECTO';
                } else {
                    return 'INCORRECTO_U';
                }
            } else {
                return 'INCORRECTO_D';
            }
        }
    }

    public function guardar_usuario(Request $request)
    {
        // dd($request);
        date_default_timezone_set("America/Lima");
        $fecha_registro = date("Y-m-d H:i:s");

        $x = session()->all();
        $usuario_registro = $x['usuario_dni'];

        $modo = $request->modo;
        $dni = $request->dni;
        $usuario = mb_strtolower($request->usuario);
        $especialidad = $request->especialidad;
        $nombres = $request->nombres;
        $apellidoPaterno = $request->apellidoPaterno;
        $apellidoMaterno = $request->apellidoMaterno;
        $genero = $request->genero;
        $direccion = mb_strtoupper($request->direccion);
        $clinica_uno = mb_strtoupper($request->clinica_uno);
        $clinica_dos = mb_strtoupper($request->clinica_dos);
        $telefono = $request->telefono;
        $correo = $request->correo;
        $id_cargo = $request->id_cargo;
        $id_sede = $request->id_sede;

        if ($modo == 'NUEVO') {
            $clave = Hash::make($dni);
            //PERMISOS PARA ADMINISTRADOR
            if ($id_cargo == 3) {
                Usuario::create(array(
                    'dni' => $dni,
                    'usuario' => $usuario,
                    'clave' => $clave,
                    'nombres' => $nombres,
                    'apellidoPaterno' => $apellidoPaterno,
                    'apellidoMaterno' => $apellidoMaterno,
                    'genero' => $genero,
                    'telefono' => $telefono,
                    'direccion' => $direccion,
                    'correo' => $correo,
                    'id_sede' => $id_sede,
                    'id_cargo' => $id_cargo,
                    'habilitado' => 1,
                    'usuario_creacion' => $usuario_registro,
                ));
                Permiso_usuario::create(array(
                    'dni_usuario' => $dni,
                    'id_permiso' => 1,
                ));
                Permiso_usuario::create(array(
                    'dni_usuario' => $dni,
                    'id_permiso' => 2,
                ));
                Permiso_usuario::create(array(
                    'dni_usuario' => $dni,
                    'id_permiso' => 3,
                ));
                Permiso_usuario::create(array(
                    'dni_usuario' => $dni,
                    'id_permiso' => 4,
                ));
                Permiso_usuario::create(array(
                    'dni_usuario' => $dni,
                    'id_permiso' => 5,
                ));
                Permiso_usuario::create(array(
                    'dni_usuario' => $dni,
                    'id_permiso' => 6,
                ));

                return redirect()->route('mantenimiento.usuarios');
                //PERMISOS PARA VENDEDOR
            } else if ($id_cargo == 2) {
                $clave = Hash::make($dni);
                Usuario::create(array(
                    'dni' => $dni,
                    'usuario' => $usuario,
                    'clave' => $clave,
                    'nombres' => $nombres,
                    'apellidoPaterno' => $apellidoPaterno,
                    'apellidoMaterno' => $apellidoMaterno,
                    'genero' => $genero,
                    'direccion' => $direccion,
                    'telefono' => $telefono,
                    'correo' => $correo,
                    'id_sede' => $id_sede,
                    'id_cargo' => $id_cargo,
                    'habilitado' => 1,
                    'usuario_creacion' => $usuario_registro,
                ));

                Permiso_usuario::create(array(
                    'dni_usuario' => $dni,
                    'id_permiso' => 1,
                ));
                return redirect()->route('mantenimiento.usuarios');
            }
        } else if ($modo == 'EDITAR') {
            // if ($id_cargo == 1) {
            Usuario::where('dni', $dni)->update([
                'usuario' => $usuario,
                'nombres' => $nombres,
                'especialidad' => $especialidad,
                'apellidoPaterno' => $apellidoPaterno,
                'apellidoMaterno' => $apellidoMaterno,
                'genero' => $genero,
                'direccion' => $direccion,
                'clinica_uno' => $clinica_uno,
                'clinica_dos' => $clinica_dos,
                'telefono' => $telefono,
                'correo' => $correo,
                'id_sede' => $id_sede,
                'id_cargo' => $id_cargo,
                'usuario_actualizacion' => $usuario_registro
            ]);
            return redirect()->route('mantenimiento.usuarios');
        }else if ($modo == 'EDITAR DOCTOR') {
            // if ($id_cargo == 1) {
            Usuario::where('dni', $dni)->update([
                'usuario' => $usuario,
                'nombres' => $nombres,
                'especialidad' => $especialidad,
                'apellidoPaterno' => $apellidoPaterno,
                'apellidoMaterno' => $apellidoMaterno,
                'genero' => $genero,
                'clinica_uno' => $clinica_uno,
                'clinica_dos' => $clinica_dos,
                'telefono' => $telefono,
                'id_sede' => $id_sede,
                'id_cargo' => $id_cargo,
                'usuario_actualizacion' => $usuario_registro
            ]);
            return redirect()->route('mantenimiento.doctores');
        } 
        else if ($modo == 'NUEVO DOCTOR') {
            // dd($modo);
            $clave = Hash::make($dni);
            Usuario::create(array(
                'dni' => $dni,
                'usuario' => $usuario,
                'especialidad' => $especialidad,
                'clave' => $clave,
                'nombres' => $nombres,
                'apellidoPaterno' => $apellidoPaterno,
                'apellidoMaterno' => $apellidoMaterno,
                'genero' => $genero,
                'direccion' => $direccion,
                'clinica_uno' => $clinica_uno,
                'clinica_dos' => $clinica_dos,
                'telefono' => $telefono,
                'correo' => $correo,
                'id_sede' => $id_sede,
                'id_cargo' => $id_cargo,
                'habilitado' => 1,
                'usuario_creacion' => $usuario_registro
            ));
            return redirect()->route('mantenimiento.doctores');
        }
        return redirect()->route('mantenimiento.usuarios');
    }

    public function cesar_usuario(Request $request)
    {
        // dd($request);
        date_default_timezone_set("America/Lima");
        $fecha_registro = date("Y-m-d H:i:s");
        $dni = $request->dni;
        // $motivo_cese =  $request->motivo_cese;
        // $usuario = Usuario::where('dni', $dni)->get()->last();
        // $fecha_registro = (new GthController)->fecha_larga_aplicacion();
        $x = session()->all();
        $usuario_registro = $x['usuario_dni'];

        Usuario::where('dni', $dni)->update([
            'habilitado' => 0,
            'usuario_actualizacion' => $usuario_registro
        ]);

        Permiso_usuario::where('dni_usuario', $dni)->delete();

        return redirect()->route('mantenimiento.usuarios');
    }

    public function Proveedores()
    {
        $x = session()->all();
        if (empty($x['usuario_dni'])) {
            return view('login');
        } else {
            $band = (new PrincipalController)->verificarPermiso($x['usuario_dni'], 'PROVEEDORES',  'MANTENIMIENTO');
            if ($band == 1) {
                $sedes = Sede::select('id', 'sedes')
                    ->orderby('id', 'asc')
                    ->get();

                $cargos = Cargo::select('id', 'cargo')
                    ->orderby('id', 'asc')
                    ->get();

                $proveedores = Proveedor::select(
                    'id',
                    'ruc_dni',
                    'nombre_empresa_razon_social',
                    'nombre_contacto',
                    'telefono',
                    'direccion',
                    'correo'
                )
                    ->orderby('id', 'asc')
                    ->get();

                return Inertia::render(
                    'mantenimiento/proveedores',
                    [
                        'sedes' => $sedes,
                        'cargos' => $cargos,
                        'proveedores' => $proveedores,
                    ]
                );
            } else {
                $mensajeTitulo = '¡Ups!';
                $mensajeContenido = 'No tienes permitido ver este contenido.';
                return view('cuatrocientoscuatro')->with('mensajeTitulo', $mensajeTitulo)->with('mensajeContenido', $mensajeContenido);
                die();
            }
        }
    }
    public function guardar_proveedo(Request $request)
    {
        // dd($request);
        $x = session()->all();
        $usuario_registro = $x['usuario_dni'];
        $id = $request->id;
        $modo = $request->modo;
        $ruc_dni = $request->ruc_dni;
        $nombre_empresa_razon_social = mb_strtolower($request->nombre_empresa_razon_social);
        $nombre_contacto = mb_strtoupper($request->nombre_contacto);
        $telefono = $request->telefono;
        $direccion = mb_strtoupper($request->direccion);
        $correo = $request->correo;

        if ($modo == 'NUEVO') {
            // dd($ruc);
            Proveedor::create(array(
                'ruc_dni' => $ruc_dni,
                'nombre_empresa_razon_social' => $nombre_empresa_razon_social,
                'nombre_contacto' => $nombre_contacto,
                'direccion' => $direccion,
                'telefono' => $telefono,
                'correo' => $correo,
                'usuario_creacion' => $usuario_registro,
            ));

            return redirect()->route('mantenimiento.proveedores');
        } else if ($modo == 'EDITAR') {

            Proveedor::where('id', $id)->update([
                'ruc_dni' => $ruc_dni,
                'nombre_empresa_razon_social' => $nombre_empresa_razon_social,
                'nombre_contacto' => $nombre_contacto,
                'direccion' => $direccion,
                'telefono' => $telefono,
                'correo' => $correo,
                'usuario_actualizacion' => $usuario_registro
            ]);

            return redirect()->route('mantenimiento.proveedores');
        }
    }
    public function eliminar_proveedor(Request $request)
    {
        // dd($request);
        $id = $request->id;
        Proveedor::where('id', $id)->delete();
        return redirect()->route('mantenimiento.proveedores');
    }

    public function Doctores()
    {
        $x = session()->all();
        if (empty($x['usuario_dni'])) {
            return view('login');
        } else {
            $band = (new PrincipalController)->verificarPermiso($x['usuario_dni'], 'USUARIOS',  'MANTENIMIENTO');
            if ($band == 1) {
                $sedes = Sede::select('id', 'sedes')
                    ->orderby('id', 'asc')
                    ->get();

                $cargos = Cargo::select('id', 'cargo')
                    ->orderby('id', 'asc')
                    ->get();

                $usuarios = Usuario::from('usuarios as u')
                    ->select(
                        'u.id',
                        'u.nombres',
                        'u.apellidoPaterno',
                        'u.apellidoMaterno',
                        'u.usuario',
                        'u.especialidad',
                        'u.telefono',
                        'u.genero',
                        'u.dni',
                        'u.clave',
                        'u.id_sede',
                        'u.id_cargo',
                        'u.clinica_dos',
                        'u.clinica_uno',
                        'u.habilitado',
                        'c.cargo',
                        's.sedes'
                    )
                    ->join('cargos as c', 'u.id_cargo', '=', 'c.id')
                    ->join('sedes as s', 'u.id_sede', '=', 's.id')
                    ->where('u.id_cargo', '=', 1)
                    ->get();

                return Inertia::render(
                    'mantenimiento/doctores',
                    [
                        'sedes' => $sedes,
                        'cargos' => $cargos,
                        'usuarios' => $usuarios,
                    ]
                );
            } else {
                $mensajeTitulo = '¡Ups!';
                $mensajeContenido = 'No tienes permitido ver este contenido.';
                return view('cuatrocientoscuatro')->with('mensajeTitulo', $mensajeTitulo)->with('mensajeContenido', $mensajeContenido);
                die();
            }
        }
    }
    
    public function eliminar_usuario(Request $request){
        $dni = $request->dni;
        $x = session()->all();
        $usuario_registro = $x['usuario_dni'];

        Usuario::where('dni', $dni)->delete();
        return redirect()->route('mantenimiento.doctores');
    }
}
