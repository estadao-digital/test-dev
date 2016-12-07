App.controller("CarroController", ['$scope', '$http', 'config', '$modal', function ($scope, $http, config, $modal) {
    $scope.create = function (carro) {
        $http.post(config.baseUrl + "./api/carros", carro).success(function (response) {
            $scope.carro = response;
            $scope.close();
            $scope.carros.push(response);
        })
    }

    $scope.getAll = function () {
        $http.get(config.baseUrl + "./api/carros").success(function (response) {

            $scope.carros = response;
            
        })
    }

    $scope.getById = function (id) {
        $http.get(config.baseUrl + "./api/carros/", id).success(function (response) {

            $scope.carro = response;
        })
    }

    $scope.update = function (carro) {
        $http.put(config.baseUrl + "./api/carros/"+carro.index, carro).success(function (response) {

            $scope.getAll();
            $scope.close();
        })
    }

    $scope.delete = function (index) {
        $http.delete(config.baseUrl + "./api/carros/"+ index).success(function (response) {         
            
            $scope.getAll();
        })
    }

    $scope.getMarcas = function () {
        $http.get(config.baseUrl + "./api/marca/getMarcas").success(function (response) {

            $scope.marcas = response;
        })
    }

    $scope.save = function (carro) {
        if(!carro)
            return;
        if (carro && carro.index)
            $scope.update(carro)
        else
            $scope.create(carro)
    }

    $scope.open = function (index,carro) {
        if (carro){
            $scope.carro = angular.copy(carro);
            $scope.carro.index = index;
        }
        if (!$scope.carroModal)
            $scope.carroModal = $modal.open({
                templateUrl: "carroModalTpl",
                scope: $scope,
                backdrop: 'static'
            });
    }
    
    $scope.getMarca=function(id){
        var result;
        $.each($scope.marcas,function(index,obj){
            if(obj.Id==id){
                result=obj.Nome;
                return;
            }
            
        });
        
        return result;
    }
    
    $scope.getMarcas();
    $scope.getAll();

    $scope.close = function (carro) {
        if ($scope.carroModal) {
            $scope.carroModal.close();
            $scope.carroModal = null;
            $scope.carro = null;
        }
    }

}])