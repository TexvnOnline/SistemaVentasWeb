<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'dni',
        'nombres',
        'apellidos',
        'correo',
        'telefono',
        'talla',
        'edad',
        'tipo_pago',
        'a_cuenta',
        'saldo'
    ];

    public $timestamps = true;
}