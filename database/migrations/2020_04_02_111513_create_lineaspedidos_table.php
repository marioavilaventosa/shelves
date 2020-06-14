<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineaspedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lineaspedido', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pedidos_id');
            $table->bigInteger('productos_id');
            $table->integer('unidades');
            $table->string('talla');
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
        Schema::dropIfExists('lineaspedido');
    }
}
