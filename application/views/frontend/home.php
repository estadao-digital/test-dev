<div class="container site-body">		
	<div class="row">
		<div class="col-md-12" >
			<ul class="nav nav-pills" id="myTab" role="tablist">
			  <li class="nav-item">
			    <a class="nav-link active" id="lista-tab" data-toggle="tab" href="#lista" role="tab" aria-controls="lista" aria-selected="true">Lista de Carros</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" id="adicionar-tab" data-toggle="tab" href="#adicionar" role="tab" aria-controls="adicionar" aria-selected="false">Adicionar Carro</a>
			  </li>
			</ul>
			<div class="tab-content" id="myTabContent">
			  <div class="tab-pane fade show active" id="lista" role="tabpanel" aria-labelledby="lista-tab">
			  	<h2>Carros Adicionados:</h2>
				<form>
					<table class="table">
						<tr class="thead-light">
							<th scope="col">Id</th>
							<th scope="col">Marca</th>
							<th scope="col">Modelo</th>
							<th scope="col">Ano</th>
						</tr>
						<?php foreach($list_carro as $carro): ?>
							<tr>
								<td>
									<a href="<?= base_url('carro/' . $carro->intId) ?>"><?= $carro->intId ?>
								</td>
								<td>
									<?= $carro->strMarca ?>
								</td>
								<td>
									<?= $carro->strModelo ?>
								</td>
								<td>
									<?= $carro->intAno ?>
								</td> 
							</tr>
						<?php endforeach; ?>
					</table>
				</form>
				<!--- CARRO A SER EDITADO ---->
				<div class="container car_edit">		
					<div class="row">
						<div class="col-md-12" >
								<form action="<?= base_url("Home/attCarro") ?>" method="post" id="form_att">
									<div class="form-group row">
										<input class="form-control" type="hidden" name="intId">
					  					<div class="col-4">
					  						<label class="col-form-label" for="strMarca" >Marca:</label>
											<select class="form-control" name="strMarca" id="strMarca">
												<option value="HB20">HB20</option>
												<option value="Ford">Ford</option>
												<option value="Volkswagen">Volkswagen</option>
												<option value="Fiat">Fiat</option>
												<option value="Honda">Honda</option>
												<option value="BMW">BMW</option>
											</select>
										</div>
					  					<div class="col-4">
											<label class="col-form-label">Modelo:</label>
											<input class="form-control" type="text" name="strModelo" value="">
										</div>
										
					  					<div class="col-4">
											<label class="col-form-label">Ano:</label>
											<input class="form-control" type="text" name="intAno" value="">
										</div>	
									</div>
									<button id="btn_att" class="btn btn-primary" type="submit"> Atualizar </button>
									<a href="<?= base_url() ?>" class="btn btn-danger" type="submit"> Excluir </a>
								</form>	
						</div>
					</div>
				</div>

			  </div>
			  <div class="tab-pane fade" id="adicionar" role="tabpanel" aria-labelledby="adicionar-tab">
  				<h2>Adicionar Carro:</h2>
				<form action="<?= base_url('Home/addCarro') ?>" method="post" id="form_add">
					<div class="form-group row">
	  					<div class="col-4">
	  						<label class="col-form-label" for="strMarca" >Marca:</label>
							<select class="form-control" name="strMarca" id="strMarca">
								<option value="HB20">HB20</option>
								<option value="Ford">Ford</option>
								<option value="Volkswagen">Volkswagen</option>
								<option value="Fiat">Fiat</option>
								<option value="Honda">Honda</option>
								<option value="BMW">BMW</option>
							</select>
						</div>
	  					<div class="col-4">
							<label class="col-form-label">Modelo:</label>
							<input class="form-control" type="text" name="strModelo">
						</div>
						
	  					<div class="col-4">
							<label class="col-form-label">Ano:</label>
							<input class="form-control" type="text" name="intAno">
						</div>	
					</div>
					<button id="btn_add" class="btn btn-primary" type="submit"> Adicionar </button>
				</form>	
			  </div>
			</div>
		</div>
	</div>
</div>