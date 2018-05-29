(function () {
    'use strict';

    angular.module('app')
            .controller('CarCtrl', CarCtrl);

    CarCtrl.$inject = ['$stateParams', '$http', '$state', 'Data', 'toaster'];

    function CarCtrl($stateParams, $http, $state, Data, toaster) {

        var vm = this;
        vm.carro = {};
        vm.text = {};
        // functions
        vm.init = init;
        vm.salvar = salvar;
        vm.salvarBasic = salvarBasic;
        vm.loadMarks = loadMarks;
       
        /*jshint camelcase: false */
        function init() {
            vm.loadMarks();

            if ($stateParams.id !== undefined) {
                Data.get('carros/' + $stateParams.id)
                        .then(function (data) {
                            vm.carro.id = data.carro.id;
                            vm.carro.modelo = data.carro.modelo;
                            vm.carro.id_marca = data.carro.id_marca;
                        }, function (err) {
                            //
                        });
            }
        }

        /**
         * [salvar description]
         * @return {[type]} [description]
         */
        function salvar() {
            Data.post('carros/save', vm.rule)
                    .then(function (data) {
                        Data.toast(data, false);
                        $state.go('app.ruleList');
                    }, function (err) {
                        Data.toast(err, true);
                    });
        }

        function loadVariables(id)
        {
            var oper = vm.detectionType.find(function (item) {
                return item.id == id;
            });
            vm.text.detectionType = oper.name;
        }

        /**
         * [salvar description]
         * @return {[type]} [description]
         */
        function salvarBasic() {
            if(vm.carro.id > 0) {
                $http.put('/carros/' + vm.carro.id, (vm.carro)).then(function (response) {
                    console.log(response);
                    Data.toast(response.data, false);
                    $state.go('app.carList');
                   // $('#modalDeleteCar').modal('hide');
                }, function (response) {
                    //
                });
                return;
            } 
            $http.post('/carros', (vm.carro)).then(function (response) {
                Data.toast(response.data, false);
                $state.go('app.carList');
            }, function (response) {
                //
            });
            return;
         
        }
        /**
         * [loadMarks description]
         * @return {[type]} [description]
         */
        function loadMarks() {
            Data.get('carros/marcas/listar')
                    .then(function (data) {
                        vm.marcas = data.marcas;
                        console.log(vm.marcas);
                    }, function (err) {

            });
        }

        function myToString(value) {
            return value === null ? null : value.toString();
        }
    }

})();
