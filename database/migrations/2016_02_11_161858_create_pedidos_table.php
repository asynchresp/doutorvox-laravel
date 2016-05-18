<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status');
            $table->decimal('valor_minimo',10,2);
            $table->decimal('valor_maximo',10,2);
            $table->integer('idcidade')->unsigned();
            $table->foreign('idcidade')->references('id')->on('cidades');
            $table->integer('idusuario_cadastro')->unsigned();
            $table->foreign('idusuario_cadastro')->references('id')->on('usuarios');
            $table->integer('idusuario_alteracao')->unsigned();
            $table->foreign('idusuario_alteracao')->references('id')->on('usuarios');
            $table->tinyInteger('finalizado');
            $table->tinyInteger('tipo_pagamento');
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
        Schema::drop('pedidos');
    }
}
