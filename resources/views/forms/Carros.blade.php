<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">Carro</h4>
                        </div>
                        <div class="modal-body">
                            <form id="frmcarros" name="frmcarros" class="form-horizontal" novalidate="">

                                <div class="form-group">
                                    <label for="marcas" class="col-sm-3 control-label">Marca</label>
                                    <div class="col-sm-9">
                                        <select name="marcas" id="marcas" class="form-control" style="width:350px">
                                            <option value="">--- Selecione a Marca ---</option>
                                           
                                                <option value=""></option>
                                           
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="modelos" class="col-sm-3 control-label">Modelo</label>
                                    <div class="col-sm-9">
                                        <select name="modelos" id="modelos" class="form-control" style="width:350px">
                                            <option value="">--- Selecione o Modelo ---</option>
                                   
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group error">
                                    <label for="ano" class="col-sm-3 control-label">Ano</label>
                                    <div class="col-sm-9">
                                        <input onkeyup="somenteNumeros(this)" type="text" class="form-control has-error" id="ano" name="ano" placeholder="Ano" value="">
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save" value="add">Salvar</button>
                            <input type="hidden" id="carro_id" name="carro_id" value="0">
                        </div>
                    </div>
                </div>
            </div>