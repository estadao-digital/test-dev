(function() {
    'use strict';

  angular.module('app')
    .directive('onFinishRender', onFinishRender);

    onFinishRender.$inject = ['$timeout'];

    function onFinishRender($timeout) {
      return {
        restrict: 'A',
        link: function (scope, element, attr) {
          if (scope.$last === true) {
            $timeout(function () {
                scope.$emit('ngRepeatFinished');
            });
          }
        }
      }
    }

})();
