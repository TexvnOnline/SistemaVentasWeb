<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto_almacen extends Model
{
    use HasFactory;
    protected $table = 'productos_almacen';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'id_proveedor',
        'id_sede',
        'descripcion',
        'cantidad',
        'marca',
        'talla',
        'recibido',
        'usuario_compra',
        'caegoria',
        'genero',
        'color',
        'fecha_pedido',
        'fecha_llegada',
        'numero_activo',
        'precio_compra',
        'precio_sugerido',
        'usuario_creacion',
        'usuario_actualizacion'
    ];

    public $timestamps = true;
}