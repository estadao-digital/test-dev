/**
 * Created by smith
 */
angular.module("CarrosApp").factory("carrosAPI", function ($http, config) {
    var _getCarros = function (query) {
        var ordem = query.order.split('-');
        if(ordem.length>1)
        {
            query.order = ordem[1]+',desc';
        }else
        {
            query.order = ordem[0];
        }
        return $http.get(config.baseUrl + "/carros?limit="+query.limit
            +"&order="+query.order
            +"&page="+query.page);
    };
    var _getCarro = function (id) {
        return $http.get(config.baseUrl + "/carros/" + id);
    };
    var _saveCarro = function (carro) {
        return $http.post(config.baseUrl + "/carros", carro);
    };

    var _editCarro = function (carro) {
        return $http.put(config.baseUrl + "/carros/"+carro.id, carro);
    };
    var _deleteCarro = function (carro) {
        return $http.delete(config.baseUrl + "/carros/"+carro.id);
    };
    return {
        getCarros: _getCarros,
        getCarro: _getCarro,
        editCarro: _editCarro,
        saveCarro: _saveCarro,
        deleteCarro: _deleteCarro,
    };
});