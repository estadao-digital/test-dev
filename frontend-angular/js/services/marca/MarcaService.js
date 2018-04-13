/**
 * Created by smith
 */
angular.module("CarrosApp").factory("marcasAPI", function ($http, config) {
    var _getMarcas = function () {
        return $http.get(config.baseUrl + "/marcas");
    };
    var _getMarca = function (id) {
        return $http.get(config.baseUrl + "/marcas/" + id);
    };
    var _saveMarca = function (marca) {
        return $http.post(config.baseUrl + "/marcas", marca);
    };

    var _editMarca = function (marca) {
        return $http.put(config.baseUrl + "/marcas/"+marca.id, marca);
    };
    var _deleteMarca = function (marca) {
        return $http.delete(config.baseUrl + "/marcas/"+marca.id);
    };
    return {
        getMarcas: _getMarcas,
        getMarca: _getMarca,
        editMarca: _editMarca,
        saveMarca: _saveMarca,
        deleteMarca: _deleteMarca,
    };
});