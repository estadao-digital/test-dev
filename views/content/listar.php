<div class="container" > 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-wraper">
        <div class="col-xs-12 button-wraper top">
            <button type="button" class="btn btn-success add to-content" data-href="<?php echo BASE?>novo">Adicionar<i class="fa fa-plus"></i></button> 
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ano</th> 
                    <th>Ação</th>                
                </tr>
            </thead>
            <?php foreach ($viewData['carros'] as $key => $value): ?>
                <tr>
                    <td><?php echo $value['id']; ?></td>
                    <td><?php echo $value['marca']; ?></td>
                    <td><?php echo $value['modelo']; ?></td>
                    <td><?php echo $value['ano']; ?></td> 
                    <td>                      
                        <button type="button" class="btn btn-primary edit to-content" data-href="<?php echo BASE . "editar/". $value['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-danger remove" data-href="<?php echo BASE . "carros/" . $value['id']; ?>" ><i class="fa fa-times" aria-hidden="true"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>    
    </div>
</div>