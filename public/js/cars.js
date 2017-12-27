var cars = (function() {
    var obj = {};
    var api = '/api/carros/';

    obj.error = function (Message, Title) {
        $("#modal-alert").iziModal('destroy');
        $("#modal-alert").iziModal({
            title: Title,
            subtitle: Message,
            icon: 'icon-power_settings_new',
            headerColor:  '#F33f3',
            width: 600,
            timeout: 5000,
            timeoutProgressbar: true,
            transitionIn: 'fadeInDown',
            transitionOut: 'fadeOutDown',
            pauseOnHover: true
        });
        $("#modal-alert").iziModal('open');
    };


    obj.alertSuccess = function (Message, Title) {
        $("#modal-alert").iziModal('destroy');
        $("#modal-alert").iziModal({
            title: Title,
            subtitle: Message,
            icon: 'icon-check',
            headerColor:  '#00af66',
            width: 600,
            timeout: 5000,
            timeoutProgressbar: true,
            transitionIn: 'fadeInDown',
            transitionOut: 'fadeOutDown',
            pauseOnHover: true
        });
        $("#modal-alert").iziModal('open');
    };

    obj.cadastro = function () {

        $("#modal-cadastro").iziModal({
            title: "Cadastro de veículos",
            icon: 'icon-check',
            headerColor: '#00af66',
            width: 600,
            transitionIn: 'fadeInUp',
            transitionOut: 'fadeOutDown',
        });

        $('.modal-cadastro').on('click', function () {
            $('.modal-cadastrar input').val("");
            $("#modal-cadastro").iziModal('open');
        });

    };


    obj.edit = function () {

        $("#modal-editar").iziModal({
            title: "Alterar veículo",
            icon: 'icon-check',
            headerColor: '#00af66',
            width: 600,
            transitionIn: 'fadeInUp',
            transitionOut: 'fadeOutDown',
        });

        $(document).on('opening', '#modal-editar', function (e) {

            $.ajax({
                method:'GET',
                url: api + $(this).attr('data-id'),
                dataType: 'json',
                success: function(r) {
                    var response = r.content;
                    if(response){
                        $('.modal-alterar #marca').val(response.marca);
                        $('.modal-alterar #modelo').val(response.modelo);
                        $('.modal-alterar #ano').val(response.ano);
                    }

                },
                error: function(r) {
                    obj.error('Oops, ocorreu um problema.', 'Desculpe, estamos trabalhando para resolver, tente novamente mais tarde.');
                }
            });


        });

        $(document).on('click', '.edit', function () {
            $("#modal-editar").attr('data-id', $(this).attr('data-id'));
            $('.modal-alterar input').val("");
            $("#modal-editar").iziModal('open');
        });

    };



    obj.list = function () {
        var html = '';

        $.ajax({
            method:'GET',
            url: api,
            dataType: 'json',
            success: function(r) {
                var response = r.content;
                for(i in response){
                    html += '<li class="carros-item">';
                    html += '<div class="thumb"></div>';
                    html += '<span class="carros-modelo">';
                    html += response[i].modelo;
                    html += '</span>';
                    html += '<span class="carros-marca grid-only">';
                    html += response[i].marca;
                    html += '</span>';
                    html += ' <span class="carros-ano grid-only block">';
                    html += response[i].ano;
                    html += '</span>';
                    html += '<div class="pull-right">';
                    html += '<span class="carros-stage stage" id="dropdownOptions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    html += '<i class="fa fa-cog" aria-hidden="true"></i>';
                    html += '</span>';
                    html += '<div class="dropdown-menu" aria-labelledby="dropdownOptions">';
                    html += '<a class="dropdown-item edit" href="#" data-id="' + response[i].id + '">Editar</a>';
                    html += '<a class="dropdown-item delete" href="#" data-id="' + response[i].id + '">Deletar</a>';

                    html += '</div></span>';
                    html += '</div>';
                    html += '</li>';
                }

                $('ul.carros').html(html);

            },
            error: function(r) {
                obj.error('Oops, ocorreu um problema.', 'Desculpe, estamos trabalhando para resolver, tente novamente mais tarde.');
            }
        });
    };

    obj.signup = function () {
        $(document).on('click', '#modal-cadastro .btn', function (e) {
            e.preventDefault();
            var $this = $(this);
            $.ajax({
                method:'POST',
                url: api,
                data: $('.modal-cadastrar').serialize(),
                dataType: 'json',
                success: function(r) {
                    if(r.content){
                        obj.list();
                        obj.alertSuccess('Sucesso!', r.message);
                    }
                },
                error: function(r) {
                    obj.error('Oops, ocorreu um problema.', 'Desculpe, estamos trabalhando para resolver, tente novamente mais tarde.');
                }
            });
        });

    };

    obj.update = function () {
        $(document).on('click', '#modal-editar .btn', function (e) {
            e.preventDefault();
            var $this = $(this);
            $.ajax({
                method:'PUT',
                url: api + $('#modal-editar').attr('data-id'),
                data: $('.modal-alterar').serialize(),
                dataType: 'json',
                success: function(r) {
                    if(r.content){
                        obj.list();
                        obj.alertSuccess('Sucesso!', r.message);
                    }
                },
                error: function(r) {
                    obj.error('Oops, ocorreu um problema.', 'Desculpe, estamos trabalhando para resolver, tente novamente mais tarde.');
                }
            });
        });

    };


    obj.delete = function () {
        $(document).on('click', '.delete', function () {
           var $this = $(this);
            $.ajax({
                method:'DELETE',
                url: api  + $this.attr('data-id'),
                dataType: 'json',
                success: function(r) {
                    if(r.content){
                        $this.closest('li').remove();
                        obj.alertSuccess('Sucesso.', 'Carro excluído com sucesso!');
                    }else{
                        obj.error('Oops, ocorreu um problema.', 'Desculpe, estamos trabalhando para resolver, tente novamente mais tarde.');
                    }
                },
                error: function(r) {
                    obj.error('Oops, ocorreu um problema.', 'Desculpe, estamos trabalhando para resolver, tente novamente mais tarde.');
                }
            });
        });

    };

    obj.info = function () {
        $(document).on('click', '.info', function () {
            $("#info").iziModal({
                title: "Informações",
                icon: 'icon-check',
                headerColor: '#6f8ba8',
                width: 600,
                transitionIn: 'fadeInUp',
                transitionOut: 'fadeOutDown',
            });
            $("#info").iziModal('open');

        });

    };

    return {
        init: function() {
           obj.list();
           obj.cadastro();
           obj.delete();
           obj.signup();
           obj.edit();
           obj.update();
           obj.info();

        }
    }
})();

$(function() {
    cars.init();
});	