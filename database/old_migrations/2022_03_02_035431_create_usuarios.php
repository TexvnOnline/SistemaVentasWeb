<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 100);
            $table->string('apellidoPaterno', 50);
            $table->string('apellidoMaterno', 50);
            $table->string('usuario', 50);
            $table->string('especialidad', 200)->nullable();
            $table->string('correo', 75)->nullable();
            $table->string('genero', 20)->nullable();
            $table->string('direccion', 200)->nullable();
            $table->string('clinica_uno', 200)->nullable();
            $table->string('clinica_dos', 200)->nullable();
            $table->integer('telefono')->nullable();
            $table->integer('dni');
            $table->integer('id_sede');
            $table->integer('id_cargo');
            $table->string('clave', 100);
            $table->boolean('habilitado');
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
        Schema::dropIfExists('usuarios');
    }
}
