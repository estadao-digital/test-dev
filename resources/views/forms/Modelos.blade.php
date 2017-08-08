<div class="modal fade" id="myModal-modelo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">Modelo</h4>
                        </div>
                        <div class="modal-body">
                            <form id="frmmarca" name="frmmarca" class="form-horizontal" novalidate="">

                                <div class="form-group">
                                    <label for="marca" class="col-sm-3 control-label">Marca</label>
                                    <div class="col-sm-9">
                                        <select name="marca_modelo" id="marca_modelo" class="form-control" style="width:350px">
                                            <option value="">--- Selecione a Marca ---</option>
                                       
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group error">
                                    <label for="modelo" class="col-sm-3 control-label">Modelo</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control has-error" id="modelo" name="modelo" placeholder="Modelo" value="">
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save-modelo" value="add">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>