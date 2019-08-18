
<form id="novo">
  <div class="form-group">
    <label for="id">Id</label>
    <input type="text" class="form-control" id="id" name="id" aria-describedby="id" placeholder="id" required="" value="{{$carro['id']}}">
    
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
    <input type="text" class="form-control" id="modelo" name="modelo" aria-describedby="modelo" placeholder="modelo" required="" value="{{$carro['modelo']}}">
    
  </div>
    <div class="form-group">
    <label for="ano">Ano</label>
    <input type="text" class="form-control" id="ano" name="ano" aria-describedby="ano" placeholder="ano" required="" value="{{$carro['ano']}}">
    
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<script>
         
         $('form').on('submit',function(e){
             e.preventDefault();
             $.ajax({
                contentType: 'application/x-www-form-urlencoded',
                url: 'api/carros/'+$('#id').val(),
                type: 'PUT',    
                data: $('#novo').serialize(),
                dataType: 'json',
                success: function(result) {
                   window.location.href="/carros";
                }
            });
            
         });
</script>