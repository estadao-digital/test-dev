var TestDev = angular.module('TestDev', ['ngRoute']);

 // define our canstant for the API
TestDev.constant('constants', {
        API_URL: 'http://localhost/test-dev/api/'
    });

// configure our routes
TestDev.config(function($routeProvider) {
    $routeProvider
        // route for the hamburgers page
        .when('/', {
            templateUrl : 'app/carros/carros.template.htm',
            controller  : 'carrosController'
        })

        // route for a single hamburger
        .when('/carros/:carroID', {
            templateUrl : 'app/carros/carros.template.htm',
            controller  : 'carroController'
        })

        // default route
        .otherwise({
               redirectTo: '/'
        });
});
