var App = angular.module("App",
    [
        //'ngTouch',
        'ngRoute',
        'ui.bootstrap',
        //'jcs-autoValidate'
    ]);

App.factory("config",['$location', function ($location) {
    return {
        baseUrl: $location.protocol() + '://' + $location.host() + ($location.port() ? ":" + $location.port() : "") + "/"

    }
}])

App.config(['$routeProvider', '$locationProvider', '$httpProvider', function ($routeProvider, $locationProvider, $httpProvider) {
   
    

    $routeProvider.when('/', {
        url: '/',
        templateUrl: './views/index.html',
        controller: 'HomeController'
    });

    $routeProvider.when('/app/Carro', {
        url: '/app/Carro',
        templateUrl: './views/carro.html',
        controller: 'CarroController'
    });

    $routeProvider.when('/app/Marca', {
        url: '/app/Marca',
        templateUrl: './views/marca.html',
        controller: 'MarcaController'
    });

    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
    }).hashPrefix('/');
}])