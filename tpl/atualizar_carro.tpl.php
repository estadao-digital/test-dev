<div>
	<h1 style="font-family: Arial;">Atualizar Carro</h1>
	<form class="navbar-form navbar-left new-car">
		<div class="input-group">
			<span class="input-group-addon" id="basic-addon1">ID</span>
			<input type="text" readonly="true" class="form-control input_id" value="<?php echo $dados['id'] ?>" id="id" name="id" aria-describedby="basic-addon1">
		</div>
		<div class="input-group">
			<span class="input-group-addon" id="basic-addon1">Marca</span>
			<select class="input_select" placeholder="marca" id="marca" name="marca">
				<option <?php echo $dados['marca'] == 'Fiat' ? 'selected' : ''; ?>>Fiat</option>
				<option <?php echo $dados['marca'] == 'Chevrolet' ? 'selected' : ''; ?>>Chevrolet</option>
				<option <?php echo $dados['marca'] == 'Volkswagen' ? 'selected' : ''; ?>>Volkswagen</option>
				<option <?php echo $dados['marca'] == 'Ford' ? 'selected' : ''; ?>>Ford</option>
			</select>
		</div>
		<div class="input-group">
			<span class="input-group-addon" id="basic-addon1">Modelo</span>
			<input type="text" class="form-control" aria-describedby="basic-addon1" id="modelo" name="modelo">
		</div>
		<div class="input-group">
			<span class="input-group-addon" id="basic-addon1">Ano</span>
			<input type="text" class="form-control" aria-describedby="basic-addon1" id="ano" name="ano">
		</div>
		<div class="grid-button">
			<button type="button" class="btn btn btn-success" onclick="call_ajax('POST','carros/update/','')" style="font-family: Arial;">Atualizar</button>
		</div>
	</form>
</div>