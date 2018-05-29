(function() {
    'use strict';

    angular.module('app')
        .factory('progressBar', progressBar);

    function progressBar() {

        var obj = {};

        // Esse metodo recebe o valor e o valor maximo para calcular a portencagem.
        //jshint maxcomplexity:6
        obj.changeColor = function changeColor(value, max) {
            
            var percent = value*100/max;

            if (percent <= 25) {
                return 'info';
            }

            if (percent <= 50) {
                return 'success';
            }

            if (percent <= 70) {
                return 'warning';
            }

            if (percent <= 85) {
                return 'predanger';
            }
            
            return 'danger';

        }; 

        return obj;
    }

})();