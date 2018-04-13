/**
 * Created by smith
 */

'use strict';


angular.module('CarrosApp')
    .service('Restful', Restful);

Restful.$inject=['$http','config'];
function Restful($http,config) {
    var carroAdmin=this;

    var api=config.baseUrl+'/';

    // carroAdmin.getHeaders=function()
    // {
    //     return {
    //         'headers': {
    //             'Authorization': 'Bearer'+window.localStorage.getItem('token')
    //         }
    //     }
    // };

    carroAdmin.post=function(path, data) {
        return $http.post(api+path, data);
    };

    carroAdmin.put=function(path, data) {
        return $http.put(api+path, data);
    };

    carroAdmin.save=function(path, data) {
        if (typeof(data.id) == 'undefined') {
            return carroAdmin.post(path, data);
        }

        return carroAdmin.put(path+'/'+data.id, data);
    };

    carroAdmin.delete = function(path) {
        return $http.delete(api + path);
    };

    carroAdmin.login=function(path, data) {
        return $http.post(api+path, data);
    };

    carroAdmin.get=function(path)
    {
        return $http.get(api+path);
    };
}