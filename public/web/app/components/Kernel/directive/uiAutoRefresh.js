(function() {
    'use strict';

    angular.module('app').directive('uiAutoRefresh', UiAutoRefresh);

    UiAutoRefresh.$inject = ['$timeout', '$q'];

    /**
     * Diretiva para realizar atualização automática de componentes
     *
     * @author Italo Paiva <italo.batista@aker.com.br>
     * @param beforeRefresh function() - Função a ser executada antes da atualização 
     * @param refresh function() - Função a ser executada para realizar a atualização 
     * @param afterRefresh function() - Função a ser executada após realizar a atualização 
     * @param stopRefresh {expression} - Expressão que representa a condição de parada da atualização 
     * @param refreshInterval number - Tempo do intervalo da atualização, em segundos 
     *
     * Utilização: <div ui-auto-refresh before-refresh="fn()" refresh="fn()"
     *                  refresh-interval="10" stop-refresh="false">
     */
    function UiAutoRefresh ($timeout, $q) {
        return {
            restrict: 'A',
            scope: {
                beforeRefresh: "&",
                refresh: "&",
                afterRefresh: "&",
                stopRefresh: "=",
                refreshInterval: "@"
            },
            link: function (scope) {
                // Turning interval to milliseconds
                var interval = scope.refreshInterval * 1000;
                
                scope.currentTask = $timeout(refreshFn, interval);

                scope.$watch('stopRefresh', function(toDisable, toActivate){
                    if(!toDisable && toActivate){
                        scope.currentTask = $timeout(refreshFn, interval);
                    }
                    if(!toActivate && toDisable){
                        $timeout.cancel(scope.currentTask);
                    }
                });

                function refreshFn(){
                    var afterRefresh = defer(function(done){done();});
                    var beforeRefresh = defer(function(done){done();});

                    if(scope.beforeRefresh()){
                        beforeRefresh = defer(scope.beforeRefresh());
                    }

                    var refresh = defer(scope.refresh());
                    
                    if(scope.afterRefresh()){
                        afterRefresh = defer(scope.afterRefresh());
                    }

                    beforeRefresh.then(function(){
                        refresh.then(function(){
                            afterRefresh.then(function(){
                                if(!scope.stopRefresh){
                                    scope.currentTask = $timeout(refreshFn, interval);                
                                }
                            });
                        });
                    });
                }

                /** 
                 * Decorator to create a promise of a function and 
                 * resolve it only when a callback is called
                 *
                 * @author Italo Paiva <italo.batista@aker.com.br>
                 * @param fn {function} - Function to be 'promised'
                 *
                 * @return promise
                 */
                function defer(fn){

                    var deferred = $q.defer();

                    fn(function (){
                        deferred.resolve();
                    });

                    return deferred.promise;
                }
            }
        };
    }

})();