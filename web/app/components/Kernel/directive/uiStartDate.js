(function() {
    'use strict';

    angular.module('app')
        .directive('uiStartDate', UiStartDate);

    /**
     * Diretiva para criação de um campo de data inicial utilizando bootstrap e angular datetimepicker.
     * Utilizar junto com a diretiva uiEndDate.
     *
     * @param dateModel Variável para receber o valor das datas de início e fim
     * @param label Título do label do campo
     *
     * Utilização: <div ui-start-date label="Titulo do campo" date-model="variavel.datas"></div>
     */
    function UiStartDate () {
        return {
            restrict: 'A',
            scope: {
                dates: "=dateModel"
            },
            templateUrl: 'app/components/Kernel/directive/templates/uiStartDate.html',
            link: uiStartDateLink
        };
    }

    function uiStartDateLink (scope, element, attrs) {
        if(attrs.label){
            scope.label = attrs.label;
        }

        // Checa se o objeto está vazio antes de atribuir valores
        if(!scope.dates){
            scope.dates = {};
        }

        // Função para disparar um evento informando que a data inicial foi mudada
        scope.startDateOnSetTime = function(){
            scope.$parent.$broadcast('start-date-changed');
        };

        // Filtra as datas do array de datas iniciais para mostrar apenas as datas menores que a data final
        scope.startDateBeforeRender = function ($dates) {
            if (scope.dates.endDate) {
                var activeDate = moment(scope.dates.endDate);

                $dates.filter(function (date) {
                    return date.localDateValue() >= activeDate.valueOf();
                }).forEach(function (date) {
                    date.selectable = false;
                });
            }
        }
    }

})();