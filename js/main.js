$(document).ready(function () {
    // Ver a lista de carros cadastrados
    $.ajax ({
        type: 'GET',
        url: window.location.href + '/carros',
        dataType: 'json',
        data: {},
        beforeSend: function() {
        },
        success: function (result) {
            conteudo = "";
            for(i = 0; i < result.length;i++) {
                conteudo += "<tr data-id='"+result[i].id+"'>" +
                    "<td>"+result[i].id+"</td>" +
                    "<td>"+result[i].modelo+"</td>" +
                    "<td>"+result[i].marca+"</td>" +
                    "<td>"+result[i].ano+"</td>" +
                    "<td><i class='fas fa-edit'></i><i class='fas fa-trash'></i></td>" +
                    "</tr>";
            }
            $('main table tbody').append(conteudo);

            // Selecionar um carro para editar
            $('.fa-edit').on('click', function () {
                $('.delete').removeClass('active');
                id = $(this).closest('tr').attr('data-id');
                $.ajax ({
                    type: 'GET',
                    url: window.location.href + '/carros/' + id,
                    dataType: 'json',
                    data: {},
                    beforeSend: function() {
                        $('main table').css('animation-name', 'opacity');
                    },
                    success: function (result) {
                        $('main table').css('animation-name', '');
                        openModal('form');
                        $('.form h3').html('Editar Carro');
                        $('.form form').attr('data-id', result.id);
                        $('.form form input[name="modelo"]').val(result.modelo);
                        $('.form form select[name="marca"]').val(result.marca);
                        $('.form form input[name="ano"]').val(result.ano);
                    },
                    error: function (result) {
                        console.log('erro');
                        console.log(result);
                    }
                });
            });

            // Selecionar um carro para excluir
            $('.fa-trash').on('click', function () {
                if($('.form').hasClass('active')) {
                    $('.form').removeClass('active');
                }
                openModal('delete');

                id = $(this).closest('tr').attr('data-id');
                $('.delete .id').html(id);
                $('.delete button').attr('data-id', id);
            });
        },
        error: function (result) {
            console.log('erro');
            console.log(result);
        }
    });

    $('.delete button').on('click', function () {
        id = $(this).attr('data-id');

        // Apagar um carro existente
        $.ajax ({
            type: 'DELETE',
            url: window.location.href + '/carros/' + id,
            dataType: 'json',
            data: {},
            beforeSend: function() {
            },
            success: function (result) {
                $('main table tr[data-id="'+id+'"]').remove();

                closeModal();
            },
            error: function (result) {
                console.log('erro');
                console.log(result);
            }
        });
    });

    $('#adicionar').on('click', function () {
        if($('.form').hasClass('active')) {
            if($('.form form').attr('data-id') == undefined) {
                limparForm();
                closeModal();
            } else {
                limparForm();
            }
        } else {
            if($('.delete').hasClass('active')) {
                $('.delete').removeClass('active');
            }
            openModal('form');
        }
    });

    $('.fa-angle-right').on('click', function () {

        limparForm();
        closeModal();
    });

    $('.form form').on('submit', function (e) {
        e.preventDefault();

        modelo = $(this).find('input[name="modelo"]').val();
        marca = $(this).find('select[name="marca"]').val();
        ano = $(this).find('input[name="ano"]').val();

        if($('.form form').attr('data-id') == undefined) {
            // Criar um novo carro
            $.ajax ({
                type: 'POST',
                url: window.location.href + '/carros',
                dataType: 'json',
                data: {modelo: modelo, marca: marca, ano: ano},
                beforeSend: function() {
                },
                success: function (result) {
                    console.log('sucesso');
                    console.log(result);
                    conteudo = "";
                    conteudo += "<tr data-id='"+result.id+"'>" +
                        "<td>"+result.id+"</td>" +
                        "<td>"+modelo+"</td>" +
                        "<td>"+marca+"</td>" +
                        "<td>"+ano+"</td>" +
                        "<td><i class='fas fa-edit'></i><i class='fas fa-trash'></i></td>" +
                        "</tr>";
                    $('main table tbody').append(conteudo);
                    for(i = 0; i < $('.form form input').length; i++) {
                        $('.form form input:eq('+i+')').val('');
                    }

                    $('.fa-edit').on('click', function () {
                        $('.delete').removeClass('active');
                        id = $(this).closest('tr').attr('data-id');
                        $.ajax ({
                            type: 'GET',
                            url: window.location.href + '/carros/' + id,
                            dataType: 'json',
                            data: {},
                            beforeSend: function() {
                            },
                            success: function (result) {
                                openModal('form');
                                $('.form h3').html('Editar Carro');
                                $('.form form').attr('data-id', result.id);
                                $('.form form input[name="modelo"]').val(result.modelo);
                                $('.form form input[name="marca"]').val(result.marca);
                                $('.form form input[name="ano"]').val(result.ano);
                            },
                            error: function (result) {
                                console.log('erro');
                                console.log(result);
                            }
                        });
                    });

                    $('.fa-trash').on('click', function () {
                        if($('.form').hasClass('active')) {
                            $('.form').removeClass('active');
                        }
                        openModal('delete');

                        id = $(this).closest('tr').attr('data-id');
                        $('.delete .id').html(id);
                        $('.delete button').attr('data-id', id);
                    });

                    if(window.innerWidth < 768) {
                        closeModal();
                    }
                },
                error: function (result) {
                    console.log('erro');
                    console.log(result);
                }
            });
        } else {
            // Editar um carro existente
            id = $('.form form').attr('data-id');
            $.ajax ({
                type: 'PUT',
                url: window.location.href + '/carros/' + id,
                dataType: 'json',
                data: {modelo: modelo, marca: marca, ano: ano},
                beforeSend: function() {
                },
                success: function (result) {
                    $('main table tr[data-id="'+id+'"] td:eq(1)').html(modelo);
                    $('main table tr[data-id="'+id+'"] td:eq(2)').html(marca);
                    $('main table tr[data-id="'+id+'"] td:eq(3)').html(ano);

                    limparForm();
                    closeModal();
                },
                error: function (result) {
                    console.log('erro');
                    console.log(result);
                }
            });
        }
    });
});

function limparForm() {
    for(i = 0; i < $('.form form input').length; i++) {
        $('.form form input:eq(' + i + ')').val('');
    }
}

function closeModal() {
    $('.form').removeClass('active');
    $('main').css('left', '');
    $('.modals').css('left', '');
    $('.form h3').html('Adicionar Carro');
}
function openModal(modal) {
    $('.' + modal).addClass('active');
    value = 50;
    if(window.innerWidth < 768) {
        value = 100;
        console.log(value);
    }
    $('main').css('left', '-'+value+'%');
    $('.modals').css('left', (100 - value) +'%');
    $('.form h3').html('Adicionar Carro');
}