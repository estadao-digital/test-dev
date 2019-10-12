function limpar() {
    $(document).ready(function(){
        $('#marca').val(0);
        $('#modelo').val('');
        $('#ano').val('');
        $('#salvar').attr('data-product-id-change', 0);
        $('#salvar').text('Salvar cadastro');
    });
}

function buildList(json_produtos) {
    produtos = JSON.parse(json_produtos);

    var list = '';
    for (var key in produtos) {
        produto = produtos[key];
        list += '<tr> ' +
            '<th scope="row">  ' +  produto.marca + ' </th> ' +
            '<td> '  + produto.modelo + '  </td> ' +
            '<td> ' + produto.ano + '</td> ' +
            '<td class="text-center"><a href="/carros/' + produto.id + '" class="alterar"> <i class="fas fa-edit"></i> </a></td> ' +
            '<td class="text-center"><a href="/carros/' + produto.id +'" class="deletar"> <i class="fa fa-trash fa-2" aria-hidden="true"></i> </a></td></tr>';
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

$(document).ready(function(){

    $('#limpar').click(function(event) {
        limpar();
    })

    $(".alterar").click(function(event){
        event.preventDefault();

        var formCarro = document.getElementById("formCarro");
        var fd = new FormData(formCarro);
        $.ajax({
            url: this.href,
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            type: 'GET',
            success: function (result) {
                produto = JSON.parse(result);

                $('#marca').val(produto.marca);
                $('#modelo').val(produto.modelo);
                $('#ano').val(produto.ano);
                $('#salvar').attr('data-product-id-change', produto.id);
                $('#salvar').text('Salvar alteração');

            }
        });
    });

    $("#salvar").click(function(event){
        event.preventDefault();

        var formCarro = document.getElementById("formCarro");
        if($('#salvar').attr('data-product-id-change') == 0) {
            var fd = new FormData(formCarro);
            $.ajax({
                url: "/carros",
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (result) {
                    alert('Sucesso! Carro gravado com sucesso!');
                    loadList();
                    limpar();
                }
            });

        } else {
            $.ajax({
                url: '/carros/' + $('#salvar').attr('data-product-id-change') + '/?XDEBUG_SESSION_START',
                data: $('#formCarro').serialize(),
                cache: false,
                processData: false,
                contentType: false,
                type: 'PUT',
                success: function (result) {
                    alert('Sucesso! Carro alterado com sucesso!');
                    limpar();
                }
            });
        }
    });


    $(".deletar").click(function(event){
        event.preventDefault();

        $.ajax({
            type: 'DELETE',
            url: this.href,
            success: function (result) {
                alert('Sucesso! Carro excluído com sucesso!');
                loadList();
                limpar();
            }
        });
    });


});


