/*

-->> MODELO DE EXEMPLO DO BLOCO DE HTML "card_carro" usado na variável "renderizar" da função carregarconteudo().

<div id="card_carro">
    <div class="modelo_carro">
        <label>Modelo do carro</label>
        <input type="text" class="modelo_campo" id="modelo_do_carro7" placeholder="RS 6 Avant" disabled>
    </div>
    <div class="marca_carro">
        <label>Marca do carro</label>
        <select class="marca_campo" id="marca_selecionarid" disabled></select>
    </div>
    <div class="ano_carro">
        <label>Ano do carro</label>
        <input type="number" min="1900" max="2020" step="1" class="ano_campo" id="ano" value="2020" disabled />
    </div>
    <div class="botoes_de_acao">
        <button type="button" class="excluir botao">Excluir</button>
        <button type="button" class="editar botao">Editar</button>
    </div>
</div>
*/

function carregarconteudo(CarregamentoArray) {
    if (CarregamentoArray.length > 1) {
        for (var i = 1; i < CarregamentoArray.length; i++) {
            var renderizar = '<div id="card_carro' + CarregamentoArray[i].id + '" class="card_carro">';
            renderizar = renderizar + '<div class="modelo_carro" id="modelo' + CarregamentoArray[i].id + '">';
            renderizar = renderizar + '<label>Modelo do carro</label>';
            renderizar = renderizar + '<input type="text" class="modelo_campo" id="modelo_do_carro' + CarregamentoArray[i].id + '"';
            renderizar = renderizar + 'value="' + CarregamentoArray[i].modelo + '" disabled></div>';
            renderizar = renderizar + '<div id="marca' + CarregamentoArray[i].id + '"  class="marca_carro"><label>Marca do carro</label>';
            renderizar = renderizar + '<select class="marca_campo" id="marca_selecionar' + CarregamentoArray[i].id + '" disabled>';
            renderizar = renderizar + '<option value="' + CarregamentoArray[i].marca + '" selected>' + CarregamentoArray[i].marca + '</option></select></div>';
            renderizar = renderizar + '<div class="ano_carro"><label>Ano do carro</label>';
            renderizar = renderizar + '<input type="number" min="1900" max="2020" step="1" class="ano_campo" id="ano';
            renderizar = renderizar + CarregamentoArray[i].id + '" value="' + CarregamentoArray[i].ano + '" disabled></div>';
            renderizar = renderizar + '<div id="bloco_botao' + CarregamentoArray[i].id + '" class="botoes_de_acao">';
            renderizar = renderizar + '<button type="button" id="control_botao" class="excluir botao" onclick="acao(';
            renderizar = renderizar + CarregamentoArray[i].id + ", 'excluir', 'null', 'null', 'null'" + ')"> Excluir </button>';
            renderizar = renderizar + '<button type="button" id="control_botao" class="editar botao" onclick="alterar(';
            renderizar = renderizar + CarregamentoArray[i].id + ",'" + CarregamentoArray[i].modelo + "','" + CarregamentoArray[i].marca;
            renderizar = renderizar + "','" + CarregamentoArray[i].ano + "'" + ')">Editar</button></div></div>';
            $("#conteudotabela").append(renderizar);
            $("#informativo").html("");
        }
    } else {
        $("#informativo").html("<p>Não há carros cadastrados!</p>");
    }
}