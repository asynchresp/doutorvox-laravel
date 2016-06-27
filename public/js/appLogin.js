/***
 Metronic AngularJS App Main Script
 ***/
var $=jQuery;

/* Metronic App */
var MetronicApp = angular.module("MetronicLoginApp", [
    "ui.router",
    'blockUI',
    'LocalStorageModule'
]);



/* Setup global settings */
MetronicApp.factory('settings', ['$rootScope', function($rootScope) {
    // supported languages
    var settings = {
        layout: {
            pageSidebarClosed: false, // sidebar state
            pageAutoScrollOnLoad: 1000 // auto scroll to top on page load
        },
        layoutImgPath: Metronic.getAssetsPath() + 'admin/layout/img/',
        layoutCssPath: Metronic.getAssetsPath() + 'admin/layout/css/'
    };

    $rootScope.settings = settings;

    return settings;
}]);

/* Setup App Main Controller */
MetronicApp.controller('AppController', ['$scope','$http' ,'$rootScope', function($scope,$http ,$rootScope) {
    $scope.$on('$viewContentLoaded', function() {
        Metronic.initComponents(); // init core components
        bootbox.setLocale("br");
        //Layout.init(); //  Init entire layout(header, footer, sidebar, etc) on page load if the partials included in server side instead of loading with ng-include directive 
    });
}]);

/* Setup Rounting For All Pages */
MetronicApp.config(['$stateProvider', '$httpProvider', '$urlRouterProvider', 'localStorageServiceProvider', 'blockUIConfig', function($stateProvider, $httpProvider, $urlRouterProvider, localStorageServiceProvider, blockUIConfig) {

    localStorageServiceProvider
        .setPrefix('DoutorVox.Web')
        .setStorageType('localStorage') // localStorage, sessionStorage
        .setNotify(true, true);

	blockUIConfig.template = '<div class="loader-wrapper"><div class="loader"></div></div>';   
}]);

/* Init global settings and run the app */
MetronicApp.run(["$rootScope", "settings", "$state", "localStorageService", "$http", function($rootScope, settings, $state, localStorageService, $http) {
	$rootScope.$state = $state; // state to be accessed from view
}]);

/* Constantes de configurações gerais do sistema. */
var timeoutAlertTime = 2500;
function exibirMensagemAlert (elemento, mensagem, tipo, icon){
    Metronic.alert({
        container: elemento, // alerts parent container(by default placed after the page breadcrumbs)
        place: 'append', // append or prepent in container 
        type: tipo,  // success / danger / warning / info
        message: mensagem,  // alert's message
        close: true, // make alert closable
        reset: true, // close all previouse alerts first
        focus: true, // auto scroll to the alert after shown
        closeInSeconds: 0, // auto close after defined seconds
        icon: icon // put icon before the message = warning / check / user
    });
}
