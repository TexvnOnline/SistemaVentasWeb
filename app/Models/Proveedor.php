<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'proveedores';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ruc_dni',
        'nombre_empresa_razon_social',
        'nombre_contacto',
        'telefono',
        'direccion',
        'correo'
    ];

    public $timestamps = true;
}