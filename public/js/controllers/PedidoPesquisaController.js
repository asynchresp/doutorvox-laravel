'use strict';
MetronicApp.controller('PedidoPesquisaController', function($rootScope, $scope, $filter, $http, $timeout, ngTableParams, $state, localStorageService) {
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
    $scope.usuario = localStorageService.get('AuthUsuario');
    $scope.controller_name = $state.current.data.controller_php;
    $scope.label = $state.current.data.label;


    $http.get('ultimos_pedidos').success(function (data) {
        if (data.length > 0) {
            $scope.lista = data;
            paginacao($scope, ngTableParams, $scope.lista, 10);
        } else
            exibirMensagemAlert($("#mensagem-status"), 'Nenhum pedido encontrado no momento.', 'success', 'success');
    }).error(function (data, status, headers, config) {
        exibirMensagemAlert($("#mensagem-status"), 'Não foi possivel encontrar a lista de itens.', 'warning', 'warning');
    });

    $scope.pesquisar = function() {
        $http.get('ultimos_pedidos').success(function (data) {
            if (data.length > 0) {
                $scope.lista = data;
                paginacao($scope, ngTableParams, $scope.lista, 10);
            } else
                exibirMensagemAlert($("#mensagem-status"), 'Você não possui pedidos em andamento.', 'success', 'success');
        }).error(function (data, status, headers, config) {
            exibirMensagemAlert($("#mensagem-status"), 'Não foi possivel encontrar a lista de itens.', 'warning', 'warning');
        });
    }

    $scope.cadastar = false;
    $scope.cadastar_proposta = false;

    $scope.proposta = function(servico){
        $scope.cadastar_proposta  = true;
        $scope.object_cadastro = servico;
        $scope.object_proposta = {};
        $scope.object_proposta.idpedido = servico.id;
        $scope.object_proposta.idusuario = $scope.usuario.id;
        console.log($scope.object_proposta);
        $("html, body").animate({ scrollTop: 0 }, "slow");
    };

    $scope.salvar_proposta = function(){
        console.log($scope.object_proposta);
        $http.post('candidato',$scope.object_proposta).success(function(data){

            $scope.cadastar = false;
            $scope.object_cadastro = false;
            if(data.success) {
                exibirMensagemAlert($("#mensagem-status"), 'Proposta enviada com sucesso', 'success', 'check');
            } else {
                exibirMensagemAlert($("#mensagem-status"), data.message, 'warning', 'check');
            }

        }).error(function(data, status, headers, config) {
            exibirMensagemAlert($("#mensagem-status"), 'Erro ao enviar proposta', 'warning', 'warning');
        });;
    };

});
