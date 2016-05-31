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

        var authData = localStorageService.get('ResumoProfile');
        if (authData) {
            $scope.resumo = authData;
        } else {
            $http.get('meu_resumo/9').success(function(data){
                $scope.resumo = data.resumo;
                localStorageService.set('ResumoProfile', $scope.resumo);
            }).error(function(data, status, headers, config) {
                exibirMensagemAlert($("#mensagem-status"), 'Não foi possivel encontrar a lista de itens.', 'warning', 'warning');
            });
        }
    });
});

MetronicApp.controller('AccountController', function($rootScope, $scope, $http, $timeout, ngTableParams) {
    $scope.$on('$viewContentLoaded', function() {
        Metronic.initAjax(); // initialize core components
    });
    $rootScope.settings.layout.pageSidebarClosed = true;
});

MetronicApp.controller('UserDashboardController', function($rootScope, $scope, $http, $timeout, ngTableParams) {
    $scope.$on('$viewContentLoaded', function() {
        Metronic.initAjax(); // initialize core components
        $rootScope.settings.layout.pageSidebarClosed = true;
        $http.get('meus_pedidos/9').success(function(data){
            $scope.meus_pedidos = data.pedidos;
            $scope.minhas_propostas = data.propostas;
        }).error(function(data, status, headers, config) {
            exibirMensagemAlert($("#mensagem-status"), 'Não foi possivel encontrar a lista de itens.', 'warning', 'warning');
        });
    });
});
