<div>
	<h1 style="font-family: Arial;">Carros Cadastrados</h1>
	<table class="table sortable" style="font-family: Arial;">
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
			<?php }else
			 foreach ($dados as $carro) { 
			 	?>
				<tr style="font-family: Arial;">

					<td style="font-family: Arial;"><?php echo $carro['id'] ?></td>
					<td style="font-family: Arial;"><?php echo $carro['marca'] ?></td>
					<td style="font-family: Arial;"><?php echo $carro['modelo'] ?></td>
					<td style="font-family: Arial;"><?php echo $carro['ano'] ?></td>
					<td style="font-family: Arial;">
						<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#deleteModal" onclick="sendIdModal(<?php echo $carro['id'] ?>)">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</button>
						<button type="button" class="btn btn-default btn-xs">	
							<span class="glyphicon glyphicon-pencil" aria-hidden="true" onclick="call_ajax('GET','carros/atualizar',<?php echo $carro['id'] ?>)"></span>
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
        Ao clicar sim você excluira o carro nº <?php echo $carro['id'] ?>!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button id="confirm-del" type="button" class="btn btn-primary" data-dismiss="modal">Sim</button>
      </div>
    </div>
  </div>
</div>