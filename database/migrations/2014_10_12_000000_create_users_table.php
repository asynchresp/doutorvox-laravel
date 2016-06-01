<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('cpf_cnpj');
            $table->string('telefone')->nullable();
            $table->string('residencial')->nullable();
            $table->string('comercial')->nullable();
            $table->string('celular')->nullable();
            $table->string('imagem_perfil')->nullable();
            $table->integer('tipo');
            $table->string('logradouro');
            $table->string('bairro');
            $table->integer('idcidade')->unsigned()->nullable();
            $table->foreign('idcidade')->references('id')->on('cidades');
            $table->string('cep');
            $table->rememberToken();
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
        Schema::drop('usuarios');
    }
}
