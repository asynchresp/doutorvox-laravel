/* Setup general page controller */
MetronicApp.controller('LoginPageController', ['$rootScope', '$scope', 'settings', '$http', function($rootScope, $scope, settings, $http) {
    $scope.$on('$viewContentLoaded', function() {   
    	// initialize core components
    	Metronic.initAjax();
    });
}]);
MetronicApp.controller('InicialController', ['$rootScope', '$scope', 'settings', '$http', '$state', 'localStorageService', function($rootScope, $scope, settings, $http, $state, localStorageService) {
    $scope.$on('$viewContentLoaded', function() {   
    	// initialize core components
    	Metronic.initAjax();
    });
	
	var constPerfilAdvogado = 2;
	var constPerfilAdmin = 0;
	var constPerfilPessoaFisica = 1;
	var constPerfilEscritorio = 3;
	
	$http.get('get_usuario_logado').success(function(data){
        if(data.success){
			$rootScope.$state = $state; // state to be accessed from view
			localStorageService.set('AuthUsuario', data.retorno);
			if(data.retorno.perfil == constPerfilAdvogado){
				window.location = "/#/profile/dashboard";
			} else
				window.location = '/';
        } else {
            bootbox.alert(data.ErroMessage, function(result) {
                window.location = '/login';
            });
        }
    }).error(function(data, status, headers, config) {
        bootbox.alert('Não foi possivel reconhecer seu usuário, favor entrar novamente no sistema.', function(result) {
            window.location = '/login';
        });
    });
}]);
