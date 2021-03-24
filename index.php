<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">    
    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>API CARROS</title>
</head>

<body>
<div class="container-fluid">
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    
      <!-- Brand/logo -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#example-1" aria-expanded="false">
          <span class="sr-only"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand btn-home" onclick="homeCarro()">Home</a>
      </div>
      
      <!-- Collapsible Navbar -->
      <div class="collapse navbar-collapse" id="example-1">
        <ul class="nav navbar-nav">
          <!-- <li class="active"><a href="#">Link 1 <span class="sr-only">(current)</span></a></li> -->
          <!-- <li><a href="#">Novo</a></li> -->
          <li><a class="btn-novo" onclick="novoCarro()">Novo</a></li>
        </ul>
      </div>
    
    </div>
  </nav>

  <div class="table-responsive tabela">
    <h1>Lista de Carros</h1>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Marca</th>
          <th scope="col">Modelo</th>
          <th scope="col">Ano</th>
          <th scope="col">Ações</th>
        </tr>
      </thead>
      <tbody class="list"></tbody>
    </table>
  </div>

  <div class="editar">
    <h1>Editar de Carros</h1>
   
      <div class="form-group">
        <input type="hidden" class="editar-id">

        <label for="formGroupMarcar">Marcar</label>
        <input type="text" class="form-control editar-marca" id="formGroupMarcar" placeholder="Marcar" value="">
      </div>
      <div class="form-group">
        <label for="formGroupModelo">Modelo</label>
        <input type="text" class="form-control editar-modelo" id="formGroupModelo" placeholder="Modelo" value="">
      </div>
      <div class="form-group">
        <label for="formGroupAno">Ano</label>
        <input type="number" class="form-control editar-ano" id="formGroupAno" placeholder="Ano" value="">
      </div>
      <button type="submit" class="btn btn-primary" onclick="atualizarCarro()">Atualizar</button>
  </div>

    <div class="visualizar">
      <h1>Visualizar Carros</h1>
    
        <div class="form-group">
          <input type="hidden" class="visualizar-id" disabled>

          <label for="formGroupMarcar">Marcar</label>
          <input type="text" class="form-control visualizar-marca" id="formGroupMarcar" placeholder="Marcar" disabled>
        </div>
        <div class="form-group">
          <label for="formGroupModelo">Modelo</label>
          <input type="text" class="form-control visualizar-modelo" id="formGroupModelo" placeholder="Modelo" disabled>
        </div>
        <div class="form-group">
          <label for="formGroupAno">Ano</label>
          <input type="number" class="form-control visualizar-ano" id="formGroupAno" placeholder="Ano" disabled>
        </div>
    </div>

    <div class="novo">
        <div class="form-group">
          <label for="formGroupMarcar">Marcar</label>
          <input type="text" class="form-control novo-marca" id="formGroupMarcar" placeholder="Marcar" onchange='novoMarcaCarro(this.value)'>
        </div>
        <div class="form-group">
          <label for="formGroupModelo">Modelo</label>
          <input type="text" class="form-control novo-modelo" id="formGroupModelo" placeholder="Modelo" onchange='novoModeloCarro(this.value)'>
        </div>
        <div class="form-group">
          <label for="formGroupAno">Ano</label>
          <input type="number" class="form-control novo-ano" id="formGroupAno" placeholder="Ano" onchange='novoAnoCarro(this.value)'>
        </div>
      <button type="submit" class="btn btn-primary" onclick="salvarCarro()">Salvar</button>
    </div>
  </div>

    <script src="script.js"></script>
    <style>
      .editar{
        display: none;
      }
      .visualizar{
        display: none;
      }
      .criar{
        display: none;
      }
      .novo{
        display: none;
      }
      .btn-novo{
        cursor: pointer;
      }
      .btn-home{
        cursor: pointer;
      }
    </style>
</body>

</html>