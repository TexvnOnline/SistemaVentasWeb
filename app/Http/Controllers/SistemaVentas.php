<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PrincipalController;
use Illuminate\Support\Facades\DB;

//MODELS
use App\Models\Usuario;
use App\Models\Doctor;
use App\Models\Producto_almacen;
use App\Models\Proveedor;
use App\Models\Sede;

use Inertia\Inertia;


class SistemaVentas extends Controller
{

    public function Almacen()
    {
        $x = session()->all();
        if (empty($x['usuario_dni'])) {
            return redirect('/');
        } else {

            $band = (new PrincipalController)->verificarPermiso($x['usuario_dni'], 'ALMACEN',  'SISTEMA');

            if ($band == 1) {
                $sedes = Sede::select('id', 'sedes')
                    ->orderby('id', 'asc')
                    ->get();

                $doctores = Usuario::select('id', 'usuario')
                    ->orderby('id', 'asc')
                    ->get();

                $proveedores = Proveedor::select('id', 'nombre_empresa_razon_social')
                    ->orderby('id', 'asc')
                    ->get();

                $productos = Producto_almacen::select(
                    'productos_almacen.id',
                    'productos_almacen.nombre',
                    'productos_almacen.cantidad',
                    'productos_almacen.fecha_pedido',
                    'productos_almacen.fecha_llegada',
                    'productos_almacen.marca',
                    'productos_almacen.descripcion',
                    'productos_almacen.categoria',
                    'productos_almacen.genero',
                    'productos_almacen.color',
                    'productos_almacen.talla',
                    'productos_almacen.numero_activo',
                    'productos_almacen.precio_compra',
                    'productos_almacen.precio_sugerido',
                    'productos_almacen.id_proveedor',
                    'p.nombre_empresa_razon_social as nombre_empresa_razon_social',
                    'p.nombre_contacto as nombre_contacto',
                    'productos_almacen.id_sede',
                    's.sedes as nombre_sede',
                )
                    ->join('proveedores as p', 'productos_almacen.id_proveedor', '=', 'p.id')
                    ->join('sedes as s', 'productos_almacen.id_sede', '=', 's.id')
                    ->orderby('nombre', 'asc')
                    ->get();

                $usuarios = Usuario::select('dni', 'usuario', 'id_sede')
                    ->where('habilitado', '=', 1)
                    ->whereNotIn('id_cargo', [1])
                    ->orderBy('usuario', 'asc')->get();

                $ultimo_activo = Producto_almacen::select(DB::raw("IF(MAX(numero_activo) is null,0,MAX(numero_activo)) as numero_activo"))->get();

                return Inertia::render(
                    'sistema/almacen',
                    [
                        'sedes' => $sedes,
                        'productos' => $productos,
                        'doctores' => $doctores,
                        'ultimo_activo' => $ultimo_activo,
                        'proveedores' => $proveedores,
                        'usuarios' => $usuarios,
                    ]
                );
            }
        }
    }

    public function guardar_producto(Request $request){ 
        // $fecha_registro = (new LogisticaController)->fecha_larga_aplicacion();
        // dd($request);
        $x = session()->all();
        $usuario_registro = $x['usuario_dni'];

        $frmDatosActivo = json_decode($request->frmDatosActivo);
        // dd($tipo_modulo);
        if ($request->modo == "NUEVO") {
            // dd("hola");
            $usuario_compra = $request->usuario_compra;
            $canasta_compras = json_decode($request->canasta);

            foreach ($canasta_compras as $compra) {
                $codigoRelacionado = $compra->codigo_relacionado;
                $nombre = mb_strtoupper($compra->nombre);
                $descripcion = mb_strtoupper($compra->descripcion);
                $fecha_llegada = $compra->fecha_llegada;
                $fecha_pedido = $compra->fecha_pedido;
                $id_proveedor = $compra->id_proveedor;
                $id_sede = $compra->id_sede;
                $marca = mb_strtoupper($compra->marca);
                $numero_activo = $compra->numero_activo;
                $precio_compra = $compra->precio_compra;
                $precio_sugerido = $compra->precio_sugerido;
                $talla = $compra->talla;
                $cantidad = $compra->cantidad;
                $categoria = $compra->categoria;
                // dd($categoria);
                $color = $compra->color;
                $genero = $compra->genero;

                Producto_almacen::create(array(
                    'nombre' => $nombre,
                    'numero_activo' => $numero_activo,
                    'descripcion' => $descripcion,
                    'fecha_llegada' => $fecha_llegada,
                    'fecha_pedido' => $fecha_pedido,
                    'id_proveedor' => $id_proveedor,
                    'id_sede' => $id_sede,
                    'marca' => $marca,
                    'usuario_compra' => $usuario_compra,
                    'precio_compra' => $precio_compra,
                    'precio_sugerido' => $precio_sugerido,
                    'talla' => $talla,
                    'cantidad' => $cantidad,
                    'color' => $color,
                    'genero' => $genero,
                    'categoria' => $compra->categoria,
                    'usuario_creacion' => $usuario_registro,
                ));
            }
        } elseif ($frmDatosActivo->modo == "EDITAR") {
            // dd($frmDatosActivo);
            $id = $frmDatosActivo->id;
            $nombre = mb_strtoupper($frmDatosActivo->nombre);
            $descripcion = mb_strtoupper($frmDatosActivo->descripcion);
            $fecha_llegada = $frmDatosActivo->fecha_llegada;
            $fecha_pedido = $frmDatosActivo->fecha_pedido;
            $id_proveedor = $frmDatosActivo->id_proveedor;
            $id_sede = $frmDatosActivo->id_sede;
            $marca = mb_strtoupper($frmDatosActivo->marca);
            $numero_activo = $frmDatosActivo->numero_activo;
            $precio_compra = $frmDatosActivo->precio_compra;
            $precio_sugerido = $frmDatosActivo->precio_sugerido;
            // $recibido = $frmDatosActivo->recibido;
            $talla = $frmDatosActivo->talla;
            $cantidad = $frmDatosActivo->cantidad;
            $categoria = $frmDatosActivo->categoria;
            $color = $frmDatosActivo->color;
            $genero = $frmDatosActivo->genero;
            Producto_almacen::where('id', $id)
            ->update([
                'nombre' => $nombre,
                'numero_activo' => $numero_activo,
                'descripcion' => $descripcion,
                'fecha_llegada' => $fecha_llegada,
                'fecha_pedido' => $fecha_pedido,
                'id_proveedor' => $id_proveedor,
                'id_sede' => $id_sede,
                'marca' => $marca,
                'precio_compra' => $precio_compra,
                'precio_sugerido' => $precio_sugerido,
                'talla' => $talla,
                'cantidad' => $cantidad,
                'categoria' => $categoria,
                'color' => $color,
                'genero' => $genero,
                'usuario_creacion' => $usuario_registro,
            ]);
        }
        return redirect()->route('sistema.almacen');
    }
}
