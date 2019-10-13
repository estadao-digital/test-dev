function prepareFormToCreate() {
    $(document).ready(function(){
        $('#marca').val(0);
        $('#modelo').val('');
        $('#ano').val('');
        $('#salvar').attr('data-product-id-change', 0);
        $('#salvar').text('Salvar Cadastro');
        $('.row-alteracao').html('');
    });
}

function prepareFormToEdit(produto) {
    $('#marca').val(produto.marca);
    $('#modelo').val(produto.modelo);
    $('#ano').val(produto.ano);
    $('#salvar').attr('data-product-id-change', produto.id);
    $('#salvar').text('Salvar Alteração');
    $('.row-alteracao').html(buildAlertAlterando());
}

function buildList(json_produtos) {
    produtos = JSON.parse(json_produtos);

    var list = '';
    for (var key in produtos) {
        produto = produtos[key];
        list += '<tr> ' +
            '<td>  ' +  produto.marca + ' </td> ' +
            '<td class="col-modelo"> '  + produto.modelo + '  </td> ' +
            '<td class="col-ano"> ' + produto.ano + '</td> ' +
            '<td class="text-center">' +
                '<a href="/carros/' + produto.id + '" class="editIcon"> <i class="fas fa-edit"></i> </a>' +
            '</td> ' +
            '<td class="text-center">' +
                '<a href="/carros/' + produto.id +'" data-toggle="modal" data-target="#excludeModal" class="deleteIcon"> <i class="fa fa-trash fa-2" aria-hidden="true"></i> </a>' +
            '</td></tr>';
    }

    return list;
}

function loadList() {
    $(document).ready(function(){
        $.ajax({
            type: 'GET',
            url: '/carros',
            success: function (json_produtos) {
                $('.content-list').html(buildList(json_produtos));
            }
        });
    });
}

function buildAlertSuccess(action) {
    return '<div class="col-12 alert alert-success alert-dismissible fade show" role="alert">' +
            '<strong>Sucesso! </strong> Carro ' + action + ' com sucesso.' +
        '</div>';
}

function showSuccess(action) {
    $(".alert").alert('close');
    $('.row-content').prepend(buildAlertSuccess(action));
    setTimeout(function(){
        $(".alert").alert('close');
    }, 2000);
}

function buildAlertError(objErrors = false) {
    var message = '';
    if(!objErrors) {
        message =
            '<div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">' +
                '<strong>Erro! </strong> Ocorreu um erro ao tentar cadastrar produto. Favor entrar em contato com o suporte.' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span>' +
                '</button>' +
            '</div>';
    } else {
        for(var error in objErrors) {
            message +=
                '<div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">' +
                    '<strong>Erro! </strong>' + objErrors[error] +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                '</div>';
        }
    }
    return message;
}

function buildAlertAlterando() {
    var message =
        '<div class="col-8 alert alert-warning show" role="alert" align="left">' +
            '<strong>Alterando! </strong>' +
        '</div>' +
        '<div class="col-4" align="right">' +
            '<button class="btn btn-primary btn-abortar-alteracao"><span class="font-white"> Abortar alteração </span></button>' +
        '</div>';
    return message;
}

$(document).ready(function(){

    /* $('.btn-abortar-alteracao').click(function(event) { */
    $('#formCarro').on('click', '.btn-abortar-alteracao', function(event) {
        event.preventDefault();
        prepareFormToCreate();
    })

    $("#salvar").click(function(event){
        event.preventDefault();
        $(".alert").alert('close');

        var formCarro = document.getElementById("formCarro");
        /* $('#salvar') é o botão salvar. A property data-product-id-change armazena o ID do carro quando está sendo
        alterado. Caso o ID seja 0, significa que não se trata de uma alteração mas sim de um cadastro */
        if($('#salvar').attr('data-product-id-change') == 0) {
            var fd = new FormData(formCarro);
            $.ajax({
                url: "/carros",
                data: fd,
                cache: true,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (result) {
                    showSuccess('cadastrado');
                    loadList();
                    prepareFormToCreate();
                },
                error: function(http) {
                    /* Caso o servidor retorne um erro de validação simples */
                    if(http.status == 400) {
                        $('.row-content').prepend(
                            buildAlertError(
                                JSON.parse(http.responseText)
                            )
                        );
                    } else {
                        $('.row-content').prepend(
                            buildAlertError()
                        );
                    }

                }
            });

        } else {
            $.ajax({
                url: '/carros/' + $('#salvar').attr('data-product-id-change') + '/?XDEBUG_SESSION_START',
                data: $('#formCarro').serialize(),
                cache: true,
                processData: false,
                contentType: false,
                type: 'PUT',
                success: function (result) {
                    showSuccess('alterado');
                    loadList();
                    prepareFormToCreate();
                },
                error: function(http) {
                    /* Caso o servidor retorne um erro de validação simples */
                    if(http.status == 400) {
                        $('.row-content').prepend(
                            buildAlertError(
                                JSON.parse(http.responseText)
                            )
                        );
                    } else {
                        $('.row-content').prepend(
                            buildAlertError()
                        );
                    }

                }
            });
        }
    });


    /* Não funciona para componentes acrescentados ou mesmo substituídos dinamicamente através de html() ou append().
    Foi necessário partir de um componente pai fixo e indicar o class dos compoentens filhos, esses sim recarregados.
    Através da declaração convencional abaixo funcionava apenas para os componentes carregados no primeiro load da
     página */
    /* $(".editIcon").click(function(event){ */
    $('#table-list').on('click', '.editIcon', function(event) {
        event.preventDefault();

        var formCarro = document.getElementById("formCarro");
        var fd = new FormData(formCarro);
        $.ajax({
            url: this.href,
            data: fd,
            cache: true,
            processData: false,
            contentType: false,
            type: 'GET',
            success: function (result) {
                $(".alert").alert('close');
                produto = JSON.parse(result);
                prepareFormToEdit(produto);
            }
        });
    });


    $('#table-list').on('click', '.deleteIcon', function(event) {
        event.preventDefault();

        $('.confirmar-exclusao').attr('data-href-exclude', this.href);
    });


    $(".confirmar-exclusao").click(function(event){
        event.preventDefault();

        $.ajax({
            type: 'DELETE',
            url: $(".confirmar-exclusao").attr('data-href-exclude'),
            success: function (result) {
                $('#excludeModal').modal('hide');
                showSuccess('excluído');
                loadList();
                prepareFormToCreate();
            }
        });
    });

});


