/**
 * Diretiva para montar o sparkline utilizando o angular.
 *
 * @category  Directive
 * @package   Front-end
 * @author    Rodrigo Pereira de Souza Silva <rodrigo.souza@aker.com.br>
 * @copyright 2015 Aker Security Solutions
 * @license   www.aker.com.br Proprietary
 * @link      www.aker.com.br
 */
(function() {
    'use strict';

    angular.module('app')
    .directive('sparklinechart', sparklinechart);

    function sparklinechart() {
        return {
            restrict: 'E',
            scope: {
                data: '@'
            },
            compile: function (tElement, tAttrs, transclude) {
                tElement.replaceWith('<span>' + tAttrs.data + '</span>');
                return function (scope, element, attrs) {
                    attrs.$observe('data', function (newValue) {
                        element.html(newValue);
                        element.sparkline('html', { minValue: tAttrs.minValue, maxValue: tAttrs.maxValue, type: tAttrs.type, width: tAttrs.width, height: tAttrs.height, barWidth: 11, barColor: 'blue', lineColor: '#23B7E5', fillColor: '#E8F7FC' });
                    });
                };
            }
        };
    };

})();
