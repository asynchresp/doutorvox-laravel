<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Usuario::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->name,
        'email' => $faker->email,
        'password' => '123456',
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Feed::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->name,
        'url' => $faker->url,
        'status' => $faker->boolean()
    ];
});

$factory->define(App\Perfil::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->name,
    ];
});

$factory->define(App\Cidade::class, function (Faker\Generator $faker) {
    return [
        'cidade' => $faker->city,
        'estado' => $faker->citySuffix
    ];
});

$factory->define(App\Andamento::class, function (Faker\Generator $faker) {
    return [
        'idusuario' => factory(App\Usuario::class,1)->create()->id,
        'idpedido' => factory(App\Pedido::class,1)->create()->id,
        'comentario' => $faker->text(),
        'status' => $faker->boolean()
    ];
});

$factory->define(App\Diligencia::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->text(),
        'status' => $faker->boolean()
    ];
});

$factory->define(App\Pedido::class, function (Faker\Generator $faker) {
    return [
        'status' => $faker->boolean(),
        'valor_minimo' => $faker->numberBetween(50,200),
        'valor_maximo' => $faker->numberBetween(200,400),
        'idcidade' => factory(App\Cidade::class,1)->create()->id,
        'idusuario_cadastro' => factory(App\Cidade::class,1)->create()->id,
        'idusuario_alteracao' => factory(App\Usuario::class,1)->create()->id,
        'finalizado' => $faker->boolean(),
        'tipo_pagamento' => $faker->boolean()
    ];
});

$factory->define(App\Menu::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->name,
        'link' =>  $faker->url,
        'icone' => $faker->name,
        'ordem' => $faker->numberBetween(1,9),
        //'idpai' => factory(App\Menu::class,1)->create()->id,
    ];
});

$factory->define(App\Noticia::class, function (Faker\Generator $faker) {
    return [
        'idusuario' => factory(App\Usuario::class,1)->create()->id,
        'idfeed' =>  factory(App\Feed::class,1)->create()->id,
        'titulo' => $faker->title,
        'resumo' => $faker->paragraph,
        'dtnoticia' => $faker->dateTime,
        'descricao' => $faker->text,
    ];
});


$factory->define(App\Pagamento::class, function (Faker\Generator $faker) {
    return [
        'idusuario' => factory(App\Usuario::class,1)->create()->id,
        'dtvencimento' => $faker->dateTime,
        'dtpagamento' => $faker->dateTime,
        'valor' => $faker->numberBetween(50,200),
        'status' => $faker->boolean(),
        'metodo_pagamento' => $faker->numberBetween(1,3)
    ];
});

$factory->define(App\Assinatura::class, function (Faker\Generator $faker) {
    return [
        'idusuario' => factory(App\Usuario::class,1)->create()->id,
        'tipo_assinatura' => $faker->numberBetween(1,3),
        'dtvencimento' => $faker->dateTime,
        'dtadesao' => $faker->dateTime,
    ];
});

$factory->define(App\Avaliacao::class, function (Faker\Generator $faker) {
    return [
        'idusuario' => factory(App\Usuario::class,1)->create()->id,
        'idpedido'  => factory(App\Pedido::class,1)->create()->id,
        'nota' => $faker->numberBetween(1,5)
    ];
});

$factory->define(App\Candidato::class, function (Faker\Generator $faker) {
    return [
        'idusuario' => factory(App\Usuario::class,1)->create()->id,
        'idpedido'  => factory(App\Pedido::class,1)->create()->id,
        'dhproposta' => $faker->dateTime,
        'valor_proposta' => $faker->numberBetween(200,400),
        'aprovado' => $faker->boolean()
    ];
});

