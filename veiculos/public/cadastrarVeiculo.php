<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">    
    <title>Formulário</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
            #tamanhoContainer{
                width: 500px
            }
    
    </style>
</head>
<body>

<div class="container" id="tamanhoContainer" style="margin-top: 40px">

  <h4> Cadastrar Veiculo </h4>

    <form style="margin-top: 20px;">

      
      <div class="form-group">
        <label>Modelo</label>
        <input type="text" id="modelo" class="form-control" >
        
      </div>
      
      <div class="form-group">
        <label>Ano</label>
        <input type="text" id="ano" class="form-control" >
        
      </div>

      <div class="form-group">
        <label for="exampleFormControlSelect1" >Marca</label>
        <select class="form-control" id="marca" placeholder="Informe a Categoria" >
          <option>Marca</option>
          <option>Chevrolet</option>
          <option>Volkswagem</option>
          <option>Fiat</option>
          
        </select>
      </div>

    
      <div style="text-align: right;">
      <a style="margin-left:0;" href="index.php" role="button" class="btn btn-dark" class="btn btn-dark btm-sm">Voltar</a>
      <a style="margin-left:0;"  role="button" class="btn btn-primary btn" onclick="cadastraVeiculo()">Cadastrar</a>
      </div>


  </form>
  
  </div>
  
<script type="text/javascript" src="js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
</body>
</html>