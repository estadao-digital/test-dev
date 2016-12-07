App.controller("MarcaController", ['$scope', '$http', 'config', '$modal', function ($scope, $http, config, $modal) {
    $scope.create = function (marca) {
        $http.post(config.baseUrl + "api/marca/Create", marca).success(function (response) {
            $scope.marca = response;
            $scope.close();
            $scope.marcas.push(response);
        })
    }

    $scope.getAll = function () {
        $http.get(config.baseUrl + "./api/marca/getMarcas").success(function (response) {

            $scope.marcas = response;
        })
    }



    $scope.getById = function (id) {
        $http.get(config.baseUrl + "api/marca/GetById?id=", id).success(function (response) {

            $scope.marca = response;
        })
    }

    $scope.update = function (marca) {
        $http.post(config.baseUrl + "api/marca/Update", marca).success(function (response) {
            $scope.getAll();
            $scope.close();
        })
    }

    $scope.delete = function (marca) {
        $http.post(config.baseUrl + "api/marca/Delete", marca).success(function (response) {

            var index = $scope.marcas.indexOf(marca);
            $scope.marcas.splice(index, 1);
        })
    }

    $scope.save = function (marca) {
        if (marca.Id)
            $scope.update(marca)
        else
            $scope.create(marca)
    }

    $scope.open = function (marca) {
        if (marca)
            $scope.marca = angular.copy(marca);
        if (!$scope.marcaModal)
            $scope.marcaModal = $modal.open({
                templateUrl: "marcaModalTpl",
                scope: $scope,
                backdrop: 'static'
            });
    }
    $scope.getAll();
    $scope.close = function (marca) {
        if ($scope.marcaModal) {
            $scope.marcaModal.close();
            $scope.marcaModal = null;
            $scope.marca = null;
        }
    }

}])