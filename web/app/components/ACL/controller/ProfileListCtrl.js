(function() {
    'use strict';

    angular.module('app')
        .controller('ProfileListCtrl', ProfileListCtrl);

    ProfileListCtrl.$inject = ['Data', 'ngTableHelper'];

    function ProfileListCtrl(Data, ngTableHelper) {

        var vm = this;
        vm.tableParams = {};
        vm.filter = {};

        vm.init = init;
        vm.buildProfileTable = buildProfileTable;
        vm.searchProfile = searchProfile;
        vm.deleteProfile = deleteProfile;

        /* ---------------------------- */

        function init() {
            vm.buildProfileTable();
        }

        function buildProfileTable() {
            vm.tableParams = ngTableHelper.buildTable('profile/list', 'ACL', vm.filter);
        }

        function searchProfile() {
            vm.tableParams.reload();
        }

        function deleteProfile(id) {
            if (confirm('Deseja realmente excluir esse perfil?')) {
                Data.get('profile/delete/' + id).then(function (results) {
                    Data.toast(results);
                }, function (results) {
                    Data.toast(results, true);
                })
                .finally(function () {
                    vm.tableParams.reload();
                });
            }
        }
    }
})();
