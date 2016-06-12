<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::get('site', function(){
    return view('site');
});
Route::get('cadastro', function(){
    return view('cadastro');
});

Route::post('register', 'AccountController@register');
Route::post('login', 'AccountController@login');
Route::get('logout', 'AccountController@logout');

Route::get('advogado', 'UsuariosController@advogado');
Route::get('advogado_dashboard', 'UsuariosController@advogadoDashboard');
Route::get('pedido_dashboard', 'PedidosController@pedidoDashboard');

Route::group(['prefix' => 'mobile'], function () {
    Route::group(['prefix' => 'usuario'], function () {
        Route::post('login', 'Mobile\MobileUsuarioController@login');
        Route::post('registrar', 'Mobile\MobileUsuarioController@registrar');
    });
    Route::group(['prefix' => 'noticia'], function () {
        Route::post('obter_noticias', 'Mobile\MobileNoticiaController@obterNoticias');
    });
    Route::group(['prefix' => 'pedido'], function () {
        Route::post('obter_pedidos_escritorio', 'Mobile\MobilePedidoController@obterPedidosDoEscritorio');
        Route::post('deletar_pedido', 'Mobile\MobilePedidoController@deletarPedido');
        Route::post('aprovar_pedido', 'Mobile\MobilePedidoController@aprovarPedido');
    });
});


Route::group(['middleware' => ['web']], function () {
    Route::get('auth/login', 'Auth\AuthController@getLogin');
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
    Route::get('auth/register', 'Auth\AuthController@getRegister');
    Route::post('auth/register', 'Auth\AuthController@postRegister');
});
Route::group(['middleware' => 'web'], function () {
    Route::get('/', ['middleware' => 'auth', 'uses' => 'IndexController@index', function() {

    }]);
	Route::get('iniciar', function(){
		return view('iniciar');
	});
    Route::resource('pedido', 'PedidosController');
    Route::resource('feed', 'FeedsController');
    Route::resource('noticia', 'NoticiasController');
    Route::resource('menu', 'MenuController');
    Route::resource('perfil', 'PerfilController');
    Route::resource('estado', 'EstadosController');
    Route::resource('cidade', 'CidadesController');
    Route::resource('andamento', 'AndamentosController');

    Route::resource('diligencia', 'DiligenciasController');
    Route::resource('usuario', 'UsuariosController');
    Route::resource('get_usuario_logado', 'UsuariosController@get_usuario_logado');
    Route::resource('pagamento', 'PagamentosController');
    Route::resource('assinatura', 'AssinaturasController');
    Route::resource('avaliacao', 'AvaliacoesController');
    Route::resource('candidato', 'CandidatosController');
    Route::auth();
    Route::get('/home', 'HomeController@index');

    //Dashboard do usuário
    Route::get('meus_pedidos/{id}', 'PedidosController@meus_pedidos');
    Route::get('meu_resumo/{id}', 'PedidosController@meu_resumo');
    Route::put('usuario_senha/{id}', 'UsuariosController@usuario_senha');
    Route::post('UploadImagePerfil/', 'UsuariosController@UploadImagePerfil');

});
