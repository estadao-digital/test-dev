let MarcaService = {
    getMarcas: (callback) => {
        $.ajax({
            url: 'http://localhost:8000/api/marcas',
            dataType: 'json',
            success: (response) => {
                callback(response);
            },
            type: 'get',
        });
    },
}