'use strict';
MetronicApp.controller('EmpresaEditarController', function($rootScope, $scope, $filter, $http, $timeout, ngTableParams, $state, FileUploader) {
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
            nome : "" ,
            email : "" ,
            password : "" ,
            cpf_cnpj : "" ,
            telefone : "" ,
            residencial : "" ,
            comercial : "" ,
            celular	: "" ,
            tipo : "" ,
            logradouro : "" ,
            bairro : "" ,
            idcidade : "" ,
            cep : ""
        };

        $scope.object_cadastro.andamentos = [];
    };

    $scope.loading = true;
    $scope.painel_1 = true;
    $scope.painel_2 = false;
    $scope.painel_3 = false;
    $scope.painel_4 = false;

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
            $http.get('/usuario/'+$state.params.id).success(function(data){
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
        $("#pagamentos").removeClass("active");
        $("#propostas").removeClass("active");
        $("#pedidos").removeClass("active");

        if(id == 1){
            $scope.painel_1 = true;
            $("#detalhes").addClass("active");
        }
        if(id == 2){
            $scope.painel_2 = true;
            $("#pagamentos").addClass("active");
        }
        if(id == 3){
            $scope.painel_3 = true;
            $("#propostas").addClass("active");
        }
        if(id == 4){
            $scope.painel_4 = true;
            $("#pedidos").addClass("active");
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

    $scope.salvar = function(){
        if($scope.object_cadastro.idcidade == "Object")
            $scope.object_cadastro.idcidade = $scope.object_cadastro.idcidade.id;
        if(!$scope.object_cadastro.id){
            $http.post('/usuario/',$scope.object_cadastro).success(function(data){
                $scope.object_cadastro.id = data.retorno.id;
                exibirMensagemAlert($("#mensagem-status"), 'Cadastrado com sucesso', 'success', 'check');
                $scope.cadastar = false;
            }).error(function(data, status, headers, config) {
                exibirMensagemAlert($("#mensagem-status"), 'Erro ao cadastrar registro', 'warning', 'warning');
            });
        } else {
            $http.put('/usuario/'+$scope.object_cadastro.id,$scope.object_cadastro).success(function(data){
                $scope.object_cadastro.id = data.retorno.id;
                exibirMensagemAlert($("#mensagem-status"), 'Cadastrado com sucesso', 'success', 'check');
                $scope.cadastar = false;
            }).error(function(data, status, headers, config) {
                exibirMensagemAlert($("#mensagem-status"), 'Erro ao cadastrar registro', 'warning', 'warning');
            });
        }
    };

});
