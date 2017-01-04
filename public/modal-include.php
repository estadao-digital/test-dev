<div class="modal fade" tabindex="-1" id="modal-insert" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <p>Inclusão de um novo Carro, por favor, digite os campos obrigatórios</p>
                <form method="post" id="form-include" action="/home">
                    <div class="form-group">
                        <label for="marca">Marca</label>
                        <select name="marca" class="form-control" id="marca-insert" required>
                            <option value="">Selecione uma Marca</option>
                            <?php foreach(Funcoes::listaMarcas() as $key => $value) { ?>
                                <option value="<?=$key?>"><?=$value?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="modelo">Selecione um Modelo</label>
                        <input type="text" class="form-control" id="modelo-insert" placeholder="Modelo" required>
                    </div>
                    <div class="form-group">
                        <label for="ano">Selecione o Ano</label>
                        <input type="number" class="form-control" id="ano-insert" placeholder="Ano de Fabricação" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="button-insert">Salvar Carro</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->