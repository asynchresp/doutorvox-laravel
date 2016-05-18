<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosDiligenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_diligencias', function (Blueprint $table) {
            $table->integer('idusuario')->unsigned();
            $table->foreign('idusuario')->references('id')->on('usuarios')->cascade();
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
        Schema::drop('usuarios_diligencias');
    }
}
