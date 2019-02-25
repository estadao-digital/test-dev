<?php
// Conexão
include_once 'php_action/db_connect.php';
/// Select
if(isset($_GET['id'])):
	$id = mysqli_escape_string($connect, $_GET['id']);

	$sql = "SELECT * FROM carros WHERE id = '$id'";
	$resultado = mysqli_query($connect, $sql);
	$dados = mysqli_fetch_array($resultado);
endif;
?>
<!DOCTYPE html>
<html class="no-js" lang="">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title></title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="./css/main.css" />
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <link
      href="https://fonts.googleapis.com/css?family=Satisfy"
      rel="stylesheet"
    />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous"
    />
    
  </head>
	
    <header class="logo">
      <div class="container-fluid " style="padding:0px;">
        <div class="container">
          <h1>Logotipo</h1>
        </div>
      </div>
    </header>

<div class="row">
	<div class="col-md-6" id="margin">
		<h3 class="light"> Editar Cliente </h3>
		<form action="php_action/update.php" method="POST">
			<input type="hidden" name="id" value="<?php echo $dados['id'];?>">
			<div class="input-field col s12">
				<input type="text" name="marca" id="marca" value="<?php echo $dados['marca'];?>">
				<label for="marca">Nome</label>
			</div>

			<div class="input-field col s12">
				<input type="text" name="modelo" value="<?php echo $dados['modelo'];?>" id="modelo">
				<label for="modelo">Sobrenome</label>
			</div>

			<div class="input-field col s12">
				<input type="text" value="<?php echo $dados['ano'];?>" name="ano" id="ano">
				<label for="ano">Idade</label>
			</div>

			<button type="submit" name="btn-editar" class="btn"> Atualizar</button>
			<a href="index.php" class="btn green"> Lista de clientes </a>
		</form>
		
	</div>
</div>

<footer>
      <span>Desenvolvido por Thiago Taveiros Pereira</span>
    </footer>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>

      <script>
      	 M.AutoInit();
      	</script>
    <script
      src="https://code.jquery.com/jquery-3.3.1.js"
      integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
      crossorigin="anonymous"
    ></script>
    <script src="main.js"></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
      integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
      integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o"
      crossorigin="anonymous"
    ></script>
    
  </body>
</html>




