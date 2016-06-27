'use strict';
MetronicApp.controller('PedidoEditarController', function($rootScope, $scope, $filter, $http, $timeout, ngTableParams, $state, FileUploader, localStorageService) {
    $scope.$on('$viewContentLoaded', function() {   
        // initialize core components
        Metronic.initAjax();
        bootbox.setLocale("br");
    });
    
    $scope.init = function(controller, label)
    {
      $scope.controller_name = controller;
      $scope.label = label;

		$scope.object_cadastro = {
			id : "" ,
			status : "",
			finalizado : '',
			tipo_pagamento : '',
			valor_minimo : '',
			valor_maximo : '',
			idcidade : '',
			diligencias : '',
			avaliacoes : '',
			candidatos : '',
		};

		$scope.object_cadastro.andamentos = [];
    };

	$scope.usuario = localStorageService.get('AuthUsuario');

    $scope.loading = true;
	$scope.painel_1 = false;
	$scope.painel_2 = false;
	$scope.painel_3 = false;
	$scope.painel_4 = false;
	if($scope.usuario.perfil != 2)
    	$scope.painel_1 = true;
	else
		$scope.painel_4 = true;

	
	 var servico = false, cidade = false;
	 
	 $scope.cadastrar_andamento = false;
    
    $scope.controller_name = $state.current.data.controller_php;
    $scope.label = $state.current.data.label;
    
	$http.get('/diligencia').success(function(data){
		$scope.lista_diligencias = data;
		servico = true;
		$scope.buscarEmpresa();
	}).error(function(data, status, headers, config) {
		exibirMensagemAlert($("#mensagem-status"), 'Não foi possivel encontrar a lista de diligências.', 'warning', 'warning');
	});
	
	$http.get('/cidade').success(function(data){
		$scope.lista_cidades = data;
		cidade = true;
		$scope.buscarEmpresa();
	}).error(function(data, status, headers, config) {
		exibirMensagemAlert($("#mensagem-status"), 'Não foi possivel encontrar a lista de cidades.', 'warning', 'warning');
	});
	          
    $scope.buscarEmpresa = function(){
    	if(!servico || !cidade)
    		return;
    	
    	if($state.params.id){
    	    $http.get('/pedido/'+$state.params.id).success(function(data){
    	    	console.log(data);
    			$scope.object_cadastro = data;
    			if($scope.object_cadastro.diligencias.length > 0)
    				$scope.object_cadastro.diligencias = $scope.object_cadastro.diligencias.split(',');
    			
    			$('#diligencias').select2({
    		        placeholder: "Selecione as diligências do pedido",
    		        allowClear: true
    		    });    	

				$("#diligencias").select2("val", $scope.object_cadastro.diligencias); 
    			
    			$('#cidades').select2({
    				placeholder: "Selecione as cidades do pedido",
    				allowClear: true
    			});    			
    			
				$("#cidades").select2("val", $scope.object_cadastro.idcidade);

				if($scope.usuario.perfil == 2){
					for(var i = 0; i < $scope.lista_cidades.length; i++){
						if($scope.lista_cidades[i].id == $scope.object_cadastro.idcidade) {
							$scope.show_cidade = $scope.lista_cidades[i].cidade+" ("+$scope.lista_cidades[i].estado+")";
							break;
						}
					}

					//$scope.show_diligencias
					$scope.show_diligencias = "";
					for(var i = 0; i < $scope.object_cadastro.diligencias.length; i++){
						console.log($scope.object_cadastro.diligencias[i]);
						for(var w = 0; w < $scope.lista_diligencias.length; w++){
							if($scope.lista_diligencias[w].id == $scope.object_cadastro.diligencias[i]) {
								console.log($scope.lista_diligencias[w]);
								$scope.show_diligencias += $scope.lista_diligencias[w].nome+", ";
								break;
							}
						}
					}
					if($scope.show_diligencias.length > 0)
						$scope.show_diligencias = $scope.show_diligencias.substr(0, $scope.show_diligencias.length -2);
				}
				
    			$scope.loading = false;
    		}).error(function(data, status, headers, config) {
    			$scope.loading = false;
    			exibirMensagemAlert($("#mensagem-status"), 'Não foi possivel encontrar o pedido informada.', 'warning', 'warning');
    		});	
    	} else {

    		$('#diligencias').select2({
		        placeholder: "Selecione as diligências do pedido",
		        allowClear: true
		    });
    		
    		$('#cidades').select2({
		        placeholder: "Selecione as cidades do pedido",
		        allowClear: true
		    });
			
			$scope.loading = false;
    	}
    };

    $scope.tabs = function(id){
    	$scope.painel_1 = false;
    	$scope.painel_2 = false;
    	$scope.painel_3 = false;
    	$scope.painel_4 = false;

    	$("#detalhes").removeClass("active");
    	$("#candidatos").removeClass("active");
    	$("#andamentos").removeClass("active");
    	$("#detalhes_pedido").removeClass("active");

    	if(id == 1){
    		$scope.painel_1 = true;
    		$("#detalhes").addClass("active");
    	}
    	if(id == 2){
    		$scope.painel_2 = true;
    		$("#candidatos").addClass("active");
    	}
    	if(id == 3){
    		$scope.painel_3 = true;
    		$("#andamentos").addClass("active");
    	}
		if(id == 4){
    		$scope.painel_4 = true;
    		$("#detalhes_pedido").addClass("active");
    	}

    };
    
    $scope.excluir = function(id){
    	 bootbox.confirm("Deseja realmente excluir este(a) "+$scope.label+"?", function(result) {
             if(result){
            	 $http.delete('/'+$scope.controller_name+'/'+id).success(function(data){
         			if(data === 'deletou'){
         				$scope.object_cadastro = false;
         				exibirMensagemAlert($("#mensagem-status"), 'Deletado com sucesso', 'success', 'check');
         			}else{
         				exibirMensagemAlert($("#mensagem-status"), 'Erro ao deletar registro. '+data, 'warning', 'warning');
         			}
         		}).error(function(data, status, headers, config) {
        			exibirMensagemAlert($("#mensagem-status"), 'Erro ao deletar registro. '+data, 'warning', 'warning');
        		});
             }
         });
	};
	
    $scope.salvarPendente = function(){
		$scope.object_cadastro.status = 2;
		$scope.salvar();
	};

    $scope.salvarFinalizado = function(){
		bootbox.confirm("Deseja realmente finalizar seu pedido? Esta ação fará com que seu pedido seja considerado concluído e nenhum andamento podera ser adicionado ao mesmo.", function(result) {
			if(result){
				$scope.object_cadastro.status = 5;
				$scope.object_cadastro.finalizado = 1;
				$scope.salvar();
			}
		});
	};

    $scope.salvar = function(){
		console.log($scope.object_cadastro);
		if($scope.object_cadastro.idcidade == "Object")
			$scope.object_cadastro.idcidade = $scope.object_cadastro.idcidade.id;
		if(!$scope.object_cadastro.id){
			$http.post('/pedido/',$scope.object_cadastro).success(function(data){
				$scope.object_cadastro.id = data.retorno.id;
				$scope.object_cadastro.status = data.retorno.status;
				exibirMensagemAlert($("#mensagem-status"), 'Cadastrado com sucesso', 'success', 'check');
				$scope.cadastar = false;
			}).error(function(data, status, headers, config) {
				exibirMensagemAlert($("#mensagem-status"), 'Erro ao cadastrar registro', 'warning', 'warning');
			});
		} else {
			$http.put('/pedido/'+$scope.object_cadastro.id,$scope.object_cadastro).success(function(data){
				$scope.object_cadastro.id = data.retorno.id;
				exibirMensagemAlert($("#mensagem-status"), 'Cadastrado com sucesso', 'success', 'check');
				$scope.cadastar = false;
			}).error(function(data, status, headers, config) {
				exibirMensagemAlert($("#mensagem-status"), 'Erro ao cadastrar registro', 'warning', 'warning');
			});
		}
    };
    
    
    /**
     * Sessão onde salva os andamentos
     */
    $scope.object_andamento = {id:"", idpedido: "",comentario : "", status: ""};
    
	$scope.cadastrar_andamento_action = function(){
		$scope.cadastrar_andamento = true;
		$scope.object_andamento = {
				id:"",
				idpedido: "",
				comentario: '',
				status: ''
		};
	};

	$scope.cadastrar_cancelar = function(){
		$scope.cadastrar_andamento = false;
		$scope.object_andamento = {
			id:"",
			idpedido: "",
			comentario: '',
			status: ''
		};
	};

	$scope.salvar_andamento = function(){
		$scope.object_andamento.idpedido = $scope.object_cadastro.id;
		console.log($scope.object_andamento);
		if($scope.object_andamento.id == "") {
			$http.post('/andamento', $scope.object_andamento).success(function (data) {
				if ($scope.object_cadastro.andamentos.indexOf($scope.object_andamento) < 0) {
					$scope.object_cadastro.andamentos.unshift(data.retorno);
					//$scope.tableParams.reload();
				}

				console.log(data.retorno);
				$scope.object_andamento = {
					status: '',
					comentario: '',
					idpedido: '',
					id: ''
				};

				$scope.object_cadastro.status = data.retorno.status;
				$scope.salvar();

				exibirMensagemAlert($("#mensagem-status"), 'Andamento cadastrado com sucesso', 'success', 'check');
				$scope.cadastrar_andamento = false;
			}).error(function (data, status, headers, config) {
				exibirMensagemAlert($("#mensagem-status"), 'Erro ao cadastrar andamento', 'warning', 'warning');
			});
		} else {
			$http.put('/andamento/'+$scope.object_andamento.id, $scope.object_andamento).success(function (data) {
				if ($scope.object_cadastro.andamentos.indexOf($scope.object_andamento) < 0) {
					$scope.object_cadastro.andamentos.unshift(data.retorno);
					//$scope.tableParams.reload();
				}

				console.log(data.retorno);
				$scope.object_andamento = {
					status: '',
					comentario: '',
					idpedido: '',
					id: ''
				};

				$scope.object_cadastro.status = data.retorno.status;
				$scope.salvar();

				exibirMensagemAlert($("#mensagem-status"), 'Andamento cadastrado com sucesso', 'success', 'check');
				$scope.cadastrar_andamento = false;
			}).error(function (data, status, headers, config) {
				exibirMensagemAlert($("#mensagem-status"), 'Erro ao cadastrar andamento', 'warning', 'warning');
			});
		}
	};
	
	
	$scope.aprovar_proposta = function(index){
		index.aprovado = 1;
		if(index.id) {
			$http.put('/candidato/'+index.id, index).success(function (data) {
				if ($scope.object_cadastro.candidatos.indexOf(index) != null) {
					$scope.object_cadastro.candidatos[$scope.object_cadastro.candidatos.indexOf(index)].aprovado = data.candidato.aprovado;
				}

				$scope.object_cadastro.status = 3;
				$scope.salvar();

				exibirMensagemAlert($("#mensagem-status"), 'Proposta aprovado com sucesso', 'success', 'check');
			}).error(function (data, status, headers, config) {
				exibirMensagemAlert($("#mensagem-status"), 'Erro ao aprovado proposta', 'warning', 'warning');
			});
		}
	};
	
	$scope.alterar_andamento = function(index){	
    	$scope.cadastrar_andamento = true;
    	$scope.object_andamento = index;
		$("html, body").animate({ scrollTop: 0 }, "slow");
	};

});
