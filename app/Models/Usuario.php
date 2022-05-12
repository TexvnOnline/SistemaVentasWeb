<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuarios';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombres',
        'apellidoPaterno',
        'apellidoMaterno',
        'usuario',
        'especialidad',
        'correo',
        'genero',
        'direccion',
        'clinica_uno',
        'clinica_dos',
        'telefono',
        'dni',
        'clave',
        'id_sede',
        'id_cargo',
        'habilitado',
        'usuario_creacion',
        'usuario_actualizacion'
    ];

    public $timestamps = true;
}