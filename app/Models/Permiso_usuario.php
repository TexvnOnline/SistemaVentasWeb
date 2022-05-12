<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso_usuario extends Model
{
    use HasFactory;
    protected $table = 'permisos_usuarios';
    protected $primaryKey = 'id';

    protected $fillable = [
        'dni_usuario', 
        'id_permiso'
    ];

    public $timestamps = true;
}