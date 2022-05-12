<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;

use Inertia\Inertia;
//MODELS
use App\Models\Venta;
use App\Models\Sede;
use App\Models\Cliente;
use App\Models\Producto_almacen;
use App\Models\Usuario;
use App\Models\Detalles_venta;



class VentasController extends Controller
{
    public function Ventas()
    {
        $x = session()->all();
        if (empty($x['usuario_dni'])) {
            return redirect('/');
        } else {
            $sedes = Sede::select('id', 'sedes')
                ->orderby('id', 'asc')
                ->get();

            $productos = Producto_almacen::select(
                'productos_almacen.id',
                'productos_almacen.nombre',
                'productos_almacen.cantidad',
                'productos_almacen.fecha_llegada',
                'productos_almacen.marca',
                'productos_almacen.descripcion',
                'productos_almacen.talla',
                'productos_almacen.precio_sugerido',
                'productos_almacen.id_proveedor',
                'p.nombre_empresa_razon_social as nombre_empresa',
                'p.nombre_contacto as nombre_contacto',
                'productos_almacen.id_sede',
                's.sedes as nombre_sede',
            )
                ->join('proveedores as p', 'productos_almacen.id_proveedor', '=', 'p.id')
                ->join('sedes as s', 'productos_almacen.id_sede', '=', 's.id')
                ->orderby('nombre', 'asc')
                ->whereNotIn('productos_almacen.cantidad', [0])
                ->get();

            $doctores = Usuario::select(
                'id',
                'usuario',
            )
                ->where('id_cargo', 1)
                ->orderBy('id', 'asc')
                ->get();

            return Inertia::render(
                'sistema/ventas',
                [
                    'sedes' => $sedes,
                    'productos' => $productos,
                    'doctores' => $doctores,
                ]
            );
        }
    }

    public function guardar_venta(Request $request)
    {
        // dd($request);
        date_default_timezone_set("America/Lima");
        $fecha_actual = date("Y-m-d H:i:s");
        // $fecha_registro = (new LogisticaController)->fecha_larga_aplicacion();

        // return $request; 
        // $fecha_registro = (new LogisticaController)->fecha_larga_aplicacion();
        $x = session()->all();
        $usuario_registro = $x['usuario_dni'];

        $precio = $request->precio;
        $nombres = $request->nombres;
        $apellidos = $request->apellidos;
        $dni = $request->dni;
        $edad = $request->edad;
        $correo = $request->correo;
        $telefono = $request->telefono;
        $talla = $request->talla;
        $doctor = $request->doctor;
        $tipo_pago = $request->tipo_pago;
        $tipo_comprobante = $request->tipo_comprobante;
        $a_cuenta = $request->a_cuenta;
        $saldo = $request->saldo;
        // dd($saldo, $a_cuenta, $tipo_pago);
        $productos_seleccionados = json_decode($request->suministros_seleccionados);

        // $cliente_existente = from()
        // where('id', $producto_seleccionado->id)

        $id_cliente = Cliente::create(array(
            'apellidos' => $apellidos,
            'nombres' => $nombres,
            'dni' => $dni,
            'correo' => $correo,
            'telefono' => $telefono,
            'edad' => $edad,
            'tipo_pago' => $tipo_pago,
            'talla' => $talla,
            'a_cuenta' => $a_cuenta,
            'saldo' => $saldo,
        ));
        $dni_cliente = $id_cliente->dni;

        $id_venta = Venta::create(array(
            'id_cliente' => $dni_cliente,
            'idSede' => 1,
            'precio_total' => $precio,
            'impuesto' => 0.18,
            'id_doctor' => $doctor,
            'tipo_pago' => $tipo_pago,
            'tipo_comprobante' => $tipo_comprobante,
            'usuario_creacion' => $usuario_registro,
        ));
        $id_venta = $id_venta->id;

        foreach ($productos_seleccionados as $producto_seleccionado) {
            
            $id_detalle_venta = Detalles_venta::create(array(
                'id_venta' => $id_venta,
                'id_producto' => $producto_seleccionado->id,
                'cantidad' => $producto_seleccionado->cantidad,
                'precio_suugerido' => $producto_seleccionado->precio_sugerido,
            ));
            $id_detalle_venta = $id_detalle_venta->id;
            $cantidad = Producto_almacen::select('cantidad')->where('id', $producto_seleccionado->id)->get()->last()['cantidad'];
            $nuevacantidad = $cantidad - $producto_seleccionado->cantidad;

            Producto_almacen::where('id', $producto_seleccionado->id)
                ->update(['cantidad' => $nuevacantidad]);
        }

        return redirect()->route('sistema.ventas');
    }

    public function historial_ventas()
    {
        $x = session()->all();
        if (empty($x['usuario_dni'])) {
            return redirect('/');
        } else {
            $band = (new PrincipalController)->verificarPermiso($x['usuario_dni'], 'ALMACEN',  'SISTEMA');
            if ($band == 1) {
                $ventas = Venta::select(
                    'ventas.id',
                    'ventas.id_cliente',
                    'ventas.id_doctor',
                    'ventas.precio_total',
                    'ventas.idSede',
                    'ventas.tipo_pago',
                    'ventas.tipo_comprobante',
                    'us.usuario as doctor',
                    'ventas.usuario_creacion',
                    'u.usuario as vendeor',
                    'ventas.created_at as fecha_venta',
                    'c.nombres',
                    'c.apellidos'
                )
                    ->join('usuarios as us', 'us.id', 'ventas.id_doctor')
                    ->join('usuarios as u', 'u.dni', 'ventas.usuario_creacion')
                    ->join('clientes as c', 'c.dni', 'ventas.id_cliente')
                    ->get();

                $ventas_detalles = Detalles_venta::from('detalles_ventas as dv')
                    ->select(
                        'dv.id',
                        'dv.id_venta',
                        'dv.id_producto',
                        'dv.cantidad',
                        'precio_suugerido',
                        'p.nombre',
                        'p.descripcion',
                        'dv.cantidad',
                        'p.precio_sugerido'
                    )
                    ->join('ventas as v', 'v.id',  'dv.id_venta')
                    ->join('productos_almacen as p', 'p.id', 'dv.id_producto')
                    ->get('');

                return Inertia::render(
                    'sistema/reportes_venta',
                    [
                        'ventas' => $ventas,
                        'ventas_detalle' => $ventas_detalles
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

    public function historial_clientes(){
        $x = session()->all();
        if (empty($x['usuario_dni'])) {
            return redirect('/');
        } else {
            $band = (new PrincipalController)->verificarPermiso($x['usuario_dni'], 'ALMACEN',  'SISTEMA');
            if ($band == 1) {
                $clientes = Cliente::select(
                    'clientes.id',
                    'clientes.dni',
                    'clientes.nombres',
                    'clientes.apellidos',
                    'clientes.edad',
                    'clientes.tipo_pago',
                    'clientes.talla',
                    'clientes.telefono',
                    'clientes.a_cuenta',
                    'clientes.saldo',
                    'clientes.created_at'
                )
                    ->get();

                return Inertia::render(
                    'sistema/reportes_clientes',
                    [
                        'clientes' => $clientes
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
}
