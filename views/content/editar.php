<div class="container" id="formulario">
    <h4>Editar</h4>
    <form id="form-editar" method="PUT" action="<?php echo BASE . "carros/". $viewData['carro']['id'] ?>" class="form">
        <div class="col-xs-12 button-wraper top">
            <button type="submit" class="btn btn-success">Salvar</button>
            <button type="button" class="btn btn-warning to-content"  data-href="<?php echo BASE ?>/listar">Voltar</button>
        </div>
        <div class="form-group col-xs-4 col-md-2">            
            <label for="produto">id:</label>            
            <input type="text" class="form-control" readonly value="<?php echo $viewData['carro']['id']?>" />
        </div>        
        <div class="clear"></div>
        <div class="form-group col-md-6">            
            <label for="marca">Marca:</label>
            <input type="text" class="form-control" name="marca" value="<?php echo $viewData['carro']['marca']?>"/>
        </div>
        <div class="clear"></div>
        <div class="form-group col-md-6">
            <label for="modelo">Modelo:</label>
            <input type="text" class="form-control" name="modelo" value="<?php echo $viewData['carro']['modelo']?>"/>
        </div>
        <div class="clear"></div>
        <div class="form-group col-xs-6 col-md-4">
            <label for="ano">Ano:</label>
            <input type="text" class="form-control" name="ano" value="<?php echo $viewData['carro']['ano']?>"/>
            <input type="hidden" name="id" value="<?php echo $viewData['carro']['id']?>" />
        </div> 
        <div class="col-xs-12 button-wraper bottom">       
            <button type="submit" class="btn btn-success" data-href="/inserir">Salvar</button>
            <button type="button" class="btn btn-warning to-content"  data-href="<?php echo BASE ?>/listar">Voltar</button>
        </div>
    </form>
</div>