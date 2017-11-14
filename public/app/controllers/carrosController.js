var CarrosController = function () {

    var Carros = new Model('carros');

    var dialog, confirmDialog;

    var form;
    var formTitle;
    var campoModelo;
    var campoAno;
    var campoIdMarca;

    var target;

    var deletar = function (id)
    {
        var params = {
            id: id
        };

        Carros.remove(params,
            function (data) {

                listarTodos();

                confirmDialog.close();

                console.log('Carro deletado com sucesso!');
            },
            function (data) {
                // console.log(data.responseJSON.message);
                console.log('Nenhum carro encontrado');
            }
        );
    };

    var listarTodos = function ()
    {
        Carros.fetch({},
            function (data) {

                var template = $('#template-carro-view').html();

                Mustache.parse(template);   // optional, speeds up future use

                var dados = {
                    carros: data
                };

                var rendered = Mustache.render(template, dados);

                $('.list-carros-view').html(rendered);

                console.log('Listando todos os carros!');
            },
            function () {
                console.log('Nenhum carro encontrado');
            }
        );
    };

    var salvar = function (id) {
        if (validarForm()) {
            var params = {};

            if (id) {
                var carro = new Carro(id, campoModelo.value, campoAno.value, campoIdMarca.dataset.val);

                params.id = id;
                params.data = carro;

                Carros.update(params,
                    function (data) {

                        listarTodos();

                        dialog.close();

                        console.log('Carro atualizado com sucesso!');
                    },
                    function () {
                        console.log('Nenhum carro encontrado');
                    }
                );
            } else {
                var carro = new Carro(null, campoModelo.value, campoAno.value, campoIdMarca.dataset.val);

                params.data = carro;

                Carros.create(params,
                    function (data) {
						
						console.log(data);

                        listarTodos();

                        dialog.close();

                        console.log('Carro cadastrado com sucesso!');
                    },
                    function () {
                        console.log('Nenhum carro encontrado');
                    }
                );
            }
        }
    };

    var validarForm = function () {
        // TODO
        return true;
    };

    var apagar = function (el) {
        target = el;

        confirmDialog.showModal();
    };

    var atualizar = function (el) {
        target = el;

        formTitle.textContent = "Atualizar Carro";

        var carroSelecionado = target.closest('.carro-view');

        campoModelo.value = carroSelecionado.querySelector('.carro-modelo').textContent;
        campoAno.value = carroSelecionado.querySelector('.carro-ano').textContent;
        campoIdMarca.value = carroSelecionado.querySelector('.carro-marca').textContent;
        campoIdMarca.dataset.val = carroSelecionado.querySelector('.carro-marca').dataset.idMarca;

        campoModelo.closest('.mdl-textfield').classList.add('is-dirty');
        campoAno.closest('.mdl-textfield').classList.add('is-dirty');
        campoIdMarca.closest('.mdl-textfield').classList.add('is-dirty');

        dialog.showModal();
    };

    var cadastrar = function () {
        formTitle.textContent = "Cadastrar Carro";

        dialog.showModal();
    };

    var bootForm = function () {
        form = dialog.querySelector('.form');
        formTitle = dialog.querySelector('.form-title');
        campoModelo = dialog.querySelector('.campo-modelo');
        campoAno = dialog.querySelector('.campo-ano');
        campoIdMarca = dialog.querySelector('.campo-marca');

        campoModelo.addEventListener("input", function (event) {
            if (campoModelo.validity.typeMismatch) {
                campoModelo.setCustomValidity("Informe um modelo válido");
            } else {
                campoModelo.setCustomValidity("");
            }
        });

        campoAno.addEventListener("input", function (event) {
            if (campoAno.validity.typeMismatch) {
                campoAno.setCustomValidity("Informe um ano válido");
            } else {
                campoAno.setCustomValidity("");
            }
        });
    };

    var bootDialogs = function () {
        dialog = document.querySelector('#dialog');
        confirmDialog = document.querySelector('#confirm-dialog');

        if (!dialog.showModal) {
            dialogPolyfill.registerDialog(dialog);
        }

        if (!confirmDialog.showModal) {
            dialogPolyfill.registerDialog(confirmDialog);
        }

        dialog.querySelector('.button-cancel')
        .addEventListener('click', function() {
            dialog.close();
            form.reset();
            target = null;
        });

        confirmDialog.querySelector('.button-cancel')
        .addEventListener('click', function() {
            confirmDialog.close();
        });

        dialog.querySelector('.button-save')
        .addEventListener('click', function() {
            if (target) {
                var id = target.closest('.carro-view').dataset.id;
                salvar(id);
                target = null;
                form.reset();
                return;
            }
            salvar();
            form.reset();
        });

        confirmDialog.querySelector('.button-save')
        .addEventListener('click', function() {
            if (target) {
                var id = target.closest('.carro-view').dataset.id;
                deletar(id);
                target = null;
                return;
            }
        });

        dialog.addEventListener('click', function (e) {
            if (e.target.classList.contains('mdl-dialog'))
            dialog.close();
        });

        confirmDialog.addEventListener('click', function (e) {
            if (e.target.classList.contains('mdl-dialog'))
            confirmDialog.close();
        });
    };

    var init = function () {
        bootDialogs();
        bootForm();
    };

    return {
        cadastrar: cadastrar,
        listarTodos: listarTodos,
        atualizar: atualizar,
        apagar: apagar,
        init: init
    };
};

