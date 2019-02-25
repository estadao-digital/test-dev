<?php 
include_once 'php_action/db_connect.php';

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

  <body class="r">
    <header class="logo">
      <div class="container-fluid " style="padding:0px;">
        <div class="container">
          <h1>Logotipo</h1>
        </div>
      </div>
    </header>

    <main class="container">
      <div class="wrap">
        <h1>CRUD - INSERT, UPDATE E DELETE</h1>
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Marca</th>
              <th scope="col">Modelo</th>
              <th scope="col">Ano</th>
              <th scope="col">Editar</th>
              <th scope="col">Deletar</th>
            </tr>
          </thead>
          <tbody>
            <?php
          				$sql = "SELECT * FROM carros";
          				$resultado = mysqli_query($connect, $sql);
                         
                          if(mysqli_num_rows($resultado) > 0):
          
          				while($dados = mysqli_fetch_array($resultado)):
          				?>
            <tr>
              <td><?php echo $dados['marca']; ?></td>
              <td><?php echo $dados['modelo']; ?></td>
              <td><?php echo $dados['ano']; ?></td>
              <td><a href="editar.php?id=<?php echo $dados['id']; ?>" class="btn-floating orange"><i
                    class="material-icons">edit</i></a></td>
          
              <td><a href="#modal<?php echo $dados['id']; ?>" class="btn-floating red modal-trigger"><i
                    class="material-icons">delete</i></a></td>
          
              <!-- Modal Structure -->
            <div id="modal<?php echo $dados['id']; ?>" class="modal" style="width:50%;height:auto;">
                <div class="modal-content">
                  <h4>Opa!</h4>
                  <p>Tem certeza que deseja excluir esse cliente?</p>
                </div>
                <div class="modal-footer">
          
                  <form action="php_action/delete.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">
                    <button type="submit" name="btn-deletar" class="btn red">Sim, quero deletar</button>
          
                    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
          
                  </form>
                  
          
                </div>
              </div>
          
          
            </tr>
            <?php 
          				endwhile;
          				else: ?>
          
            <tr>
              <td>-</td>
              <td>-</td>
              <td>-</td>
              <td>-</td>
            </tr>
          
            <?php 
          				endif;
          			   ?>
          
          </tbody>
        </table>
        		<a href="adicionar.php" class="btn">Adicionar cliente</a>
      </div>
    </main>

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
