(function() {
    'use strict';

    angular.module('app')
        .factory('bytesConverter', bytesConverter);

    function bytesConverter() {

        var obj = {};

        obj.convert = function (bytes) {
            if(bytes === 0) {
                return '0 Bytes';
            }

            var decimals = 2;
            var k = 1000;
            var dm = decimals + 1 || 3;
            var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
            var i = Math.floor(Math.log(bytes) / Math.log(k));
            return (bytes / Math.pow(k, i)).toPrecision(dm) + ' ' + sizes[i];
        };

        return obj;
    }

})();
