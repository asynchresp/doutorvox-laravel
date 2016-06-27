/***
 Metronic AngularJS App Main Script
 ***/
var $=jQuery;

/* Metronic App */
var MetronicApp = angular.module("CadastroApp", [
    "ui.router",
    'blockUI',
    'LocalStorageModule'
]);

/* Setup App Main Controller */
MetronicApp.controller('CadastroController', ['$scope','$http' ,'$rootScope', function($scope,$http ,$rootScope) {
    /**
     * 1 Pessoa Física
     * 2 Advogado
     * 3 Escritório
     */
    $scope.objeto_cadastro = {
        tipo: 1,
        nome : "" ,
        email : "" ,
        password : "" ,
        cpf_cnpj : "" ,
        telefone : "" ,
        residencial : "" ,
        comercial : "" ,
        celular	: "" ,
        logradouro : "" ,
        bairro : "" ,
        idcidade : "" ,
        OAB : "" ,
        cep : ""
    };

    $scope.cadastrador = false;

    $http.get("/cidade_cadastro").success(function(data){
        $scope.lista_cidades = data;
        $('#cidade').select2({
            placeholder: "Selecione as cidades do pedido",
            allowClear: true
        });
    }).error(function(data, status, headers, config) {
        exibirMensagemAlert($("#mensagem-status"), 'Não foi possivel encontrar a lista de itens.', 'warning', 'warning');
    });

    $scope.salvarCadastro = function(){
        var sErro = "";

        if(!validateEmail($scope.objeto_cadastro.email) || $scope.objeto_cadastro.email == ""){
            console.log($scope.objeto_cadastro.email);
            sErro = 'Preencha o seu e-mail corretamente.';
        }

        if($scope.objeto_cadastro.tipo == 3)
            $scope.objeto_cadastro.cpf_cnpj = $scope.objeto_cadastro.cnpj;
        else
            $scope.objeto_cadastro.cpf_cnpj = $scope.objeto_cadastro.cpf;

        if($scope.objeto_cadastro.cpf_cnpj == null){
            if($scope.objeto_cadastro.tipo == 3)
                sErro = 'Preencha o CNPJ da sua empresa.';
            else
                sErro = 'Preencha o seu CPF.';
        }

        if($scope.objeto_cadastro.nome == ""){
            sErro = "Preencha o seu Nome.";
        }

        if($scope.objeto_cadastro.idcidade == "Object")
            $scope.objeto_cadastro.idcidade = $scope.objeto_cadastro.idcidade.id;

        if(sErro != ""){
            $("#mensagem-status").html(sErro);
            $("#mensagem-status").css('display','block');
            return;
        } else
            $("#mensagem-status").css('display','none');

        $http.post('/cadastrar_novo/',$scope.objeto_cadastro).success(function(data){
            if(data.success){
                $("#mensagem-status-success").html('Cadastrado com sucesso');
                $("#mensagem-status-success").css('display','block');
                $scope.cadastrador = true;
            } else {
                $("#mensagem-status").html(data.message);
                $("#mensagem-status").css('display','block');
            }
        }).error(function(data, status, headers, config) {
            $("#mensagem-status").html('Erro ao cadastrar registro');
        });

    }

    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test( $email );
    }

}]);

/* Setup Rounting For All Pages */
MetronicApp.config(['$stateProvider', '$httpProvider', '$urlRouterProvider', 'localStorageServiceProvider', 'blockUIConfig', function($stateProvider, $httpProvider, $urlRouterProvider, localStorageServiceProvider, blockUIConfig) {
	blockUIConfig.template = '<div class="loader-wrapper"><div class="loader"></div></div>';
}]);

/* Init global settings and run the app */
MetronicApp.run(["$rootScope", "$state", "localStorageService", "$http", function($rootScope, $state, localStorageService, $http) {
	$rootScope.$state = $state; // state to be accessed from view
}]);

MetronicApp.directive('restrictInput', [function () {

    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var ele = element[0];
            var regex = RegExp(attrs.restrictInput);
            var value = ele.value;

            ele.addEventListener('keyup', function (e) {
                if (regex.test(ele.value)) {
                    value = ele.value;
                } else {
                    ele.value = value;
                }
            });
        }
    };
}]);

