/**
 * Created by smith
 */
angular.module('CarrosApp').controller('CarroModalController',
    function($scope, $element, title, carro, close, carrosAPI, marcasAPI) {

        $scope.carroEdit = carro;


        $scope.marcas = [];
        $scope.carregarMarcas = function (){
            marcasAPI.getMarcas().success(function (data) {
                $scope.marcas = data;
            }).error(function (data, status) {
                $scope.message = "Aconteceu um problema: " + data;
            });
        };

        // carregar os Combos

        $scope.carregarMarcas();
        $scope.carro = null;
        $scope.title = title;

        $scope.cadastrarCarro = function(carro) {
            carro.marca_id = carro.marca.id;
            carrosAPI.saveCarro(carro).success(function (data) {
                $scope.close();
            }).error(function (data, status) {
                $scope.message = "Aconteceu um problema: " + data;
                $scope.close();
            });

        };

        $scope.alterarCarro = function(carro) {
            carro.marca_id = carro.marca.id;

            carrosAPI.editCarro(carro).success(function (data) {

                $scope.close();
            }).error(function (data, status) {
                $scope.message = "Aconteceu um problema: " + data;
            });

        };

        $scope.close = function() {
            close({
                carro: $scope.carro
            }, 500); // close, but give 500ms for bootstrap to animate
        };

        $scope.cancel = function() {
            //  Manually hide the modal.
            $element.modal('hide');
            //  Now call close, returning control to the caller.
            close({
                'cancel':true
            }, 500); // close, but give 500ms for bootstrap to animate
        };

    });

angular.module('CarrosApp').controller('CarroController', function($scope, $http, carrosAPI, ModalService ) {
    $scope.carros =[];
    $scope.query = {
        order: 'id',
        limit: 10,
        page: 1
    };
    $scope.currentPage = 1;
    $scope.pageSize = null;
    $scope.ordenar = function(keyname){
        $scope.reverse ? $scope.query.order = '-'+keyname:$scope.query.order=keyname;
        $scope.reverse = !$scope.reverse;
        consultar();
    };
    $scope.pagination = {
        current: 1
    };
    $scope.paginar = function(pagina) {
        $scope.query.page =pagina;
        consultar();
    };

    function consultar(){
        carrosAPI.getCarros($scope.query).success(function (data) {
            $scope.carros = data;
            $scope.pageSize = Math.ceil(data.total/$scope.query.limit);

        }).error(function (data, status) {
            $scope.message = "Aconteceu um problema: " + data;
        });
    };

    $scope.edit = function(carro) {
        console.log(carro);
    };
    $scope.delete = function(carro) {
        console.log(carro);
    };


    $scope.showComplex = function() {

        ModalService.showModal({
            templateUrl: "/view/carros/modals/CadastrarCarroModal.html",
            controller: "CarroModalController",
            inputs: {
                title: "Novo Maquina",
                carro:{}
            }
        }).then(function(modal) {
            modal.element.modal();
            modal.close.then(function(result) {
               if(!result.cancel){

                    $scope.complexResult  = result.carro;
                    consultar();
                }else{
                    console.log($scope.complexResult);
                    console.log('Cancelado pelo usuario!');
                }
            });
        });

    };
    consultar();
});

angular.module('CarrosApp').controller('DetalheCarroController',function ($scope, $http, carro, carrosAPI, ModalService) {
    $scope.carro=carro.data;

    $scope.deleteCarro = function(carro) {
        var confirm = window.confirm('Excluir este item?');
        if (confirm){
            carrosAPI.deleteCarro(carro).success(function () {
                alert('Registro excluído com sucesso!');
                window.location.href= "/#/carros";
            }).error(function (data) {
                $scope.message = "Aconteceu um problema: " + data;
            });
        }

    };


    $scope.alterarCarro = function(carro) {
        ModalService.showModal({
            templateUrl: "/view/carros/modals/AlterarCarroModal.html",
            controller: "CarroModalController",
            inputs: {
                title: "Novo Carro",
                carro:$scope.carro
            }
        }).then(function(modal) {
            modal.element.modal();
            modal.close.then(function(result) {
                if(!result.cancel){
                    $scope.complexResult  = result.carro;
                    //$scope.consultarMaquina();
                }else{
                    console.log($scope.complexResult);
                    console.log('Cancelado pelo usuario!');
                }
            });
        });

    };
});
