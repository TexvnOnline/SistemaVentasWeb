<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalles_venta extends Model
{
    use HasFactory;
    protected $table = 'detalles_ventas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_venta',
        'id_producto',
        'cantidad',
        'precio_suugerido',
    ];

    public $timestamps = true;
}