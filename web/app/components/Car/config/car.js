(function() {
    'use strict';

    angular.module('app')
        .config(Car);

    Car.$inject = ['$stateProvider'];

    function Car($stateProvider) {
        $stateProvider
            .state('app.car', {
                url: '/car/',
                templateUrl: 'app/components/Car/view/car.html',
                controller: 'CarCtrl as vm'
            })
            .state('app.carEdit', {
                url: '/car/{id:int}',
                templateUrl: 'app/components/Car/view/car.html',
                controller: 'CarCtrl as vm'
            })
            .state('app.carList', {
                url: '/car/list/',
                templateUrl: 'app/components/Car/view/car-list.html',
                controller: 'CarListCtrl as vm'
            })
            .state('app.carDetail', {
                url: '/car/detail/{id:int}',
                parent: 'app.carList',
                params : {
                    detail: true
                },
                onEnter: [
                    '$uibModal',
                    '$state',
                    function($uibModal, $state) {
                        $uibModal.open({
                            controller: 'CarCtrl as vm',
                            templateUrl: 'app/components/Car/view/car-detail.html',
                            size: 'lg'
                        }).result.finally(function(){
                            $state.go('app.carList');
                        });
                    }
                ]
            });
    }
})();
