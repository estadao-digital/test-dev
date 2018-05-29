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

        vm.confirmDeleteRule = function(ruleId, ruleName) {
            vm.deleteRuleId = ruleId;
            vm.deleteRuleName = ruleName;
            $('#modalDeleteRule').modal('show');
        };

        vm.deleteRule = function() {
            if (vm.deleteRuleId === undefined) {
                return;
            }

            Data.get('carros/delete/'+vm.deleteRuleId)
                .then(function(data) {
                    vm.deleteRuleId = undefined;
                    vm.deleteRuleName = undefined;
                    $('#modalDeleteRule').modal('hide');
                    Data.toast(data, false);
                    vm.search();
            }, function(err){
                $('#modalDeleteRule').modal('hide');
                Data.toast(err, true);
            });

        };

        vm.search = function() {
            vm.tableParams.reload();
        };

        vm.buildTableRules = function() {
            vm.tableParams = ngTableHelper.buildTable('carros/get-all', 'data', vm.filter);
        };
    }
})();
