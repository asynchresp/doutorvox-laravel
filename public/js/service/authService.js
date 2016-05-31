(function () {
    'use strict';

    var app = angular.module('app');

    app.factory('authService', ['$http', '$q', 'localStorageService', 'appConfiguracao', 'perfilService', 'autorizacaoService', '$window',
        function ($http, $q, localStorageService, appConfiguracao, perfilService, autorizacaoService, $window) {

            var servico = {};

            var _autenticacao = {
                isAutenticado: false
            };

            var _entrar = function (dadosLogin) {

                var data = "grant_type=password&username=" + dadosLogin.nome + "&password=" + dadosLogin.senha + "&empresa=" + dadosLogin.empresa;

                var deferred = $q.defer();

                $http.post(appConfiguracao.virtualPath + 'token', data, { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } })
                    .success(function (response) {

                        localStorageService.set('authorizationData', {
                            token: response.access_token
                        });

                        $window.location.href = appConfiguracao.virtualPath_Inicio;
                        deferred.resolve(response);

                    }).error(function (err, status) {
                    deferred.reject(err);
                });

                return deferred.promise;
            };

            var _sair = function () {

                var href = appConfiguracao.virtualPath_Login;

                if (_autenticacao.empresaNome != undefined)
                    href += "#?empresa=" + _autenticacao.empresaNome

                localStorageService.clearAll();
                _autenticacao.isAutenticado = false;
                $window.location.href = href;
            };

            var _fillAuthData = function () {
                var authData = localStorageService.get('authorizationData');
                if (authData) {
                    _autenticacao.isAutenticado = true;
                }
            }

            var _verificarLogin = function () {
                var authData = localStorageService.get('authorizationData');
                if (!authData)
                    _sair();
            }

            var _carregarPerfil = function () {

                perfilService.meuPerfil()
                    .then(function (results) {

                        _autenticacao.perfil = results.data.Perfil;

                        _autenticacao.usuarioId = results.data.UsuarioId,
                            _autenticacao.username = results.data.Login;
                        _autenticacao.nome = results.data.Nome;
                        _autenticacao.email = results.data.Email;
                        _autenticacao.empresaId = results.data.EmpresaId;
                        _autenticacao.empresaNome = results.data.EmpresaNome;

                        localStorageService.set('Autenticacao', _autenticacao);

                        autorizacaoService.montarAutorizacao();

                    }, function (error) {
                        console.error(error);
                        //$window.location.href = appConfiguracao.virtualPath_Login;
                    });

            }



            servico.entrar = _entrar;
            servico.sair = _sair;
            servico.fillAuthData = _fillAuthData;
            servico.autenticacao = _autenticacao;
            servico.verificarLogin = _verificarLogin;
            servico.carregarPerfil = _carregarPerfil;

            return servico;
        }]);
})();