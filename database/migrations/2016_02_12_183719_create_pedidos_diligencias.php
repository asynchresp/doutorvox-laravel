<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosDiligencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos_diligencias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idpedido')->unsigned();
            $table->foreign('idpedido')->references('id')->on('pedidos')->cascade();
            $table->integer('iddiligencia')->unsigned();
            $table->foreign('iddiligencia')->references('id')->on('diligencias')->cascade();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pedidos_diligencias');
    }
}
