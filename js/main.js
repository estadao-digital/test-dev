//create angularjs controller
var app = angular.module('app', []);//set and get the angular module
app.controller('carrosController', ['$scope', '$http', carrosController]);

//angularjs controller method

function carrosController($scope, $http) {
    //declare variable for mainain ajax load and entry or edit mode
    $scope.loading = true;
    $scope.addMode = false;
    $scope.success = false;
    $scope.error = false;

    tempoMensagem = 1000;

    getInfo();
    getMarcas();
    function getInfo(){
        // Sending request to EmpDetails.php files
        $http.get('/test-dev/api/carros/')
            .then(function (response) {
                $scope.carros = response.data;
                $scope.loading = false;
            });
    }
    function getMarcas(){
        // Sending request to EmpDetails.php files
        $http.get('/test-dev/api/marcas/')
            .then(function (response) {
                $scope.marcas = response.data;
            });
    }

    //by pressing toggleEdit button ng-click in html, this method will be hit
    $scope.toggleEdit = function () {
        this.carro.editMode = !this.carro.editMode;
    };

    //by pressing toggleAdd button ng-click in html, this method will be hit
    $scope.toggleAdd = function () {
        $scope.addMode = !$scope.addMode;
    };

    //Inser Customer
    $scope.add = function () {
        $scope.loading = true;
        $http.post("/test-dev/api/carros/", this.novoCarro)
            .then(function (response) {
                getInfo();
                $scope.addMode = false;
                $scope.loading = false
                $scope.successMessage = "Adicionado com sucesso";
                $scope.success = true;
                setTimeout(function(){     $scope.success = false; }, tempoMensagem);
            });
    }

    //Edit Customer
    $scope.save = function () {
        $scope.loading = true;
        var car = this.carro;

        $.ajax({
            type: 'PUT',
            dataType: "json",
            contentType: 'application/json',
            url: '/test-dev/api/carros/'+car.id,
            data: JSON.stringify(car),
            success: function (data) {
                getInfo();
                car.editMode = false;
                $scope.loading = false;
                $scope.successMessage = "Editado com sucesso";
                $scope.success = true;
                setTimeout(function(){     $scope.success = false; }, tempoMensagem);
            },
            error: function (data) {
                $scope.errorMessage = "An Error has occured while Saving customer! " + data;
                $scope.loading = false;
            }
        });
    };

    //Delete Customer
    $scope.deletecustomer = function () {
        $scope.loading = true;
        var id = this.carro.id;
        $.ajax({
            type: 'DELETE',
            dataType: "json",
            contentType: 'application/json',
            url: '/test-dev/api/carros/'+id,
            success: function (data) {
                getInfo();
                $scope.successMessage = "Deletado com sucesso!";
                $scope.loading = false;
                $scope.success = true;
                setTimeout(function(){     $scope.success = false; }, tempoMensagem);
            },
            error: function (data) {
                $scope.errorMessage = "Ocorreu um erro ao deletar";
                $scope.loading = false;
                $scope.error = true;
                setTimeout(function(){     $scope.error = false; }, tempoMensagem);
            }
        });
    };

}