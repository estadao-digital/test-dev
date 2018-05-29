(function() {
    'use strict';

    angular.module('app')
        .factory('Data', Data)
        .config(['$httpProvider', function ($httpProvider) {
            // envia o cookie do login em todas as requisicoes
            $httpProvider.defaults.withCredentials = true;
        }]);

    Data.$inject = [
        'config', '$http', 'toaster', 'Upload', '$cookies', '$localStorage', '$translate',
        '$q', '$state', '$rootScope'
    ];

    // Esse serviço conecta o front-end a REST API
    function Data(
        config, $http, toaster, Upload, $cookies, $localStorage, $translate, $q, $state, $rootScope
    ) {
        var obj = {};

        obj.translate = translate;
        obj.toast = toast;
        obj.get = get;
        obj.post = post;
        obj.upload = upload;
        obj.put = put;
        obj.delete = deleteHttp;

        function translate (m, timeout) {
            $translate(m).then(
                function (text) {
                    toaster.pop(status, '', text, timeout);
                },
                function () {
                   toaster.pop(status, '', m, timeout);
                }
            );
        }

        function toast (data, error) {
            var customTimeout = 5000;

            status = 'success';

            if (error) {
                status = 'error';
            }

            if (data.mongoInfo) {
                customTimeout = 0;
                status = 'info';
            }

            if (!data.hasOwnProperty('messages')) {
                obj.translate(data.message, customTimeout);
                return;
            }

            for (var field in data.messages) {
                obj.translate(data.messages[field][0], customTimeout);
            }
        }

        function get (q) {
            return $http.get(config.apiUrl + q)
                .then(function (results) {
                    return results.data;
                }, function (errorResult) {
                    return $q.reject(errorResult.data);
                });
        }


        function post (q, object) {
            $rootScope.$emit('post');

            return $http.post(config.apiUrl + q, object)
                .then(function (results) {
                    return results.data;
                }, function (errorResult) {
                    return $q.reject(errorResult.data);
                });
        }

        function upload (q, file, object) {
            return Upload.upload({
                url: config.apiUrl + q,
                fields: object,
                withCredentials: true,
                file: file
            }).progress(function (evt) {

            }).success(function (results, status, headers, config) {
                return results.data;
            });
        }

        function put (q, object) {
            return $http.put(config.apiUrl + q, object)
                .then(function (results) {
                    return results.data;
                }, function (errorResult) {
                    return $q.reject(errorResult.data);
                });
        }

        function deleteHttp (q) {
            return $http.delete(config.apiUrl + q)
                .then(function (results) {
                    return results.data;
                }, function (errorResult) {
                    return $q.reject(errorResult.data);
                });
        }

        return obj;
    }

})();
