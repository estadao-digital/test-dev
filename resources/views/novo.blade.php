<form id="novo">
  <div class="form-group">
    <label for="id">Id</label>
    <input type="text" class="form-control" id="id" name="id" aria-describedby="id" placeholder="id" required="">
    
  </div>
  <div class="form-group">
    <label for="marca">Marcas</label>
    <select class="form-control" id="marca" name="marca">
        <option value="GM">GM</option>
        <option value="FIAT">Fiat</option>
        <option value="VW">Volkswagem</option>
        <option value="FORD">Ford</option>
    </select>
  </div>
    <div class="form-group">
    <label for="modelo">Modelo</label>
    <input type="text" class="form-control" id="modelo" name="modelo" aria-describedby="modelo" placeholder="modelo" required="">
    
  </div>
    <div class="form-group">
    <label for="ano">Ano</label>
    <input type="text" class="form-control" id="ano" name="ano" aria-describedby="ano" placeholder="ano" required="">
    
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<script>
     $(function () {
         $('form').on('submit',function(e){
             $.post('{{route("cadastra_carro")}}',$('#novo').serialize())
         })
     });

</script>