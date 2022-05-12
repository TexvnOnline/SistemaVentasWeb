<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->integer('id_cliente');
            $table->integer('idSede');
            $table->decimal('precio_total', $precision = 8, $scale = 2);
            $table->decimal('impuesto', $precision = 8, $scale = 2)->nullable();
            $table->string('tipo_pago', 200)->nullable();
            $table->string('tipo_comprobante', 200)->nullable();
            $table->integer('id_doctor')->nullable();
            $table->integer('cantidad_vendida')->nullable();
            $table->integer('usuario_creacion')->nullable();
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
        Schema::dropIfExists('ventas');
    }
}
