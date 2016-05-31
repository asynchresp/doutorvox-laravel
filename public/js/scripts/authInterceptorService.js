(function () {
    'use strict';

    MetronicApp.factory('authInterceptorService', ['$q', '$location', 'localStorageService', '$window',
        function ($q, $location, localStorageService, $window) {

        var servico = {};

        var _request = function (config) {

            config.headers = config.headers || {};

            var authData = localStorageService.get('authorizationData');

            if (authData) {
                config.headers.Authorization = 'Bearer ' + authData.token;
            }

            return config;
        }

        var _responseError = function (rejection) {
            console.log(rejection);
            if (rejection.status === 401) {

                $window.location.href = '/login';
                //$location.path('/login');
                //localStorageService.remove('authorizationData');
                localStorageService.clearAll();
            }
            //if (rejection.status === 404) {
            //    toaster.pop('success', "Error", rejection.statusText);
            //}
            return $q.reject(rejection);
        }

        servico.request = _request;
        servico.responseError = _responseError;

        return servico;
    }]);

})();