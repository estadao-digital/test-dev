(function () {
    'use strict';

    angular.module('app')
            .controller('CarCtrl', CarCtrl);

    CarCtrl.$inject = ['$stateParams', '$http', '$state', 'Data', 'toaster'];

    function CarCtrl($stateParams, $http, $state, Data, toaster) {

        var vm = this;
        vm.rule = {};
        vm.text = {};

        vm.operators = [
            {id: 'rx', name: 'Expressão regular'},
            {id: 'beginsWith', name: 'Começa com'},
            {id: 'contains', name: 'Contém'},
            {id: 'containsWord', name: 'Contém a palavra'},
            {id: 'endsWith', name: 'Termina com'},
            {id: 'eq', name: 'Igual'},
            {id: 'ge', name: 'Maior ou igual'},
            {id: 'gt', name: 'Maior'},
            {id: 'ipMatch', name: 'Ip Match'},
            {id: 'le', name: 'Menor ou igual'},
            {id: 'lt', name: 'Menor'},
            {id: 'pm', name: 'Match performático'},
            {id: 'rbl', name: 'rbl'},
            {id: 'rsub', name: 'rsub'},
            {id: 'streq', name: 'String Igual'},
            {id: 'strmatch', name: 'String Match'},
            {id: 'validateByteRange', name: 'Byte range válido'},
            {id: 'validateDTD', name: 'DTD válido'},
            {id: 'validateHash', name: 'Hash válido'},
            {id: 'validateSchema', name: 'Schema válido'},
            {id: 'validateUrlEncoding', name: 'Url encoding válido'},
            {id: 'validateUtf8Encoding', name: 'Utf8 encoding válido'},
            {id: 'verifyCC', name: 'verifica CC'},
            {id: 'verifyCPF', name: 'verifica CPF'},
            {id: 'verifySSN', name: 'verifica SSN'},
            {id: 'within', name: 'Está contido'}
        ];

        vm.detectionType = [
            {id: 'ARGS', name: 'Variaveis GET ou POST (ARGS)'},
            {id: 'ARGS_GET', name: 'Variaveis GET (ARGS_GET)'},
            {id: 'ARGS_POST', name: 'Variaveis POST (ARGS_POST)'},
            {id: 'REQUEST_HEADERS', name: 'Cabecalho HTTP (REQUEST_HEADERS)'},
            {id: 'REMOTE_ADDR', name: 'Endereco IP (REMOTE_ADDR)'},
            {id: 'FULL_REQUEST', name: 'Pedido Completo (FULL_REQUEST)'},
            {id: 'FULL_REQUEST_LENGTH', name: 'Tamanho do Pedido (FULL_REQUEST_LENGTH)'},
            {id: 'REMOTE_USER', name: 'Usuario Autenticado (REMOTE_USER)'},
            {id: 'REQUEST_COOKIES_NAMES', name: 'Nome de cookies (REQUEST_COOKIES_NAMES)'},
            {id: 'REQUEST_COOKIES', name: 'Valores de cookies (REQUEST_COOKIES)'},
            {id: 'REQUEST_HEADERS:user_agent', name: 'User-Agent do navegador (user_agent)'},
            {id: 'REQUEST_HEADERS:x-time', name: 'Horario do Pedido em formato americano (RQ:x-time)'},
            {id: 'IP:blocks', name: 'Numero de ocorrencias (IP:blocks)'}
        ];

        vm.actions = [
            {id: 'block', name: 'Block'},
            {id: 'allow', name: 'Allow'},
            {id: 'log,pass', name: 'Audit Only'},
        ];

        // functions
        vm.init = init;
        vm.salvar = salvar;
        vm.salvarBasic = salvarBasic;
        vm.loadMarks = loadMarks;
        vm.loadVariables = loadVariables;
        vm.getPhaseName = getPhaseName;
        vm.getOperator = getOperator;
        vm.getSeverityName = getSeverityName;
        vm.getGroupName = getGroupName;

        /*jshint camelcase: false */
        function init() {
            vm.loadMarks();

            if ($stateParams.id !== undefined) {
                Data.get('carros/get/' + $stateParams.id)
                        .then(function (data) {
                            vm.rule.id = data.Id;
                            vm.rule.ver = data.Ver;
                            vm.rule.id_group = myToString(data.IdGroup);
                            vm.rule.phase = data.Phase;
                            vm.rule.rev = data.Rev;
                            vm.rule.maturity = myToString(data.Maturity);
                            vm.rule.accuracy = myToString(data.Accuracy);
                            vm.rule.severity = myToString(data.Severity);
                            vm.rule.msg = data.Msg;
                            vm.rule.variables = data.Variables;
                            vm.rule.operator = data.Operator;
                            vm.rule.expression = data.Expression;
                            vm.rule.actions = data.Actions;
                            vm.rule.complement = data.Complement;

                            if (vm.rule.ver && vm.rule.ver !== 0 && vm.rule.ver.indexOf('NSTALKER') > -1)
                            {
                                vm.rule.isBasic = 1;
                                vm.rule.detectionType = vm.rule.variables;
                                if (vm.rule.ver.indexOf('AUDIT') == -1)
                                    vm.rule.audit = 0;
                                else
                                    vm.rule.audit = 1;
                                console.log(vm.rule);
                                $scope.active = 0;
                            } else
                            {
                                $scope.active = 1;
                            }

                            // if ($stateParams.detail !== undefined) {
                            vm.getPhaseName(vm.rule.phase);
                            vm.getOperator(vm.rule.operator);
                            vm.getSeverityName(vm.rule.severity);
                            vm.getGroupName(vm.rule.id_group);
                            // }
                        }, function (err) {

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
            vm.rule.isBasic = 1;
            Data.post('carros/save', vm.rule)
                    .then(function (data) {
                        Data.toast(data, false);
                        $state.go('app.ruleList');
                    }, function (err) {
                        Data.toast(err, true);
                    });
        }
        /**
         * [loadMarks description]
         * @return {[type]} [description]
         */
        function loadMarks() {
            Data.get('carros')
                    .then(function (data) {
                        vm.ruleGroups = data.ruleGroups;
                    }, function (err) {

                    });
        }

        /**
         * Retorna o valor do objeto operator de acordo com o ID
         *
         * @param  {string} id Id do objeto
         * @return {string}    Descricao do ID
         * @author Paulo Balzi <paulo.balzi@aker.com.br>
         */
        function getOperator(id) {
            var oper = vm.operators.find(function (item) {
                return item.id == id;
            });
            vm.text.operatorName = oper.name;
        }

        /**
         * Retorna o texto da severidade de acordo com o ID
         *
         * @param  {integer} id Identificacao da severidade no array
         * @return {string}    Descricao da severidade
         * @author Paulo Balzi <paulo.balzi@gmail.com>
         */
        function getSeverityName(id) {
            var severitys = [
                'EMERGENCY',
                'ALERT',
                'CRITICAL',
                'ERROR',
                'WARNING',
                'NOTICE',
                'INFO',
                'DEBUG'
            ];
            vm.text.severityName = severitys[id];
        }

        /**
         * Retorna a descricao do campo phase
         *
         * @param  {integer} id Indice do array
         * @return {string}     Descricao
         * @author Paulo Balzi <paulo.balzi@gmail.com>
         */
        function getPhaseName(id) {
            var phases = [
                '',
                '1 - Request Headers',
                '2 - Request Body',
                '3 - Response Headers',
                '4 - Response Body',
                '5 - Logging'
            ];
            vm.text.phaseName = phases[id];
        }

        /**
         * Retorna o nome do grupo de regras
         *
         * @param  {integer} id Identificacao do grupo na tabela
         * @return {string}     Nome do grupo de regras
         * @author Paulo Balzi <paulo.balzi@gmail.com>
         */
        function getGroupName(id) {
            Data.get('rule-group/get-group-name/' + id).then(function (data) {
                vm.text.groupName = data.groupName;
            }, function (err) {
                console.log(err);
            });
        }

        /**
         * Converte pra String se o valor existir
         *
         * @param  {String} value Valor a ser convertido
         * @return {String}
         * @author Paulo Balzi <paulo.balzi@gmail.com>
         */
        function myToString(value) {
            return value === null ? null : value.toString();
        }
    }

})();
