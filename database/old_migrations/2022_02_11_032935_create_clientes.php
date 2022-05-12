<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->integer('dni');
            $table->string('nombres', 200)->nullable();
            $table->string('apellidos', 200)->nullable();
            $table->integer('edad');
            $table->string('tipo_pago', 70)->nullable();
            $table->string('talla', 200)->nullable();
            $table->string('telefono', 200)->nullable();
            $table->string('correo', 200)->nullable();
            $table->decimal('a_cuenta', $precision = 8, $scale = 2)->nullable();
            $table->decimal('saldo', $precision = 8, $scale = 2)->nullable();
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
        Schema::dropIfExists('clientes');
    }
}
