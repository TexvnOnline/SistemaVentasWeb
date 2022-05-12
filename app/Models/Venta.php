<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'ventas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_cliente',
        'idSede',
        'id_producto',
        'precio_total',
        'impuesto',
        'tipo_pago',
        'tipo_comprobante',
        'id_doctor',
        'cantidad_vendida',
        'usuario_creacion',
        'usuario_actualizacion',
    ];

    public $timestamps = true;
}