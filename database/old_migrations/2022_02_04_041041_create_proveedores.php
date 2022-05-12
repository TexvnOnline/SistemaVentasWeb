<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('ruc_dni', 15)->nullable();
            $table->string('nombre_empresa_razon_social', 200)->nullable();
            $table->string('nombre_contacto', 200)->nullable();
            $table->integer('telefono');
            $table->string('direccion', 250);
            $table->string('correo', 200);
            $table->string('usuario_creacion', 75)->nullable();
            $table->string('usuario_actualizacion', 75)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
}
