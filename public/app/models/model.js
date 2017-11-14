jQuery.support.cors = true;

var Model = function (resource) {

    /* Production *//*
	var protocol = "https";
    var host = "carrosaz.herokuapp.com";
    var port = "443";
    var version = "1";
	/**/
	
	/* Local */
	var protocol = "http";
    var host = "localhost";
    var port = "8080";
    var version = "1"; 
	/**/

    var api_location = protocol + '://' + host + ':' + port + '/v' + version + '/';

    var fetch = function (params, callbackSuccess, callbackError)
    {
        var route = resource;

        if (params && typeof params == 'object') {
            if (params.id) {
                route += "/" + params.id;
            } else if (params.filters != 'undefined' && typeof params.filters == 'string'){
                route += "?" + params.filters;
            }
        }

        $.ajax({
            url: api_location + route,
            type: 'GET',
            dataType: 'json',
            success: callbackSuccess,
            error: callbackError
        });
    };

    var create = function (params, callbackSuccess, callbackError)
    {
        var route = resource;
        var data = "";

        if (params && typeof params == 'object') {
            if (params.data && typeof params.data == 'object') {
                data = params.data;
            } else {
                throw new Error('Unexpected type of data\nInvalid data passed: \n' + params.data);
            }
        }

        $.ajax({
            url: api_location + route,
            type: 'POST',
            dataType: 'json',
            data: data,
            success: callbackSuccess,
            error: callbackError
        });
    };

    var update = function (params, callbackSuccess, callbackError)
    {
        var route = resource;
        var data = "";

        if (params && typeof params == 'object') {
            if (params.id) {
                route += "/" + params.id;

                if (params.data && typeof params.data == 'object') {
                    data = params.data
                } else {
                    throw new Error('Unexpected type of data\nInvalid data passed: \n' + params.data);
                }
            } else {
                throw new Error('Unexpected type of data\nInvalid id passed: \n' + params.id);
            }
        }

        $.ajax({
            url: api_location + route,
            type: 'PUT',
            dataType: 'json',
            data: data,
            success: callbackSuccess,
            error: callbackError
        });
    };

    var remove = function (params, callbackSuccess, callbackError)
    {
        var route = resource;

        if (params && typeof params == 'object') {
            if (params.id) {
                route += "/" + params.id;
            } else {
                throw new Error('Unexpected type of data\nInvalid id passed: \n' + params.id);
            }
        }

        $.ajax({
            url: api_location + route,
            type: 'DELETE',
            dataType: 'json',
            success: callbackSuccess,
            error: callbackError
        });
    };


    return {
        fetch: fetch,
        create: create,
        update: update,
        remove: remove,
    };
};