<div>
	<h1 style="font-family: Arial;">Buscar Carro</h1>
	<form class="navbar-form navbar-left new-car" onsubmit="return false">
		<div class="input-group">
			<span class="input-group-addon" id="basic-addon1">ID</span>
			<input type="text" class="form-control input_id" id="id" name="id" aria-describedby="basic-addon1" name="busca_id" required>
		</div>
			<button type="button" class="btn btn-default btn-busca" style="font-family: Arial;" onclick="search_car(document.getElementById('id').value)"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
			</button>
	</form>


		<table class="table" style="font-family: Arial;">
		<thead style="font-family: Arial;">
			<tr style="font-family: Arial;">
			<th style="font-family: Arial;">ID</th>
				<th style="font-family: Arial;">Marca</th>
				<th style="font-family: Arial;">Modelo</th>
				<th style="font-family: Arial;">Ano</th>
				<th style="font-family: Arial;">Excluir/Editar</th>
			</tr>
		</thead>
		<tbody style="font-family: Arial;">
			<?php 
			if($dados == FALSE){ ?>
				<tr style="font-family: Arial;">
					<td style="font-family: Arial;">Nenhum carro cadastrado!</td>
				</tr>	
			<?php }elseif ($dados != "home_buscar"){ ?>
				<tr style="font-family: Arial;">

					<td style="font-family: Arial;"><?php echo $dados['id'] ?></td>
					<td style="font-family: Arial;"><?php echo $dados['marca'] ?></td>
					<td style="font-family: Arial;"><?php echo $dados['modelo'] ?></td>
					<td style="font-family: Arial;"><?php echo $dados['ano'] ?></td>
					<td style="font-family: Arial;">
						<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#deleteModal" onclick="sendIdModal(<?php echo $dados['id'] ?>)">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</button>
						<button type="button" class="btn btn-default btn-xs">	
							<span class="glyphicon glyphicon-pencil" aria-hidden="true" onclick="call_ajax('GET','carros/atualizar',<?php echo $dados['id'] ?>)"></span>
						</button>
					</td>
				</tr>
				<?php } ?>
		</tbody>
	</table>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Você está certo disso?</h4>
      </div>
      <div class="modal-body">
        Ao clicar sim você excluira o carro nº <?php echo $dados['id'] ?>!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="confirm-del" type="button" class="btn btn-primary" data-dismiss="modal">Sim</button>
      </div>
    </div>
  </div>
</div>