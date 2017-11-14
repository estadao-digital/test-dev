var MarcasController = function () {

    var Marcas = new Model('marcas');

    var listarSelect = function (select)
    {
        var params = {};

        Marcas.fetch(params,
            function (data) {

                var template = $('#template-select-marcas').html();

                Mustache.parse(template);   // optional, speeds up future use

                var dados = {
                    marcas: data
                };

                var rendered = Mustache.render(template, dados);

                $('.select-marcas').html(rendered);

                getmdlSelect.init(".getmdl-select");

            },
            function () {
                console.log('Nenhum carro encontrado');
            }
        );
    };

    return {
        listarSelect: listarSelect
    };
};
