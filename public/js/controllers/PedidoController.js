'use strict';
MetronicApp.controller('PedidoController', function($rootScope, $scope, $filter, $http, $timeout, ngTableParams, $state) {
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
    $scope.cadastar_proposta = false;
	
	$scope.proposta = function(servico){	
		$scope.cadastar_proposta  = true;
		$scope.object_cadastro = servico;
		$scope.object_proposta = {};
		$scope.object_proposta.idpedido = servico.id;
		$scope.object_proposta.idusuario = 54;
		console.log($scope.object_proposta);
		$("html, body").animate({ scrollTop: 0 }, "slow");
	};
	
	$scope.salvar_proposta = function(){
		console.log($scope.object_proposta);
		$http.post('app/pedido_cadastrar_proposta',$scope.object_proposta).success(function(data){
			console.log(data);
			$scope.object_cadastro = false;
	
			exibirMensagemAlert($("#mensagem-status"), 'Proposta enviada com sucesso', 'success', 'check');
			$scope.cadastar = false;
		}).error(function(data, status, headers, config) {
			exibirMensagemAlert($("#mensagem-status"), 'Erro ao enviar proposta', 'warning', 'warning');
		});;
};
    
    $scope.excluir = function(index, id){
    	 bootbox.confirm("Deseja realmente excluir este(a) "+$scope.label+"?", function(result) {
             if(result){
            	 $http.delete($scope.controller_name+'_deletar/'+id).success(function(data){
         			if(data === 'deletou'){
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
});
