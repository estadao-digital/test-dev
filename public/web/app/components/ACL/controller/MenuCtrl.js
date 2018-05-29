(function() {
    'use strict';

    angular
        .module('app')
        .controller('MenuCtrl', MenuCtrl);

    MenuCtrl.$inject = ['Data', '$localStorage', 'config'];

    /**
     * [MenuCtrl description]
     * @param {[type]} $scope       [description]
     * @param {[type]} Data         [description]
     */
    function MenuCtrl(Data, $localStorage, config) {

        var vm = this;
        vm.ret = false;
        vm.userRoutes = {};

        vm.verifyRoute = verifyRoute;

        /* ----------------------------- */

        function verifyRoute(route, type) {

            vm.userRoutes = $localStorage.settings.routes;

            for (var key in vm.userRoutes) {
                if ((key == route) &&
                ((vm.userRoutes[key] == type) || (vm.userRoutes[key] == 'w')))
                {
                    vm.ret = true;
                    break;
                }

                vm.ret = false;
            }

            return vm.ret;
        }

    }
})();
