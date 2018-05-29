/**
 * Este arquivo configura todo o módulo app.
 * Adicionar o .config, injetando as dependências e colocando a assinatura
 * de função no fim do array. Essa função precisa receber todas as
 * dependências inseridas no array e configurar o que for necessário
 *
 * @author      Paulo Bezerra <paulo.bezerra@aker.com.br>
 * @name        Front-end
 * @description Require.js launcher
 */

(function () {
    'use strict';

    ///////////////////////////////////////////////////////////////////////////
    //           Variáveis utilizadas na configuração da aplicação           //
    var configUrl = {
        apiUrl: '/apiw/web/'
    };
    ///////////////////////////////////////////////////////////////////////////


    ///////////////////////////////////////////////////////////////////////////
    //                Chamadas das configurações da aplicação                //
    angular.module('app')
        .run([
            '$rootScope', '$localStorage', '$state', '$location', 'Data', '$cookies',
            configStateChange
        ])
        .config(['$locationProvider', configLocationProvider])
        .config(['$translateProvider', configTranslateProvider])
        .config(['$urlRouterProvider', configRouteProvider])
        .config(['$stateProvider', configStateProvider])
        .config(['$qProvider', function ($qProvider) {
            $qProvider.errorOnUnhandledRejections(false);
        }])
        .constant('config', configUrl);

    ///////////////////////////////////////////////////////////////////////////


    ///////////////////////////////////////////////////////////////////////////
    //         Daqui pra baixo, criar as funções com prefixo config.         //

    function configStateChange ($rootScope, $localStorage, $state, $location, Data, $cookies) {
        $rootScope.$on('$stateChangeStart', checkAccess);

        function checkAccess(event, toState, toParams, fromState, fromParams) {
		return true;
        }

    }


    function configLocationProvider ($locationProvider) {
        $locationProvider.html5Mode(false);
    }

    function configTranslateProvider ($translateProvider) {
        $translateProvider
            .useStaticFilesLoader({
                prefix: 'assets/i18n/',
                suffix: '.js'
            })
            // Register a loader for the static files
            // So, the module will search missing translation tables under the specified urls.
            // Those urls are [prefix][langKey][suffix].
            .registerAvailableLanguageKeys(['pt_BR','en','es'], {
                    //'en': 'en',
                    'pt_BR': 'pt_BR',
                    '*': 'pt_BR'
                }
            )
            .useSanitizeValueStrategy('escape')
            .preferredLanguage('pt_BR')
            .useLocalStorage();
    }

    function configRouteProvider ($urlRouterProvider) {
        // Se URL submetida não for nenhuma rota configurada
        $urlRouterProvider.otherwise(function($injector) {
            var $state = $injector.get('$state');
            $state.go('app.dashBoard');
        });
    }

    function configStateProvider ($stateProvider) {
        $stateProvider
            .state('app', {
                abstract: true,
                templateUrl: 'app/shared/view/template/app.php'
        });
    }
})();
