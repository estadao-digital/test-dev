(function() {
    'use strict';

    angular.module('app')
        .config(ACL);

    ACL.$inject = ['$stateProvider'];

    /**
     * Este arquivo faz parte do pacote aker-angularjs.
     *
     * @author Marcos Vieira Ribeiro <marcos.ribeiro@aker.com.br>
     * @name            User
     * @description     Module config
     */
    function ACL($stateProvider) {
        $stateProvider
            .state('app.profileEdit', {
                url: '/profile-register/{id:int}',
                templateUrl: 'app/components/ACL/view/profile-register.html',
                controller: 'ProfileRegisterCtrl as vm'
            })
            .state('app.profileRegister', {
                url: '/profile-register/',
                templateUrl: 'app/components/ACL/view/profile-register.html',
                controller: 'ProfileRegisterCtrl as vm'
            })
            .state('app.profileList', {
                url: '/profile-list/',
                templateUrl: 'app/components/ACL/view/profile-list.html',
                controller: 'ProfileListCtrl as vm'
            })
            .state('app.functionalityRegister', {
                url: '/functionality/register/',
                templateUrl: 'app/components/ACL/view/functionality-register.html',
                controller: 'FunctionalityRegisterCtrl'
            });
    }
})();
