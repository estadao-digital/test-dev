let  CarroService = {

    getCarros: (callback) => {
        $.ajax({
            url: 'http://localhost:8000/api/carros',
            dataType: 'json',
            success: (response) => {
                callback(response);
            },
            type: 'get',
        });
    },

    getCarro: (id, callback) => {
        $.ajax({
            url: 'http://localhost:8000/api/carros/' + id,
            dataType: 'json',
            success: response => callback(response),
            type: 'get',
        });
    },

    update: (id, data, callback) => {
        $.ajax({
            url: 'http://localhost:8000/api/carros/' + id,
            data: data,
            dataType: 'json',
            success: response => callback(response),
            type: 'put',
        });
    },

    delete: (id, callback) => {
        $.ajax({
            url: 'http://localhost:8000/api/carros/' + id,
            dataType: 'json',
            success: (response) => callback(response),
            type: 'delete',
        });
    },

    create: (data, callback) => {
        $.ajax({
            url: 'http://localhost:8000/api/carros',
            dataType: 'json',
            type: 'post',
            data: data,
            success: (response) => callback(response),
        });
    },

}