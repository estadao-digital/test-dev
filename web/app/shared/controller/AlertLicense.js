(function() {
    'use strict';

    angular.module('app')
        .controller('AlertLicenseCtrl', AlertLicenseCtrl);

    AlertLicenseCtrl.$inject = ['$sessionStorage'];

    function AlertLicenseCtrl($sessionStorage) {

        var DAYS_TO_SHOW_ALERT = 30;

        var vm = this;
        vm.expirationDays = '';

        // functions
        vm.init = init;
        vm.closeAlert = closeAlert;
        vm.showAlert = showAlert;

        /**
         * init
         *
         * @return void
         * @author Paulo Balzi <paulo.balzi@aker.com.br>*
         */
        function init() {
            vm.expirationDays = $sessionStorage.expirationDays;
        }

        /**
         * Fecha a mensagem de alerta da licença
         *
         * @return void
         * @author Paulo Balzi <paulo.balzi@aker.com.br>
         */
        function closeAlert() {
            $sessionStorage.showAlertLicense = false;
        }

        /**
         * Retorna um boolean indicando se e' para mostrar o alerta ou nao
         *
         * @return {boolean} True para mostrar o alerta e falso para o contrario
         * @author Paulo Balzi <paulo.balzi@aker.com.br>
         */
        function showAlert() {
            if (typeof vm.expirationDays === 'number' &&
                (vm.expirationDays <= DAYS_TO_SHOW_ALERT &&
                ($sessionStorage.showAlertLicense === undefined ||
                $sessionStorage.showAlertLicense === true))) {
                return true;
            }

            return false;
        }
    }
})();
