<form id="cadastraform" id="formulario" onSubmit="return false;" method="post" action="carro.class.php">
<div class="row justify-content-md-center">
<div class="col">
  <div class="form-group">
    <label for="exampleFormControlSelect1">Marca</label>
    <select class="form-control" name="marca" id="marca">
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
    <input type="text" class="form-control" name="modelo" id="modelo" placeholder="Modelo">
  </div>
</div>

<div class="col">
  <div class="form-group">
    <label for="exampleFormControlInput1">Ano</label>
    <input type="text" class="form-control" name="ano" id="ano" placeholder="Ano">
  </div>
</div>




</div>
<div class="row justify-content-md-center">
<input type="hidden" name="status" id="status" value="1">
<button  onClick="ajaxPost('carro.class.php','#destino');" id="btnEnviar" class="btn btn-primary">Gravar</button>
</div>

</form>

