/**
 * Created by smith
 */
angular.module("CarrosApp").config(function ($routeProvider) {

    $routeProvider.when("/carros", {
        templateUrl: "view/carros/index.html",
        controller: "CarroController"
    });

    $routeProvider.when("/carros/:id", {
        templateUrl: "view/carros/detalhe.html",
        controller: "DetalheCarroController",
        resolve: {
            carro: function (carrosAPI, $route) {
                return carrosAPI.getCarro($route.current.params.id);
            }
        }
    });

    $routeProvider.otherwise({
        redirectTo: "/"});
});