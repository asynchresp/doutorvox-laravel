/***
 Metronic AngularJS App Main Script
 ***/
var $=jQuery;

/* Metronic App */
var MetronicApp = angular.module("MetronicApp", [
    "ui.router",
    "ui.bootstrap",
    "oc.lazyLoad",
    "ngSanitize",
    "ngTable",
    "angularFileUpload"
]);


/* Configure ocLazyLoader(refer: https://github.com/ocombe/ocLazyLoad) */
MetronicApp.config(['$ocLazyLoadProvider', function($ocLazyLoadProvider) {
    $ocLazyLoadProvider.config({
        cssFilesInsertBefore: 'ng_load_plugins_before' // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
    });
}]);

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

   $scope.verificar_login = function(){
       /*$http.get('verifica_usuario_logado').success(function(data){
            if(data.success){
                setTimeout(function(){$scope.verificar_login();}, 60000);
            } else {
                bootbox.alert(data.ErroMessage, function(result) {
                    window.location = '/login';
                });
            }
        }).error(function(data, status, headers, config) {
            bootbox.alert('Não foi possivel reconhecer seu usuário, favor entrar novamente no sistema.', function(result) {
                window.location = '/login';
            });
        });*/
    }

    $scope.verificar_login();
}]);

/***
 Layout Partials.
 By default the partials are loaded through AngularJS ng-include directive. In case they loaded in server side(e.g: PHP include function) then below partial
 initialization can be disabled and Layout.init() should be called on page load complete as explained above.
 ***/

/* Setup Layout Part - Header */
MetronicApp.controller('HeaderController', ['$scope','$http', function($scope, $http) {
    $scope.$on('$includeContentLoaded', function() {
        Layout.initHeader(); // init header
    });

    /*$http.get('get_usuario_logado').success(function(data){
        if(data.idusuario){
            $scope.usuario_logado = data;
        } else {
            bootbox.alert(data.ErroMessage, function(result) {
                window.location = '/login';
            });
        }
    }).error(function(data, status, headers, config) {
        bootbox.alert('Não foi possivel reconhecer seu usuário, favor entrar novamente no sistema.', function(result) {
            window.location = '/login';
        });
    });*/

    $scope.logout = function(){
        $http.get('logout').success(function(data){
            if(data == "Unauthorized."){
                window.location = 'login';
            } else {
                bootbox.alert(data.ErroMessage, function(result) {
                });
            }
        }).error(function(data, status, headers, config) {
            if(data == "Unauthorized."){
                window.location = 'login';
            } else
                bootbox.alert('Não foi possivel reconhecer seu usuário, favor entrar novamente no sistema.', function(result) {
            });
        });
    };
}]);

/* Setup Layout Part - Sidebar */
MetronicApp.controller('SidebarController', ['$scope','$http', function($scope,$http) {
    $scope.$on('$includeContentLoaded', function() {
        Layout.initSidebar(); // init sidebar
    });

    $http.get('menu').success(function(data){
        $scope.menus = data.menus;
    });
}]);

/* Setup Layout Part - Sidebar */
MetronicApp.controller('PageHeadController', ['$scope', function($scope) {
    $scope.$on('$includeContentLoaded', function() {
        Demo.init(); // init theme panel
    });
}]);

/* Setup Layout Part - Footer */
MetronicApp.controller('FooterController', ['$scope', function($scope) {
    $scope.$on('$includeContentLoaded', function() {
        Layout.initFooter(); // init footer
    });
}]);

/* Setup Rounting For All Pages */
MetronicApp.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {

    // Redirect any unmatched url
    $urlRouterProvider.otherwise("/dashboard.html");

    $stateProvider

    // Dashboard
        .state('dashboard', {
            url: "/dashboard.html",
            templateUrl: "views/dashboard.html",
            data: {pageTitle: 'Dashboard', pageSubTitle: 'estatísticas e relatórios'},
            controller: "DashboardController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'MetronicApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                            'assets/global/plugins/morris/morris.css',
                            'assets/admin/pages/css/tasks.css',

                            'assets/global/plugins/morris/morris.min.js',
                            'assets/global/plugins/morris/raphael-min.js',
                            'assets/global/plugins/jquery.sparkline.min.js',

                            'assets/admin/pages/scripts/index3.js',
                            'assets/admin/pages/scripts/tasks.js',

                            'js/controllers/DashboardController.js'
                        ]
                    });
                }]
            }
        })

        // Empresa
        .state('Empresa', {
            url: "/empresas.html",
            templateUrl: "views/empresas.html",
            data: {pageTitle: 'Clientes/Empresas', pageSubTitle: 'Lista de clientes/empresas', controller_php: 'usuario', label:'empresa'},
            controller: "GenericBasicController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'MetronicApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                            'js/controllers/GenericBasicController.js',
                            'assets/admin/pages/scripts/table-managed.js'
                        ]
                    });
                }]
            }
        })

        // Empresa Editar
        .state('EmpresaEditar', {
            url: "/empresas_editar/:id",
            templateUrl: "views/empresas_editar.html",
            data: {pageTitle: 'Clientes/Empresas', pageSubTitle: 'Cadastro de clientes/empresas', controller_php: 'usuario', label:'empresa'},
            controller: "EmpresaEditarController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'MetronicApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                            'js/controllers/EmpresaEditarController.js',
                            'js/scripts/mask.js',
                            'assets/global/plugins/angularjs/plugins/ui-select/select.min.css',
                            'assets/global/plugins/angularjs/plugins/ui-select/select.min.js',


                            "assets/global/plugins/select2/select2.min.js",
                            "assets/global/plugins/datatables/media/js/jquery.dataTables.min.js",
                            "assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
                            "assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js",
                            "assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js",
                            "assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js",
                            "assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js",
                            "assets/global/plugins/fancybox/source/jquery.fancybox.pack.js"
                        ]
                    });
                }]
            }
        })

        // Pedido Editar
        .state('PedidoEditar', {
            url: "/pedido_editar/:id",
            templateUrl: "views/pedido_editar.html",
            data: {pageTitle: 'Pedidos', pageSubTitle: 'Cadastro de pedidos', controller_php: 'pedidos', label:'pedido'},
            controller: "PedidoEditarController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'MetronicApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                            'js/controllers/PedidoEditarController.js',
                            'js/scripts/mask.js',
                            'assets/global/plugins/angularjs/plugins/ui-select/select.min.css',
                            'assets/global/plugins/angularjs/plugins/ui-select/select.min.js',


                            "assets/global/plugins/select2/select2.min.js",
                            "assets/global/plugins/datatables/media/js/jquery.dataTables.min.js",
                            "assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js",
                            "assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js",
                            "assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js",
                            "assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js",
                            "assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js",
                            "assets/global/plugins/fancybox/source/jquery.fancybox.pack.js"
                        ]
                    });
                }]
            }
        })


        //ServicoPrestadoController
        .state('Servicos Prestado', {
            url: "/servicos.html",
            templateUrl: "views/servicos.html",
            data: {pageTitle: 'Diligências', pageSubTitle: 'Cadastro de Diligências', controller_php: 'diligencia', label:'servicos'},
            controller: "GenericBasicController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'MetronicApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                            'js/controllers/GenericBasicController.js',
                            'assets/admin/pages/scripts/table-managed.js'
                        ]
                    });
                }]
            }
        })


        //Feeds Noticias
        .state('Feeds', {
            url: "/feeds.html",
            templateUrl: "views/feeds.html",
            data: {pageTitle: 'Feeds', pageSubTitle: 'Cadastro de Feeds de Notícias', controller_php: 'feed', label:'feeds'},
            controller: "GenericBasicController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'MetronicApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                            'js/controllers/GenericBasicController.js',
                            'assets/admin/pages/scripts/table-managed.js'
                        ]
                    });
                }]
            }
        })

        //Cidade
        .state('Cidade', {
            url: "/cidades.html",
            templateUrl: "views/cidades.html",
            data: {pageTitle: 'Cidades', pageSubTitle: 'Cadastro de Cidades', controller_php: 'cidade', label:'cidades'},
            controller: "GenericBasicController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'MetronicApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                            'js/controllers/GenericBasicController.js',
                            'assets/admin/pages/scripts/table-managed.js'
                        ]
                    });
                }]
            }
        })

        //Perfil
        .state('Perfil', {
            url: "/perfils.html",
            templateUrl: "views/perfils.html",
            data: {pageTitle: 'Perfils', pageSubTitle: 'Cadastro de Perfil', controller_php: 'perfil', label:'perfils'},
            controller: "GenericBasicController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'MetronicApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                            'js/controllers/GenericBasicController.js',
                            'assets/admin/pages/scripts/table-managed.js'
                        ]
                    });
                }]
            }
        })

        //Pagamentos
        .state('Pagamentos', {
            url: "/pagamentos.html",
            templateUrl: "views/pagamentos.html",
            data: {pageTitle: 'Pagamentos', pageSubTitle: 'Cadastro de Pagamentos', controller_php: 'pagamento', label:'pagamento'},
            controller: "GenericBasicController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'MetronicApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                            'js/controllers/GenericBasicController.js',
                            'assets/admin/pages/scripts/table-managed.js'
                        ]
                    });
                }]
            }
        })

        //Pedidos
        .state('Pedidos', {
            url: "/pedidos.html",
            templateUrl: "views/pedidos.html",
            data: {pageTitle: 'Pedidos', pageSubTitle: 'Cadastro de Pedidos', controller_php: 'pedido', label:'pedidos'},
            controller: "PedidoController",
            resolve: {
                deps: ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({
                        name: 'MetronicApp',
                        insertBefore: '#ng_load_plugins_before', // load the above css files before '#ng_load_plugins_before'
                        files: [
                            'js/controllers/PedidoController.js',
                            'assets/admin/pages/scripts/table-managed.js'
                        ]
                    });
                }]
            }
        })
}]);

/* Init global settings and run the app */
MetronicApp.run(["$rootScope", "settings", "$state", function($rootScope, settings, $state) {
    $rootScope.$state = $state; // state to be accessed from view
}]);

function paginacao($scope,ngTableParams,arrayPaginacao,porPagina){
    $scope.tableParams = new ngTableParams({
        page: 1,
        count: porPagina
    }, {
        total: arrayPaginacao.length,
        getData: function($defer, params) {
            $defer.resolve(arrayPaginacao.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    });
}

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
        closeInSeconds: 5, // auto close after defined seconds
        icon: icon // put icon before the message = warning / check / user
    });
}
