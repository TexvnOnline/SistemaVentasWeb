<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ActivoRegistros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('activo_registros', function (Blueprint $table) {
            $table->id('id_activo_resgistro');
            $table->integer('id_responsable');
            $table->integer('id_producto');
            $table->integer('id_sede');
            $table->integer('cantidad');
            $table->datetime('fecha_llegada')->nullable();
            $table->string('marca', 200);
            $table->string('descripcion', 200)->nullable();
            $table->string('talla', 200)->nullable();
            $table->decimal('precio_sugerido',  $precision = 8, $scale = 2)->nullable();
            $table->integer('numero_activo');
            $table->dateTime('fecha_creacion');
            $table->integer('usuario_creacion');
            $table->dateTime('fecha_actualizacion')->nullable();
            $table->integer('usuario_actualizacion')->nullable();
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
        Schema::dropIfExists('activo_registros');
    }
}
