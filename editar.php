<?php
require_once "carro.class.php";
$id = $_GET['id'];


$recebeDados = new selectCarros;
$dadosCarro = $recebeDados->select($id);

?>



<form id="atualizaForm" onSubmit="return false;" method="post" action="carro.class.php">
<?PHP
    
    foreach($dadosCarro as $key => $value){ ?>
<div class="row justify-content-md-center">
<div class="col">
  <div class="form-group">
    <label for="exampleFormControlSelect1">Marca</label>
    <select class="form-control" name="marca" id="marca">
    <option value="<?=$value->marca?>" selected><?=$value->marca?></option>
      <option value="Chevrolet">Chevrolet</option>
      <option value="Chery">Chery</option>
      <option value="Wolks">Wolks</option>
      <option value="Audi">Audi</option>
      
    </select>
  </div>
</div>

<div class="col">
  <div class="form-group">
    <label for="exampleFormControlInput1">Modelo</label>
    <input type="text" class="form-control" name="modelo" id="modelo" value="<?=$value->modelo?>">
  </div>
</div>

<div class="col">
  <div class="form-group">
    <label for="exampleFormControlInput1">Ano</label>
    <input type="text" class="form-control" name="ano" id="ano" value="<?=$value->ano?>">
  </div>
</div>




</div>
<div class="row justify-content-md-center">
<input type="hidden" name="id" id="id" value="<?=$value->id?>">
<button  onClick="atualiza();" id="btnEnviar" class="btn btn-primary">Salvar</button>
</div>
<?PHP      
                                   
  }?>

 
</form>

<script>
           
            function atualiza(){
              $.ajax({
                method: "post",
                url: "carro.class.php",
                data: $("#atualizaForm").serialize(),
              });
              
              alert('Dados Alterados Com Sucesso!! ');
              location.href='index.php';
            }
        </script>

