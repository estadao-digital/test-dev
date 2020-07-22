<div id="novo_modelo">
    <label>Modelo do carro</label>
    <input type="text" class="novo_campo" id="modelo_novo" placeholder="RS 6 Avant">
</div>
<div id="nova_marca">
    <label>Marca do carro</label>
        <select class="novo_campo" id="marca_nova">
            <option value="volvo">Volvo</option>
            <option value="saab">Saab</option>
            <option value="mercedes">Mercedes</option>
            <option value="audi">Audi</option>
            <option value="Corvette">Corvette</option>
            <option value="DS">DS</option>
        </select>
    </div>
<div id="novo_ano">
    <label>Ano do carro</label>
    <input type="number" min="1900" max="2020" step="1" class="novo_campo" id="ano_novo" placeholder="2020" />
</div>
<div id="botao_cadastrar" class="blococadastro">
    <button type="button" id="control_botao" class="cadastrar botao" onclick="acao(0,'criar', modelo_novo.value, marca_nova.value, ano_novo.value)">Cadastrar</button>
</div>

