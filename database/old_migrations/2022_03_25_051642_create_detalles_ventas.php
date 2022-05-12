<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesVentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('detalles_ventas', function (Blueprint $table) {
            $table->id();
            $table->integer('id_venta')->nullable();
            $table->integer('id_producto')->nullable();
            $table->integer('cantidad')->nullable();
            $table->decimal('precio_suugerido', $precision = 8, $scale = 2)->nullable();
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
        Schema::dropIfExists('detalles_ventas');
    }
}
