(function() {
    'use strict';

    angular.module('app')
        .factory('ngTableHelper', ngTableHelper);

    ngTableHelper.$inject = ['Data', 'NgTableParams', 'toaster'];

    function ngTableHelper(Data, NgTableParams, toaster) {

        var obj = {};

        obj.buildTable = function (url, index, filter) {
            return new NgTableParams({
                page: 1,
                count: 10
            }, {
                total: 0,
                getData: function ($defer, params) {

                    var parameters = obj.mountPostParams(params.url(), filter);

                    Data.post(url, parameters).then(function (results) {
                        if (!results.error) {
                            params.total(results.pagination.total);
                            $defer.resolve(results[index]);

                            params.firstIndex = results.pagination.firstIndex;
                            params.lastIndex = results.pagination.lastIndex;
                        }
                    }, function(error) {
                        params.total(0);
                        $defer.resolve([]);
                        params.firstIndex = 0;
                        params.lastIndex = 0;
                        if (error.mongoTimeout) {
                            toaster.pop('info', '', error.message, 0);
                        } else {
                            toaster.pop('error', '', error.message, 5000);
                        }
                    });
                }
            });
        };

        obj.mountPostParams = function (params, filter) {

            filter.pagination = {};
            angular.forEach(params, function (value, key) {

                if (key === 'page') {
                    filter.pagination.currentPage = value;
                } else if (key === 'count') {
                    filter.pagination.maxPerPage = value;
                } else if (key.match(/sorting.*/)) {
                    filter.pagination.orderBy = key.replace(/sorting\[/g, '').replace(']', '');
                    filter.pagination.criteria = value;
                }


            });
            return filter;

        };

        return obj;
    }
})();
