<div class="modal fade" id="carroModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Carro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-car" class="" data-id="">
                    <div class="form-group">
                        <select class="form-control" name="marca" placeholder="Marca" required>
                            <option value="" selected>Marca</option>
                            <option value="GM">GM</option>
                            <option value="Ford">Ford</option>
                            <option value="Fiat">Fiat</option>
                            <option value="Audi">Audi</option>
                            <option value="Ferrari">Ferrari</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="modelo" type="text" placeholder="Modelo" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="cor" type="text" placeholder="Cor" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="ano" type="text" placeholder="Ano" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button id="btn-cta" type="button" class="btn btn-primary" onclick="formModal.submit()" data-action="" data-id="" >Enviar</button>
            </div>
        </div>
    </div>
</div>
