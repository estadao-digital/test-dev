
<div class="container">
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Carros Cadastrados</h3>
            </div>
            <table class='table fixme'>
                <thead>
                    <tr class="filters form-add">
                        <th width="30%">
                            <input name='brand_name' list="brands" type="text" class="form-control" placeholder="Marca" autofocus>
                            <datalist id="brands">
                                <?php foreach($brands as $brand){ ?>
                                    <option value="<?php echo $brand->brand_name?>">
                                <?php } ?>
                            </datalist>
                        </th>
                        <th width="40%"><input name='model' type="text" class="form-control" placeholder="Modelo"></th>
                        <th width="20%"><input name='year' type="text" class="form-control" placeholder="Ano"></th>
                        <th class='buttons'>
                            <button type="button" class="btn btn-success add" onclick="addCar(this)">
                                <i class="fas fa-plus-square"></i>
                            </button>
                            <button type="button" class="btn btn-info search">
                                <i class="fas fa-search"></i>
                            </button>
                        </th>
                    </tr>
                </thead>
            </table>
            <table class="table">
                
                <tbody>
                    <?php foreach($cars as $car){?>
                        <tr>
                            <input type='hidden' class='car_id' value='<?php echo $car->id?>'>
                            <td class='brand_name' width="30%"><?php echo $car->brand_name?></td>
                            <td class='model' width="40%"><?php echo $car->model?></td>
                            <td class='year' width="20%"><?php echo $car->year?></td>
                            <td class='buttons'>
                                <button type="button" class="btn btn-success" onclick="editCar(this)">
                                    <i class="fas fa-pencil-alt"></i>
                                    <i class="fas fa-save hidden"></i>
                                </button>
                                <button type="button" class="btn btn-danger" onclick="deleteCar(this)">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="js/fixme.js"></script>
<script src="js/filter.js"></script>