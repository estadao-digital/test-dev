(function() {
    'use strict';

    angular.module('app')
        .controller('AppCtrl', AppCtrl);

    AppCtrl.$inject = ['$scope', '$translate', '$localStorage', '$window'];

    function AppCtrl($scope, $translate, $localStorage, $window) {
        // add 'ie' classes to html
        var isIE = !!navigator.userAgent.match(/MSIE/i);
        isIE && angular.element($window.document.body).addClass('ie');
        isSmartDevice($window) && angular.element($window.document.body).addClass('smart');

        // config
        $scope.app = {
            name: 'Aker',
            fullName: 'Aker Web Defender',
            // for chart colors
            color: {
                primary: '#7266ba',
                info: '#23b7e5',
                success: '#27c24c',
                warning: '#fad733',
                danger: '#f05050',
                light: '#e8eff0',
                dark: '#3a3f51',
                black: '#1c2b36',
                predanger: '#ffa500'
            },
            settings: {
                themeID: 7,
                navbarHeaderColor: 'bg-black',
                navbarCollapseColor: 'bg-white',
                asideColor: 'bg-black b-r',
                headerFixed: true,
                asideFixed: true,
                asideFolded: false,
                asideDock: false,
                container: false,
                lang: 'en',
                routes: {},
                version: ''
            }
        };

        // save settings to local storage
        if (angular.isDefined($localStorage.settings)) {
            $scope.app.settings = $localStorage.settings;
        } else {
            $localStorage.settings = $scope.app.settings;
        }
        $scope.$watch('app.settings', function () {
            if ($scope.app.settings.asideDock && $scope.app.settings.asideFixed) {
                // aside dock and fixed must set the header fixed.
                $scope.app.settings.headerFixed = true;
            }
            // for box layout, add background image
            $scope.app.settings.container ? angular.element('html').addClass('bg') : angular.element('html').removeClass('bg');
            // save to local storage
            $localStorage.settings = $scope.app.settings;
        }, true);

        // angular translate
        $scope.lang = {isopen: false};
        $scope.langs = {en: 'en-US', pt_BR: 'pt-BR',es:'es'};
        $scope.selectLang = $scope.langs[$translate.proposedLanguage()] || "en-US";
        $scope.setLang = function (langKey, $event) {

            // set the current lang
            $scope.selectLang = $scope.langs[langKey];
            // You can change the language during runtime
            $translate.use(langKey);
            $scope.lang.isopen = !$scope.lang.isopen;
            //setto o idioma no local storage
            $localStorage.settings.lang = langKey;
            if ($scope.langs[langKey] == 'en-US') {
                $scope.langs[langKey] = 'en';
            }
            $window.location.href = 'https://' + $window.location.host + '/change-lang/' + $scope.langs[langKey];
        };

        function isSmartDevice($window)
        {
            // Adapted from http://www.detectmobilebrowsers.com
            var ua = $window['navigator']['userAgent'] || $window['navigator']['vendor'] || $window['opera'];
            // Checks for iOs, Android, Blackberry, Opera Mini, and Windows mobile devices
            return (/iPhone|iPod|iPad|Silk|Android|BlackBerry|Opera Mini|IEMobile/).test(ua);
        }
    }

})();
