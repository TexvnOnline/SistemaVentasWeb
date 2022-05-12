<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosAlmacen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('productos_almacen', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200);
            $table->integer('id_proveedor');
            $table->integer('id_sede');
            $table->string('descripcion', 200)->nullable();
            $table->integer('cantidad');
            $table->string('marca', 200)->nullable();
            $table->string('talla', 200)->nullable();
            $table->string('genero', 10)->nullable();
            $table->string('categoria', 200)->nullable();
            $table->string('color', 200)->nullable();
            $table->integer('usuario_compra')->nullable();
            $table->datetime('fecha_pedido')->nullable();
            $table->datetime('fecha_llegada')->nullable();
            $table->integer('numero_activo');
            $table->decimal('precio_compra',  $precision = 8, $scale = 2)->nullable();
            $table->decimal('precio_sugerido',  $precision = 8, $scale = 2)->nullable();
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
        Schema::dropIfExists('productos_almacen');
    }
}
