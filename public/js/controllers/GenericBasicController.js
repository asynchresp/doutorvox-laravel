'use strict';
MetronicApp.controller('GenericBasicController', function($rootScope, $scope, $filter, $http, $timeout, ngTableParams, $state) {
	$scope.$on('$viewContentLoaded', function() {
		// initialize core components
		Metronic.initAjax();
		bootbox.setLocale("br");
	});
	$scope.init = function(controller, label)
	{
		$scope.controller_name = controller;
		$scope.label = label;
	};

	$scope.controller_name = $state.current.data.controller_php;
	$scope.label = $state.current.data.label;


	$http.get($scope.controller_name).success(function(data){
		$scope.lista = data;
		paginacao($scope,ngTableParams,$scope.lista,10);
	}).error(function(data, status, headers, config) {
		exibirMensagemAlert($("#mensagem-status"), 'Não foi possivel encontrar a lista de itens.', 'warning', 'warning');
	});;;

	$scope.cadastar = false;

	$scope.alterar = function(index){
		$scope.cadastar = true;
		$scope.object_cadastro = index;
		console.log($scope.object_cadastro);
		$("html, body").animate({ scrollTop: 0 }, "slow");
	};

	$scope.excluir = function(index, id){
		bootbox.confirm("Deseja realmente excluir este(a) "+$scope.label+"?", function(result) {
			if(result){
				$http.delete($scope.controller_name+'/'+id).success(function(data){
					if(data.success){
						var indexof = $scope.lista.indexOf(index);
						$scope.lista.splice(indexof,1);
						$scope.tableParams.reload();
						$scope.cadastar = false;
						$scope.object_cadastro = false;
						exibirMensagemAlert($("#mensagem-status"), 'Deletado com sucesso', 'success', 'check');
					}else{
						exibirMensagemAlert($("#mensagem-status"), 'Erro ao deletar registro. '+data, 'warning', 'warning');
					}
				}).error(function(data, status, headers, config) {
					exibirMensagemAlert($("#mensagem-status"), 'Erro ao deletar registro. '+data, 'warning', 'warning');
				});;;
			}
		});
	};

	$scope.salvar = function(){
		if(!$scope.object_cadastro.id){
			$http.post($scope.controller_name,$scope.object_cadastro).success(function(data){
				if(data.success) {
					if ($scope.lista.indexOf($scope.object_cadastro) < 0) {
						$scope.lista.unshift(data.retorno);
						$scope.tableParams.reload();
					}
					console.log(data.retorno);
					$scope.object_cadastro = false;
					exibirMensagemAlert($("#mensagem-status"), 'Cadastrado com sucesso', 'success', 'check');
					$scope.cadastar = false;
				}
			}).error(function(data, status, headers, config) {
				exibirMensagemAlert($("#mensagem-status"), 'Erro ao cadastrar registro', 'warning', 'warning');
			});
		} else {
			$http.put($scope.controller_name+"/"+$scope.object_cadastro.id,$scope.object_cadastro).success(function(data){
				if($scope.lista.indexOf($scope.object_cadastro) < 0){
					$scope.lista.unshift(data.retorno);
					$scope.tableParams.reload();
				}
				console.log(data.retorno);
				$scope.object_cadastro = false;

				exibirMensagemAlert($("#mensagem-status"), 'Cadastrado com sucesso', 'success', 'check');
				$scope.cadastar = false;
			}).error(function(data, status, headers, config) {
				exibirMensagemAlert($("#mensagem-status"), 'Erro ao cadastrar registro', 'warning', 'warning');
			});
		}
	};
});
