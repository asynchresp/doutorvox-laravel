'use strict';

MetronicApp.controller('DashboardController', function($rootScope, $scope, $http, $timeout, localStorageService) {
    $scope.$on('$viewContentLoaded', function() {   
        // initialize core components
        Metronic.initAjax();
		var usuario = localStorageService.get('AuthUsuario');

		// Redirect any unmatched url
		if(usuario.perfil == constPerfilAdvogado){
			window.location = "#/profile/dashboard";
		}
    });

	$scope.usuario = localStorageService.get('AuthUsuario');

	if($scope.usuario.perfil == 0) {
		$http.get('/advogado_dashboard').success(function (data) {
			$scope.lista_empresa = data.usuarios;
		}).error(function (data, status, headers, config) {
			exibirMensagemAlert($("#mensagem-status"), 'NÃ£o foi possivel encontrar a lista de itens.', 'warning', 'warning');
		});
	}
    
    $http.get('/pedido_dashboard').success(function(data){
		$scope.lista_pedidos = data.pedidos;
	}).error(function(data, status, headers, config) {
		exibirMensagemAlert($("#mensagem-status"), 'NÃ£o foi possivel encontrar a lista de itens.', 'warning', 'warning');
	});

});