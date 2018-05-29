(function() {
    'use strict';

    angular.module('app')
        .controller('CarListCtrl', CarListCtrl);

    CarListCtrl.$inject = ['$stateParams', '$http', '$state', 'Data', 'ngTableHelper'];

    function CarListCtrl($stateParams, $http, $state, Data, ngTableHelper) {

        var vm = this;
        vm.rules = [];
        vm.filter = {};
        vm.init = function() {
            vm.buildTableRules();
        };

        vm.confirmDeleteCar = function(carId) {
            vm.deleteCarId  = carId;
            $('#modalDeleteCar').modal('show');
        };

        vm.deleteCar = function() {
            if (vm.confirmDeleteCar === undefined) {
                return;
            }

            $http.delete('/carros/' + vm.deleteCarId, null).then(function (response) {
                console.log(response);
                vm.buildTableRules();
                $('#modalDeleteCar').modal('hide');
            }, function (response) {
                //
            });

        };

        vm.search = function() {
            vm.filtrar();
        };
        vm.filtrar = function() {
            console.log(vm.filter);
             Data.post('carros/lista/filtrar', vm.filter)
                 .then(function(data) {
                    vm.carros = data.carros;
             }, function(err){
                 //
             });
        };
        vm.buildTableRules = function() {
            console.log(vm.filter);
             Data.get('carros/', vm.filter)
                 .then(function(data) {
                    vm.carros = data.carros;
             }, function(err){
                 //
             });
        };
    }
})();
