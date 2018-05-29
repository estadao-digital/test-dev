(function() {
    'use strict';

    angular.module('app')
        .directive('uiEndDate', UiEndDate);

    /**
     * Diretiva para criação de um campo de data final utilizando bootstrap e angular datetimepicker.
     * Utilizar junto com a diretiva uiStartDate.
     *
     * @param dateModel Variável para receber o valor das datas de início e fim
     * @param label Título do label do campo
     *
     * Utilização: <div ui-end-date label="Titulo do campo" date-model="variavel.datas"></div>
     */
    function UiEndDate () {
        return {
            restrict: 'A',
            scope: {
                dates: "=dateModel"
            },
            templateUrl: 'app/components/Kernel/directive/templates/uiEndDate.html',
            link: uiEndDateLink
        };
    }

    function uiEndDateLink (scope, element, attrs) {
        if(attrs.label){
            scope.label = attrs.label;
        }

        // Checa se o objeto está vazio antes de atribuir valores
        if(!scope.dates){
            scope.dates = {};
        }

        // Função para disparar um evento informando que a data final foi mudada
        scope.endDateOnSetTime = function(){
            scope.$parent.$broadcast('end-date-changed');
        };

        // Filtra as datas do array de datas finais para mostrar apenas as maiores que a data inicial
        scope.endDateBeforeRender = function($view, $dates) {
            if (scope.dates.startDate) {
                var activeDate = moment(scope.dates.startDate).subtract(1, $view).add(1, 'minute');

                $dates.filter(function (date) {
                    return date.localDateValue() <= activeDate.valueOf();
                }).forEach(function (date) {
                    date.selectable = false;
                });
            }
        }
    }

})();