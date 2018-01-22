<?php
include "header.php";

//echo "<pre>";
//print_r($selectcarros);
?>

<div class="container">
    <h1><span id="page_title">Listagem de Carros</span> <button class="btn btn-success btn-plus pull-right"><i class="icon-plus"></i> Adicionar Carro </button></h1>
    <hr>
    <!-- Conteúdo -->
    <div class="row content-ajax">
        <div class="col-md-9 centered" >
            <div class="widget box ">
                <div class="widget-header">
                    <h4><i class="icon-reorder"></i>  </h4>
                </div>
                <div class="widget-content">
                    <table id="carros" class="table table-striped table-bordered table-hover table-checkable">
                        <thead>
                        <tr>
                            <th >Marca</th>
                            <th >Modelo</th>
                            <th >Ano</th>
                            <th width="110" >Ações</th>
                        </tr>
                        </thead>
                        <tbody>
						
						<?php
						//date('j/n/Y', 287182953);
						foreach($selectcarros as $key => $row):
							?>
                            <tr>

                                <td><?= $row->marcas->name; ?></td>
                                <td><?= $row->name; ?></td>
                                <td><?= $row->ano; ?></td>
                                <td style="display: inline-flex">

                                    <button type="button" title="Editar" data-id="<?= $row->id; ?>" class="btn btn-warning btn-edit"><i class="icon-edit"></i></button>
                                    <button type="button" title="Deletar" data-id="<?= $row->id; ?>" class="btn btn-danger btn-delete"><i class="icon-remove"></i></button>
                                </td>

                            </tr>
							<?php
						endforeach;
						?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <input id="url_addcarro" type="hidden" value="addcarro">
</div> <!-- /container -->

<?php
include "footer.php"
?>
