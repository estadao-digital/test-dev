/**
 * @author  Rodrigo Souza <rodrigo.souza@aker.com.br>
 * @license www.aker.com.br Proprietary
 */
(function () {
    'use strict';

    angular.module('app')
            .factory('csv', csv);

    function csv() {

        var obj             = {};
        obj.pushIfNotExists = pushIfNotExists;
        obj.getFields       = getFields;
        obj.getParsedArray  = getParsedArray;
        obj.makeDownload    = makeDownload;
        obj.jsonToCsv       = jsonToCsv;

        /**
         * Insere em array se item se não existir em array
         *
         * @param array array
         * @param string item
         * @returns void
         */
        function pushIfNotExists (array, item) {

            // ignoro os indices _id
            if (item === '_id') {
                return;
            }

            if (array.indexOf(item) === -1) {
                array.push(item);
            }
        };

        /*
         * Monta um array com todos os campos possíveis que estão existentes em
         * array.
         *
         * @param array array
         * @return array
         */
        function getFields (array) {
            var fields = [];
            array.forEach(function (item) {
                for (var field in item) {
                    obj.pushIfNotExists(fields, field);
                }
            });

            return fields;
        };

        /*
         * Faz o trabalho principal que é deixar todos os objetos com a mesma
         * quantidade de campos para que não ocorra deslocamentos no csv
         *
         * @param array array
         * @return array array de objetos
         */
        function getParsedArray (array) {
            var objects = [];

            // Obtém uma lista de todos campos existentes
            var fields = obj.getFields(array);

            array.forEach(function (item) {
                // Cria um objeto temporário
                var tmp = {};

                // Apenas para entendimento, os campos foram quebrados em variáveis
                fields.forEach(function (field) {
                    // Atribui do campo à value, vazio, caso não exista
                    var value = item[field] || '';

                    // verificando se o campo e do tipo data
                    if (value instanceof Object) {
                        // @TODO realizar verificacao para objetos do tipo date
                        value = value.sec;
                    }

                    // Obviamente field não vai existir em tmp, logo, será criado
                    tmp[field] = value;
                });

                objects.push(tmp);
            });

            return objects;
        };

        /**
         * Converte o array de objetos passado por parametro em arquivo json.
         * Apos a conversao, lanca o arquivo para download.
         *
         * @param array json Array de objetos
         * @param string filename nome do arquivo csv gerado
         * @returns void
         */
        function jsonToCsv (json, filename, forceDownload) {

            if (filename === undefined) {
                filename = 'Logs.csv';
            }

            var arr = obj.getParsedArray(json);
            var ret = [];

            // montando o cabecalho
            ret.push('"' + Object.keys(arr[0]).join('","') + '"');

            // montando o corpo
            var size = arr.length;
            for (var i = 0, len = size; i < len; i++) {
                var line = [];
                for (var key in arr[i]) {
//                    if (arr[i].hasOwnProperty(key)) {
                        line.push('"' + arr[i][key] + '"');
//                    }
                }
                ret.push(line.join(','));
            }

            // preparando o arquivo para download
             obj.makeDownload(ret, filename, forceDownload);
        };

        function makeDownload (object, filename, forceDownload) {
            var saving = document.createElement('a');
            saving.href = 'data:attachment/csv,' + encodeURIComponent(object.join('\n'));
            saving.download = filename;
            document.body.appendChild(saving);

            /* istanbul ignore next */
            if (forceDownload) {
                saving.click();
            }
        }

        return obj;
    }

})();
