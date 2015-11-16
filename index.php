<?php
include('conn.php');
?>



<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="container">

        <ul class="nav nav-pills">
          <li role="presentation" class="active"><a href="#">Listar Carros</a></li>
          <li role="presentation"><a href="#" data-toggle="modal" data-target="#myModal">Criar Carro</a></li>


          <!-- Trigger the modal with a button -->
      </ul>

      <table class="table table-condensed">
        <tr class="active">
            <td>Id</td>
            <td>Marca</td>
            <td>Modelo</td>
            <td>Ano</td>
            <td>Editar</td>
            <td>Excluir</td>
        </tr>
        <?php
        mysql_query("set names 'utf8'");
        $query = mysql_query("SELECT * FROM carros");
        while($resultado = mysql_fetch_array($query)){
            echo "<tr>
            <td>". $resultado['id'] . "</td>
            <td>". $resultado['marca'] . "</td>
            <td>". $resultado['modelo'] . "</td>
            <td>". $resultado['ano'] . "</td>


            <form method='post'>
            <td><a class='btn btn-warning glyphicon glyphicon-pencil editar-carro' value='a'><a/></td>
            <td><a class='btn btn-danger glyphicon glyphicon-remove excluir-carro' value='a'><a/></td>
            </form>


            </tr>";
        }

        ?>

    </table>


</div>




<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form method="post">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Criar Carro</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <input type="text" name="modelo" class="form-control" placeholder="Modelo">
        </div>
        <div class="form-group">
            <input type="text" name="marca" class="form-control" placeholder="Marca">
        </div>
        <div class="form-group">
            <input type="text" name="ano" class="form-control" placeholder="Ano">
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="criar-carro">Criar</button>
    </div>
</div>
</form>
</div>
</div>







<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.3.min.js"><\/script>')</script>

<script src="js/main.js"></script>
</body>
</html>
