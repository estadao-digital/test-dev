(function() {
    'use strict';

    angular.module('app')
        .controller('ProfileRegisterCtrl', ProfileRegisterCtrl);

    ProfileRegisterCtrl.$inject =
        ['$scope', '$stateParams', 'Data', '$state', 'NgTableParams', '$filter', '$translate'];

    function ProfileRegisterCtrl($scope, $stateParams, Data, $state, NgTableParams, $filter, $translate) {

        var vm = this;
        vm.tableParams = {};
        vm.filter = {};
        vm.values = {};
        vm.values.Id = '';
        vm.values.Name = '';
        vm.values.Functionalities = {};
        vm.values.Widgets = {};
        vm.widgetList = {};
        vm.functionalitiesList = [];
        vm.functionalitiesListTrans = [];
        vm.checkedAll = {};
        vm.filters = [];
        vm.hideShowRows = true;

        vm.isPartialChecked = isPartialChecked;

        /*-----------------------------------------*/
        // Inicialização de funções //

        vm.init = init;
        vm.funcGroup = funcGroup;
        vm.getFuncList = getFuncList;
        vm.funcByGroup = funcByGroup;
        vm.checkedAllPerm = checkedAllPerm;
        vm.checkUncheckAll = checkUncheckAll;
        vm.saveProfile = saveProfile;
        vm.ngTableReload = ngTableReload;
        vm.translateFuncList = translateFuncList;
        vm.showRows = showRows;
        vm.getData = getData;

        /* --------------------------------------- */

        function init() {

            // Chamo o metodo que faz a requisição das funcionalidades ao backend.
            vm.getFuncList();

            if ($stateParams.id) {
                var routeGetProfile = 'profile/get/' + $stateParams.id;
                Data.get(routeGetProfile).then(function (results) {
                    vm.values.Name = results.ACL.Name;
                    vm.values.Id = results.ACL.Id;
                });

                var routeGetFunc = 'profile/functionality-get/' + $stateParams.id;
                Data.get(routeGetFunc).then(function (results) {
                    vm.values.Functionalities = results.ACL;
                    // Recarrego a table ao fim da requisição, Para atualizar
                    // e evitar problemas de assincronicidade.
                    vm.tableParams.reload();
                });
            }

            // Caso a linguagem mude, traduzo a lista da table.
            // $scope.$watch('selectLang', function (newValue, oldValue) {
            //     vm.functionalitiesListTrans = [];
            //     vm.translateFuncList();
            //     vm.tableParams.reload();
            // }, true);

            vm.tableParams = new NgTableParams({
                page: 1,            // show first page
                count: 500,          // count per page
                filter: vm.filters
            }, {
                groupBy: 'Group',
                getData: vm.getData
            });
        }

        function getData($defer, params) {
            var orderedData = params.filter() ?
                   $filter('filter')(vm.functionalitiesListTrans, params.filter().myfilter) :
                   vm.functionalitiesListTrans;

            $defer.resolve(orderedData.slice(
                (params.page() - 1) * params.count(),
                params.page() * params.count()
            ));
        }

        // Recarrego a table.
        function ngTableReload () {
            vm.tableParams.reload();
        }

        // Metodo que abre os rows da tree view na table.
        // Se o filtro conter algo, abro as rows.
        // Se não, fecho as rows.
        function showRows () {
            if (vm.filters.myfilter) {
                vm.hideShowRows = false;
                return;
            }

            vm.hideShowRows = true;
        }

        // Retorno todas funcionalidades existentes do sistema.
        // Para preencher a lista.
        function getFuncList() {
            var route = 'profile/functionality-list';
            var post = {pagination: {maxPerPage:500}};
            Data.post(route, post).then(function (results) {
                vm.functionalitiesList = results.ACL;
                vm.translateFuncList();
                ngTableReload();
            });
        }

        // Traduzo as funcionalidades para exibir de acordo com o idioma do usuario.
        function translateFuncList() {
            angular.forEach(vm.functionalitiesList, function (value, key) {
                var funcListAux = {};

                funcListAux.NameForTranslate = value.NameForTranslate;
                funcListAux.GroupForTranslate = value.GroupForTranslate;
                funcListAux.Name = value.Name;
                funcListAux.Group = value.Group;

                vm.functionalitiesListTrans.push(funcListAux);

                /*$translate(value.NameForTranslate).then(function (name) {
                    funcListAux.NameForTranslate = name;
                });

                $translate(value.GroupForTranslate).then(function (group) {
                    funcListAux.GroupForTranslate = group;
                });

                // Esses serão os nomes originais para que o angular dê bind
                // no nome NAO traduzido. (Que é o certo para o banco)
                funcListAux.Name = value.Name;
                funcListAux.Group = value.Group;

                vm.functionalitiesListTrans.push(funcListAux);*/
            });

            // Retorno a lista de funcionalidades com os 2 campos traduzidos
            // para exibição. (mantendo os campos em paralelo originais para o
            // bind do angular).
            return vm.functionalitiesListTrans;

        }

        //retorno de qual grupo pertence uma funcionalidade.
        function funcGroup($func){
            var group = null;
            angular.forEach(vm.functionalitiesList, function (value, key) {
                if (value.Name == $func) {
                    group = value.Group;
                }
            });

            return group;
        }

        // retorno todas funcionalidades de acordo com o grupo passado.
        function funcByGroup ($group) {
            var funcs = {};
            angular.forEach(vm.functionalitiesList, function (value, key) {
                if (value.Group == $group) {
                    funcs[key] = value.Name;
                }
            });

            return funcs;
        }

        // Caso todas as funcionalidades de um determinado grupo estejam
        // marcadas como Leitura ou Escrita (r OU w), ao carregar, já
        // pré-marco o checkbox do grupo, indicando que aquela permissao
        // esta toda marcada.
        function checkedAllPerm($perm, $group){

            var ret = false;
            var funcList = vm.funcByGroup($group);

            for (var key in funcList) {
                if ((vm.values.Functionalities[vm.functionalitiesList[key].Name] !== $perm) ||
                    (vm.funcGroup(vm.functionalitiesList[key].Name) !== $group))
                {
                    ret = false;
                    break;
                }

                ret = true;

            }

            return ret;
        }

        // Marco ou desmarco todas funcionalidades do grupo de acordo
        // com a permissao.
        function checkUncheckAll($perm, $group) {
            var funcList = vm.funcByGroup($group);

            angular.forEach(funcList, function(value, key){
                vm.values.Functionalities[value] = $perm[$group];
            });
        }

        //Esta funcao serve para chamar o jquery somente depois
        //que o ng-repeat tiver terminado sua execução.
        // $scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {
        //     $('#chosen').chosen();
        // });

        function saveProfile() {

            // Verifico se dentro do objeto existe valores falsos para
            // nao enviar para o backend.
            angular.forEach(vm.values.Functionalities, function(value, key){
                if (value === false) {
                    delete (vm.values.Functionalities[key]);
                }
            });

            angular.forEach(vm.values.Widgets, function(value, key){
                if (value === false) {
                    delete (vm.values.Widgets[key]);
                }
            });

            Data.post('profile/write', vm.values).then(function (results) {
                Data.toast(results);
                $state.go('app.profileList');
            }, function (error) {
                Data.toast(error, true);
            });
        }

        /**
         * Verifica se os checkbox de cada grupo estao parcialmente marcados.
         * Caso positivo, um novo estilo sera' aplicado no layout do campo
         * checkbox que marca todos
         *
         * @param  {String}  groupName Nome do grupo de checkbox
         * @param  {String}  chkValue  Valor default do checkbox
         * @return {Boolean}
         * @author Paulo Balzi <paulo.balzi@aker.com.br>
         */
        function isPartialChecked(groupName, chkValue)
        {
            var formField = '#chk_' + chkValue + '_' + groupName;
            var permSelected = vm.values.Functionalities;
            var countChecked = 0;
            var groupPerm = vm.functionalitiesListTrans.filter(function(value) {
                if (groupName == value.Group) {
                    return value;
                }
            });

            angular.forEach(groupPerm, function(entry){
                if (permSelected[entry.Name] && permSelected[entry.Name] === chkValue) {
                    countChecked++;
                }
            });

            angular.element(formField).prop('checked', true);

            if (countChecked === 0) {
                angular.element(formField).prop('checked', false);
                return false;
            }

            if (countChecked === groupPerm.length) {
                return false;
            }

            return true;
        }
    }
})();

