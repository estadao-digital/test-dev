/**
 * Serviço referente a autenticação.
 * Inicialmente somente o método de logout foi implementado
 *
 * @author Paulo Balzi <paulo.balzi@aker.com.br>
 */
(function() {
    'use strict';

    angular.module('app')
        .factory('akAuth', akAuth);

    akAuth.$inject = ['$state', 'Data', '$localStorage', '$sessionStorage']

    function akAuth($state, Data, $localStorage, $sessionStorage) {

        var obj = {};
        obj.logout = logout;

        function logout() {
            delete $sessionStorage.showAlertLicense;
            delete $sessionStorage.expirationDays;
            Data.get('login/do-logoff');
            delete $localStorage.user;
            window.location.href = '/logoff';
        };
        return obj;
    }
})();
