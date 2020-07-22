function novocadastro(CarregamentoArray) {

    var renderizar = '<div id="card_carro' + CarregamentoArray[0].id + '" class="card_carro">';
    renderizar = renderizar + '<div class="modelo_carro" id="modelo' + CarregamentoArray[0].id + '">';
    renderizar = renderizar + '<label>Modelo do carro</label>';
    renderizar = renderizar + '<input type="text" class="modelo_campo" id="modelo_do_carro' + CarregamentoArray[0].id + '"';
    renderizar = renderizar + 'value="' + CarregamentoArray[0].modelo + '" disabled></div>';
    renderizar = renderizar + '<div id="marca' + CarregamentoArray[0].id + '" class="marca_carro"><label>Marca do carro</label>';
    renderizar = renderizar + '<select class="marca_campo" id="marca_selecionar' + CarregamentoArray[0].id + '" disabled>';
    renderizar = renderizar + '<option value="' + CarregamentoArray[0].marca + '" selected>' + CarregamentoArray[0].marca + '</option></select></div>';
    renderizar = renderizar + '<div class="ano_carro"><label>Ano do carro</label>';
    renderizar = renderizar + '<input type="number" min="1900" max="2020" step="1" class="ano_campo" id="ano';
    renderizar = renderizar + CarregamentoArray[0].id + '" value="' + CarregamentoArray[0].ano + '" disabled></div>';
    renderizar = renderizar + '<div id="bloco_botao' + CarregamentoArray[0].id + '" class="botoes_de_acao">';
    renderizar = renderizar + '<button type="button" id="control_botao" class="excluir botao" onclick="acao(';
    renderizar = renderizar + CarregamentoArray[0].id + ", 'excluir', 'null', 'null', 'null'" + ')"> Excluir </button>';
    renderizar = renderizar + '<button type="button" id="control_botao" class="editar botao" onclick="alterar(';
    renderizar = renderizar + CarregamentoArray[0].id + ",'" + CarregamentoArray[0].modelo + "','" + CarregamentoArray[0].marca;
    renderizar = renderizar + "','" + CarregamentoArray[0].ano + "'" + ')">Editar</button></div></div>';
    $("#conteudotabela").append(renderizar);

    $("#informativo").html('<p class="alert-sucesso">Cadastro realizado com sucesso!</p>');
}

function deletar(CarregamentoArray) {
    var node = document.getElementById("card_carro" + CarregamentoArray[0].id);
    $("#informativo").html('<p class="alert-sucesso">Exclusão realizado com sucesso!</p>');
    if (node.parentNode) {
        node.parentNode.removeChild(node);
    } else {
        acao(0, 'carregar', 'null', 'null', 'null');
    }
}

function alterar(id, modelo, marca, ano) {

    $('button[id^="control_botao"]').prop('disabled', true);
    document.getElementById('marca_nova').disabled = true;
    document.getElementById('modelo_novo').disabled = true;
    document.getElementById('ano_novo').disabled = true;
    document.getElementById('modelo_do_carro' + id).disabled = false;
    document.getElementById('ano' + id).disabled = false;
    document.getElementById('marca_selecionar' + id).disabled = false;
    //Renderizar os botões
    var renderizar = '<button type="button" class="editar botao"onclick="acao(';
    renderizar = renderizar + id + ", 'editar', modelo_do_carro" + id + ".value, marca_selecionar" + id + ".value, ano" + id + ".value" + ')"> Concluir </button>';
    renderizar = renderizar + '<button type="button" class="cancelar botao" onclick="cancelar(' + id;
    renderizar = renderizar + ",'" + modelo + "','" + marca + "','" + ano + "'" + ')">Cancelar</button>';
    $("#bloco_botao" + id).html(renderizar);

    //Renderizar o select
    $('#marca_selecionar' + id).html('');
    var value = document.getElementById('marca_nova').options;
    for (var i = 0; i < value.length; i++) {
        if (value[i].value == marca) {
            $('#marca_selecionar' + id).append('<option value="' + value[i].value + '" selected>' + value[i].value + '</option>');
        } else {
            $('#marca_selecionar' + id).append('<option value="' + value[i].value + '">' + value[i].value + '</option>');
        }
    }

}

function cancelar(id, modelo, marca, ano) {

    $('button[id^="control_botao"]').prop('disabled', false);
    document.getElementById('marca_nova').disabled = false;
    document.getElementById('modelo_novo').disabled = false;
    document.getElementById('ano_novo').disabled = false;
    document.getElementById('modelo_do_carro' + id).disabled = true;
    document.getElementById('ano' + id).disabled = true;
    document.getElementById('marca_selecionar' + id).disabled = true;

    var renderizar = '<button type="button" id="control_botao" class="excluir botao" onclick="acao(';
    renderizar = renderizar + id + ", 'excluir', 'null', 'null', 'null'" + ')"> Excluir </button>';
    renderizar = renderizar + '<button type="button" id="control_botao"  class="editar botao" onclick="alterar(' + id;
    renderizar = renderizar + ",'" + modelo + "','" + marca + "','" + ano + "'" + ')">Editar</button>';
    $("#bloco_botao" + id).html(renderizar);

    document.getElementById('modelo_do_carro' + id).value = modelo;
    document.getElementById('ano' + id).value = ano;
    document.getElementById('marca_selecionar' + id).value = marca;

}

function atualizar(CarregamentoArray) {
    cancelar(CarregamentoArray[0].id, CarregamentoArray[0].modelo, CarregamentoArray[0].marca, CarregamentoArray[0].ano);
    $("#informativo").html('<p class="alert-sucesso">Alteração realizada com sucesso!</p>');
}