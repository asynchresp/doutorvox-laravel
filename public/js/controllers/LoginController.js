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
	$http.get('get_usuario_logado').success(function(data){
        if(data.success){
			$rootScope.$state = $state; // state to be accessed from view
			localStorageService.set('AuthUsuario', data.retorno);
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
