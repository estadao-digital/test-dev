jQuery(function ($) {
    APP = window.APP || {};


    APP.Content = function () {
        $('.to-content').click(function (event) {
            try {
                var url = $(this).attr('data-href').split('?')[0];
                var datainputs = $(this).attr('data-href').split('?')[1];
                var type = 'get';
                APP.getContent(url, datainputs, type);
            } catch (err) {
                console.log(err);
                return;
            }
        });
    }
    APP.Home = function () {
        try {
            var url = "/listar"
            var datainputs = "";
            var type = 'get';
            APP.getContent(url, datainputs, type);
        } catch (err) {
            console.error(err);
            return;
        }
    }

    APP.getContent = function (url, datainputs, type) {
        $('.blockpage').removeClass('hidden');
        APP.xhr = $.ajax({
            type: type,
            url: url,
            data: datainputs,
            dataType: 'text',
            success: function (retornar) {
                $('.blockpage').addClass('hidden');
                $('#content').html(retornar);
                APP.load();
            },
            error: function (retornar) {
                $('.blockpage').addClass('hidden');
                console.error(retornar);
                swal('Erro!', 'Erro ao conectar com servidor!', 'error');
            }
        });
    };

    APP.salvar = function () {
        $('.form').submit(function (event) {
            event.preventDefault();
            var $form = $(this);
            var url = $form.attr('action');
            var type = $form.attr('method');
            var datainputs = APP.getFormData($form);
            APP.ajaxProcess(url, datainputs, type);
        });
    };
    
    APP.remover = function () {
        $('.remove').click(function (event) {
            event.preventDefault();
            var $elemente = $(this);            
            var url = $elemente.attr('data-href');
            console.log(url);
            var type = "DELETE";
            var datainputs = "";
            swal({
                    title: 'Exluir Carro?',
                    text: "Esta certo que deseja exluir este carro?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Não, cancelar!'
                }).then(function (result) {
                    if (result) {
                        $elemente.closest('tr').remove();
                        APP.ajaxProcess(url, datainputs, type);
                        APP.load();
                    }
                });        
            
        });
    };




    APP.ajaxProcess = function (url, datainputs, type) {
        $('.blockpage').removeClass('hidden');
        APP.xhr = $.ajax({
            type: type,
            url: url,
            data: datainputs,
            dataType: 'json',
            success: function (retornar) {
                $('.blockpage').addClass('hidden');
                console.log(retornar);
                swal.queue([{
                        title: retornar.status == 1 ? "Sucesso!" : "Erro!",
                        confirmButtonText: 'OK',
                        type: retornar.status == 1 ? 'success' : 'error',
                        text: retornar.message,
                        showLoaderOnConfirm: true,
                        preConfirm: function () {
                            swal.close();
                            if (retornar.status == 1) {
                                APP.Home();
                                APP.load();
                            }
                        }
                    }]);
            },
            error: function (retornar) {
                $('.blockpage').addClass('hidden');
                console.error(retornar);
                swal('Erro!', 'Erro ao conectar com servidor!', 'error');
            }
        });
    };

    APP.getFormData = function ($form) {
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function (n, i) {
            indexed_array[n['name']] = n['value'];
        });

        return indexed_array;
    }

    APP.load = function () {
        APP.Content();
        APP.salvar();
        APP.remover();
    };

    //main

    APP.init = (function () {
        $(window).load(function () {
            APP.Home();
        });
        APP.load();

    }());
});