<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
            #tamanhoContainer{
                width: 1000px
            }    
     </style>
    <link rel="stylesheet" href="css/bootstrap.css">
    <script type="text/javascript" src="js/script.js"></script>

    <title>Veículos</title>

</head>
<body onload="getDados()">
    
<div class="container" id="tamanhoContainer" style="margin-top: 40px"> 

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="nav">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php" >Veiculos</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="cadastrarVeiculo.php" id="cadastrar">Cadastrar</a>
        </li> 
      </ul>
    </div>
  </div>
</nav>
<table id='table' class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Cod</th>
      <th scope="col">Marca</th>
      <th scope="col">Modelo</th>
      <th scope="col">Ano</th>
      <th scope="col">Editar</th>
      <th scope="col">Excluir</th>
    </tr>
  </thead>
  <tbody id="teste">
<div>
      </div>
    </tr>
  </tbody>
</table>
<script type="text/javascript" src="js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>

</body>
</html>