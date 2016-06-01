'use strict';

MetronicApp.controller('UserProfileController', function($rootScope, $scope, $http, $timeout, localStorageService) {
    $scope.$on('$viewContentLoaded', function() {   
        Metronic.initAjax(); // initialize core components
        Layout.setMainMenuActiveLink('set', $('#sidebar_menu_link_profile')); // set profile link active in sidebar menu
        $scope.resumo = {
                'pedidos_realizados' : 0,
                'avaliacoes' : 0,
                'nota' : 0
        };
        $rootScope.settings.layout.pageSidebarClosed = true;
		$scope.usuario = localStorageService.get('AuthUsuario');
		
        var authData = localStorageService.get('ResumoProfile');
        if (authData) {
            $scope.resumo = authData;
        } else {
            $http.get('meu_resumo/'+$scope.usuario.id).success(function(data){
                $scope.resumo = data.resumo;
                localStorageService.set('ResumoProfile', $scope.resumo);
            }).error(function(data, status, headers, config) {
                exibirMensagemAlert($("#mensagem-status"), 'Não foi possivel encontrar a lista de itens.', 'warning', 'warning');
            });
        }
    });
});

MetronicApp.controller('UserDashboardController', function($rootScope, $scope, $http, $timeout, ngTableParams, localStorageService) {
    $scope.$on('$viewContentLoaded', function() {
        Metronic.initAjax(); // initialize core components
        $rootScope.settings.layout.pageSidebarClosed = true;
		$scope.usuario = localStorageService.get('AuthUsuario');
        $http.get('meus_pedidos/'+$scope.usuario.id).success(function(data){
            $scope.meus_pedidos = data.pedidos;
            $scope.minhas_propostas = data.propostas;
        }).error(function(data, status, headers, config) {
            exibirMensagemAlert($("#mensagem-status"), 'Não foi possivel encontrar a lista de itens.', 'warning', 'warning');
        });

    });
});

MetronicApp.controller('AccountController', function($rootScope, $scope, $http, $state, $timeout, ngTableParams, Upload,localStorageService) {
    $scope.$on('$viewContentLoaded', function() {
        Metronic.initAjax(); // initialize core components
    });
    $rootScope.settings.layout.pageSidebarClosed = true;
	$scope.usuario = localStorageService.get('AuthUsuario');
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

        $scope.trocar_senha = {
            password : "" ,
            new_password : "" ,
            re_password : ""
        };

        $scope.object_cadastro.andamentos = [];
    };

    $scope.loading = true;

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

        if($scope.usuario.id){
            $http.get('/usuario/'+$scope.usuario.id).success(function(data){
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

                $scope.urlFoto = '/fotos_perfil/'+$scope.object_cadastro.imagem_perfil;
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

    $scope.salvar = function(){
        if($scope.object_cadastro.idcidade == "Object")
            $scope.object_cadastro.idcidade = $scope.object_cadastro.idcidade.id;
        if($scope.object_cadastro.id){
            $http.put('/usuario/'+$scope.object_cadastro.id,$scope.object_cadastro).success(function(data){
                $scope.object_cadastro.id = data.retorno.id;
                exibirMensagemAlert($("#mensagem-status"), 'Cadastrado com sucesso', 'success', 'check');
                $scope.cadastar = false;
            }).error(function(data, status, headers, config) {
                exibirMensagemAlert($("#mensagem-status"), 'Erro ao cadastrar registro', 'warning', 'warning');
            });
        }
    };

    $scope.trocarSenha = function(){
        if($scope.trocar_senha.password == "" || $scope.trocar_senha.new_password == "" || $scope.trocar_senha.re_password == "")
            exibirMensagemAlert($("#mensagem-status_senha"), 'Preencha todos os campos corretamente', 'warning', 'warning');
        else if($scope.trocar_senha.new_password.length < 8)
            exibirMensagemAlert($("#mensagem-status_senha"), 'A nova senha precisa conter no minimo 8 caracteres.', 'warning', 'warning');
        else if($scope.trocar_senha.new_password != $scope.trocar_senha.re_password) {
            exibirMensagemAlert($("#mensagem-status_senha"), 'A nova senha e sua confirmação não são iguais.', 'warning', 'warning');
        } else if($scope.object_cadastro.id){
            $http.put('/usuario_senha/'+$scope.object_cadastro.id, $scope.trocar_senha).success(function(data){
                if(data.success)
                    exibirMensagemAlert($("#mensagem-status_senha"), 'Senha alterada com sucesso', 'success', 'check');
                else
                    exibirMensagemAlert($("#mensagem-status_senha"), 'Não foi possivel alterar sua senha: '+data.mensagem, 'warning', 'check');
            }).error(function(data, status, headers, config) {
                exibirMensagemAlert($("#mensagem-status_senha"), 'Erro ao altera sua senha', 'warning', 'warning');
            });
        }
    };

    $scope.urlBaseFotos = 'Fotos/';
    $scope.urlFoto = "";
    $scope.f = null;
    $scope.uploadRealizado = false;

    $scope.uploadFiles = function (file, errFiles) {
        $scope.f = file;
        $scope.errFile = errFiles && errFiles[0];
    }

    $scope.enviarImagem = function () {
        var file = $scope.f;
        if (file) {
            file.upload = Upload.upload({
                url: '/UploadImagePerfil/',
                data: { Id: $scope.object_cadastro.id },
                file: file
            });

            file.upload.then(function (response) {
                if (response.data.success) {
                    $scope.uploadRealizado = true;
                    $scope.urlFoto = '/fotos_perfil/'+response.data.imagem;
                    exibirMensagemAlert($("#mensagem-status_imagem"), "Sua imagem foi enviada com sucesso.", 'success', 'success');
                } else
                    exibirMensagemAlert($("#mensagem-status_imagem"), "Erro ao enviar sua imagem.", 'danger', 'danger');
            }, function (response) {
                if (response.status > 0)
                    $scope.errorMsg = response.status + ': ' + response.data;
            }, function (evt) {
                file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            });
        }
    }
});
