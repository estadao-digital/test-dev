angular.module('apiApp', []).
config(['$routeProvider', function($routeProvider) {
    $routeProvider.
     when('/', {templateUrl: 'template/list.html', controller: ListCtrl}).
     when('/cars', {templateUrl: 'template/add.html', controller: AddCtrl}).
     when('/cars/:id', {templateUrl: 'template/edit.html', controller: EditCtrl}).
     otherwise({redirectTo: '/'});
}]);

function ListCtrl($scope, $http) {
    $http.get('api/index.php/cars').success(function(data) {
        $scope.cars = data;
    });
}

function AddCtrl($scope, $http, $location) {
    $scope.master = {};
    $scope.activePath = null;
    $scope.brands = ["Fiat", "Ford", "VolksWagem", "Toyota", "Honda", "GM"];

    $scope.add = function(car, AddForm) {
        $http.post('api/cars', car).success(function(){
            $scope.reset();
            $scope.activePath = $location.path('/');
        });

        $scope.reset = function() {
            $scope.car = angular.copy($scope.master);
        };

        $scope.reset();
    };
}

function EditCtrl($scope, $http, $location, $routeParams, $route) {
    var id = $routeParams.id;
    $scope.activePath = null;
    $scope.response = {};

    $http.get('api/cars/'+id).success(function(data) {
        $scope.cars = data;
    });

    $scope.update = function(car, AddForm){
        $http.put('api/cars/'+car.id, car).success(function(data) {
            $scope.cars = data;
            $scope.activePath = $location.path('/');
        });
    };

    $scope.delete = function(car) {
        console.log(car);
        var deleteCar = confirm('Are you absolutely sure you want to delete?');
        if (deleteCar) {
          $http.delete('api/cars/'+car.id);
          $scope.activePath = $location.path('/');
        }
    };
}