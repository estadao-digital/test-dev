<?php include("api.php");


?>
<div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Carros cadastrados <a  class = "btn btn-success" href = "#modalCarro" data-toggle = "modal"><i class = "fa fa-plus"></i></a>
                                    
                    </header>
                    <div class="modal fade" id="modalCarro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">Adicionar Carro</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" id = "addCarro" >
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Carro</label>
                                                    <input type="text" class="form-control" id="carro" name = "carro" placeholder="Carro">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Marca</label>
                                                    <select class="form-control" name = "marca">
                                                        <option value = "">Selecione uma Marca</option>
                                                        <?php
                                                        foreach($marcas as $marca){?>
                                                            <option value = "<?php echo $marca['marca'];?>"><?php echo $marca['marca'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Ano</label>
                                                    <input class="form-control" type="text" name= "ano">
                                                </div>
                                                <input type="button" id = "add_carro" class="btn btn-info" value = "Salvar Carro">
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                           
                                        </div>
                                    </div>
                                </div>
                    </div>
                    <div class="panel-body">
                    <div class="adv-table">
                    <table class="table cart-table">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th class="hidden-phone">Ano</th>
                        <th></th>
                        <th></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($carros as $carro){ ?>
                    <tr class="gradeX">
                        <td><?php echo $carro['id'];?></td>
                        <td><?php echo $carro['carro'];?></td>
                        <td><?php echo $carro['marca'];?></td>
                        <td class="hidden-phone"><?php echo $carro['ano'];?></td>
                        
                        <td>
                            <a href = "#editCarroModal<?php echo $carro['id'];?>"data-toggle = "modal"><i class = "fa fa-edit"></i></a>
                            <div class="modal fade" id="editCarroModal<?php echo $carro['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">Editar Carro</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" id = "editCarro<?php echo $carro['id'];?>">
                                                <input type="hidden" name="_METHOD" value="PUT" />
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Carro</label>
                                                    <input type="hidden" name="id" value="<?php echo $carro['id'];?>" />
                                                    <input type="text" class="form-control" value = "<?php echo $carro['carro'];?>" id="carro<?php echo $carro['id'];?>" name = "carro" placeholder="Carro">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Marca</label>
                                                    <select class="form-control" id = "marca<?php echo $carro['id'];?>">
                                                        <option value = "">Selecione uma Marca</option>
                                                        <?php
                                                        foreach($marcas as $marca){?>
                                                            <option <?php if($carro['marca'] == $marca['marca']){ echo "selected"; }?> value = "<?php echo $marca['marca'];?>"><?php echo $marca['marca'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputFile">Ano</label>
                                                    <input class="form-control" type="text" value = "<?php echo $carro['ano'];?>" id= "ano<?php echo $carro['id'];?>">
                                                </div>
                                                <input type="button" data-carro = "<?php echo $carro['id'];?>" id = "edit_carro_ok" class="btn btn-info" value = "Salvar Carro">
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class = "center">
                            <!--<form action = "api.php" method = "POST">
                                <input type="hidden" name="_METHOD" value="DELETE" />
                                <input type="hidden" name="id" value="<?php echo $carro['id'];?>" />
                                <input type = "submit" value = "X">
                            </form>-->
                            <a class = "delete_carro" data-id = "<?php echo $carro['id'];?>"><i class = "fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                    <?php }?>
                   
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th class="hidden-phone">Ano</th>
                        <th class = "center"></th>
                        <th></th>

                    </tr>
                    </tfoot>
                    </table>
                    </div>
                    </div>
                </section>
            </div>
        </div>