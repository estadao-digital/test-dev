function acao(id, acao, modelo, marca, ano) {
    const IdentificarAcao = {
        carregar(respostaArray) {
            carregarconteudo(respostaArray);
        },
        criar(respostaArray) {
            novocadastro(respostaArray);
        },
        editar(respostaArray) {
            atualizar(respostaArray);
        },
        excluir(respostaArray) {
            deletar(respostaArray);
        }
    };
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/php/carregar.php',
        data: {
            id: id,
            acao: acao,
            modelo: modelo,
            marca: marca,
            ano: ano
        },
        beforeSend: function() {
            $("#informativo").html('<center><img src="/imagem/load.gif" alt="some text" width=60 height=40></center>');
        },
        success: function(RespostaServidor) {
            if (RespostaServidor[0].validation) {
                const AplicarAcao = IdentificarAcao[acao];
                AplicarAcao(RespostaServidor);
            } else {
                $("#informativo").html('<p class="alert-erro">' + RespostaServidor[0].modelo + "</p>");
            }
        },
        complete: function() {
            var elemento = document.getElementById("novo_modelo");
            if (!elemento) {
                formulario_cadastro();
            }
        }
    });
};

function formulario_cadastro() {
    $.ajax({
        type: 'POST',
        dataType: 'html',
        url: '/php/formulariocadastro.php',
        success: function(response) {
            $("#criarconteudo").html(response);
        }
    });
}