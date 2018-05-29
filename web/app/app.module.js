/**
 * Este registra a aplicação app e suas dependências.
 * Nada mais deve ser incluído nele. Todas as configurações precisam
 * ser colocadas em app.config.js
 *
 * @author Rodrigo Pereira de Souza Silva <rodrigo.souza@aker.com.br>
 * @name            Front-end
 * @description     Require.js launcher
 */

(function () {
    'use strict';

    var app = angular.module('app', [
        'angular.filter',
        'ngResource',
        'ngAnimate',
        'ui.router',
        'pascalprecht.translate',
        'ngStorage',
        'ngSanitize',
        'ui.bootstrap',
        'ngCookies',
        'toaster',
        'ngFileUpload',
        'ngTable',
        'ui.utils.masks',
        'oc.lazyLoad',
        'ui.sortable',
        'ui.select',
        'ui.bootstrap.datetimepicker',
        'ui.dateTimeInput',
        'rb.select-all-on-focus'
    ]);
})();
