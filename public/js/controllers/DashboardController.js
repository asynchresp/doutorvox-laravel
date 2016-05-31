'use strict';

MetronicApp.controller('DashboardController', function($rootScope, $scope, $http, $timeout) {
    $scope.$on('$viewContentLoaded', function() {   
        // initialize core components
        Metronic.initAjax();
    });
    console.log($scope.usuario_logado);
    $http.get('/advogado_dashboard').success(function(data){
		$scope.lista_empresa = data.usuarios;
	}).error(function(data, status, headers, config) {
		exibirMensagemAlert($("#mensagem-status"), 'NÃ£o foi possivel encontrar a lista de itens.', 'warning', 'warning');
	});
    
    $http.get('/pedido_dashboard').success(function(data){
		$scope.lista_pedidos = data.pedidos;
	}).error(function(data, status, headers, config) {
		exibirMensagemAlert($("#mensagem-status"), 'NÃ£o foi possivel encontrar a lista de itens.', 'warning', 'warning');
	});

});