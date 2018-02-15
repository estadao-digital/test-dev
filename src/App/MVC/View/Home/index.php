<div class='titleContent'>
    <h1>Administrador de Carros</h1>
</div>
<div class="main">
    <div class='formContent'>
        <h2>Adicionar Carro</h2>
        <form id="addForm">
            <input type="hidden" name="id" value="null" />
            <label>
                <div>Marca:</div>
                <select name="marca">
                    <option value="fiat">Fiat</option>
                    <option value="volks">Volks</option>
                    <option value="honda">Honda</option>
                </select>
            </label>
            <label>
                <div>Modelo:</div>
                <input type="text" name="modelo" />
            </label>
            <label>
                <div>Ano:</div>
                <input type="number" name="ano" />
            </label>
            <input type="submit" value='salvar' class='button button-save' />
        </form>
    </div>

    <div class='tableContent'>
        <h2>Listagem</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <div class="modal">
        <div class='formModalContent modalContent'>
            <h2>Remover Carro</h2>
            <form class="formModal">
                <input type="hidden" name="id" value="null" />
                <div class="messageDelete"></div>
                <div class="buttonGroup">
                    <input type="submit" value="Excluir" id="removeCar" class='button button-save' />
                    <input type="button" value="Cancelar" id="closeModal" class='button button-cancel' />
                </div>
            </form>
        </div>
    </div>
</div>