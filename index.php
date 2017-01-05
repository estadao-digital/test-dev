<?php
	function __autoload($class_name){
		require_once 'classes/' . $class_name . '.php';
	}
?>

<!DOCTYPE HTML>
<html land="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>Teste</title>
  <meta name="description" content="Teste Estadão" />
  <meta name="robots" content="index, follow" />
   <link rel="stylesheet" href="css/bootstrap.css" />
  <link rel="stylesheet" />
</head>
<body>

	<div class="container">

		<?php
	
		$carro = new Carros();
		$date = new FormatarData();

		if(isset($_POST['cadastrar'])):

			$marca  = $_POST['marca'];
			$modelo = $_POST['modelo'];
			$ano = $_POST['ano'];
			$carro->setmarca($marca);
			$carro->setmodelo($modelo);
			
			$carro->setano( FormatarData::formatar($ano) );

			# Insert
			if($carro->insert()){
				echo "Inserido com sucesso!";
			}

		endif;

		?>
		<header class="masthead">
			<h1 class="muted">Teste Estadão</h1>
			<nav class="navbar">
				<div class="navbar-inner">
					<div class="container">
						<ul class="nav">
							<li class="active"><a href="index.php">Página inicial</a></li>
						</ul>
					</div>
				</div>
			</nav>
		</header>

		<?php 
		if(isset($_POST['atualizar'])):

			$id = $_POST['id'];
			$marca = $_POST['marca'];
			$modelo = $_POST['modelo'];
			$ano = trim($_POST['ano']);
			$carro->setmarca($marca);
			$carro->setmodelo($modelo);

			$carro->setano( FormatarData::formatar($ano) );

			if($carro->update($id)){
				echo "Atualizado com sucesso!";
			}

		endif;
		?>

		<?php
		if(isset($_GET['acao']) && $_GET['acao'] == 'deletar'):

			$id = (int)$_GET['id'];
			if($carro->delete($id)){
				echo "Deletado com sucesso!";
			}

		endif;
		?>

		<?php
		if(isset($_GET['acao']) && $_GET['acao'] == 'editar'){

			$id = (int)$_GET['id'];
			$resultado = $carro->find($id);
		?>

		<form method="post" action="">

			<div class="input-prepend">
				<input type="text" name="marca" value="<?php echo $resultado->marca; ?>" placeholder="Marca" />
			</div>

			<div class="input-prepend">
				<input type="text" name="modelo" value="<?php echo $resultado->modelo; ?>" placeholder="Modelo" />
			</div>

			<div class="input-prepend">
				<input type="date" name="ano" value="<?php echo $resultado->ano; ?>" placeholder="Ano" />
			</div>

			<input type="hidden" name="id" value="<?php echo $resultado->id; ?>">

			<br />

			<input type="submit" name="atualizar" class="btn btn-primary" value="Atualizar dados">					
		</form>

		<?php }else{ ?>


		<form method="post" action="">

			<div class="input-prepend">
				<input type="text" name="marca" placeholder="Marca" />
			</div>

			<div class="input-prepend">
				<input type="text" name="modelo" placeholder="Modelo" />
			</div>

			<div class="input-prepend">
				<input type="date" name="ano" placeholder="Ano" />
			</div>

			<br />
			<input type="submit" name="cadastrar" class="btn btn-primary" value="Cadastrar Carro">					
		</form>

		<?php } ?>

		<table class="table table-hover">
			
			<thead>
				<tr>
					<th>#</th>
					<th>Marca</th>
					<th>Modelo</th>
					<th>Ano</th>
					<th>Ações</th>
				</tr>
			</thead>
			
			<?php foreach($carro->findAll() as $key => $value): ?>

			<tbody>
				<tr>
					<td><?php echo $value->id; ?></td>
					<td><?php echo $value->marca; ?></td>
					<td><?php echo $value->modelo; ?></td>
					<td><?php echo substr( $value->ano, 0, 4 ); ?></td>
					<td>
						<?php echo "<a href='index.php?acao=editar&id=" . $value->id . "'>Editar</a>"; ?>
						<?php echo "<a onclick='confirmacao(".$value->id.")'>Deletar</a>"; ?>
					</td>
				</tr>
			</tbody>

			<?php endforeach; ?>

		</table>

	</div>

<script src="js/jQuery.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/geral.js"></script>
</body>
</html>