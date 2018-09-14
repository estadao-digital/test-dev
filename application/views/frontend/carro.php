<div class="container site-body">		
	<div class="row">
		<div class="col-md-12" >
			<?php foreach($list_carro as $carro): ?>
				<form action="<?= base_url('Home/attCarro') ?>" method="post">
					<div class="form-group row">
						<input class="form-control" type="hidden" name="intId" value="<?= $carro->intId ?>">
	  					<div class="col-4">
	  						<label class="col-form-label">Marca:</label>
							<input class="form-control" type="text" name="strMarca" value="<?= $carro->strMarca ?>">
						</div>
	  					<div class="col-4">
							<label class="col-form-label">Modelo:</label>
							<input class="form-control" type="text" name="strModelo" value="<?= $carro->strModelo ?>">
						</div>
						
	  					<div class="col-4">
							<label class="col-form-label">Ano:</label>
							<input class="form-control" type="text" name="intAno" value="<?= $carro->intAno ?>">
						</div>	
					</div>
					<button class="btn btn-primary" type="submit"> Atualizar </button>
					<a href="<?= base_url('carro/delete/' . $carro->intId)?>" class="btn btn-danger" type="submit"> Excluir </a>
				</form>	
			<?php endforeach; ?>
		</div>
	</div>
</div>