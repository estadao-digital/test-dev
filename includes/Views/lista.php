<div class="content">

	<div class="center">
		<table class="clean" cellspacing="0" cellpadding="0">
			<thead><tr><th>ID</th><th style="width: 35%;">Modelo</th><th>Ano</th><th style="width: 35%;">Marca</th><th style="width: 14%;"></th></tr></thead>
			<tbody>
			<?php echo $data['lista_carros']; ?>
			</tbody>
		</table>
		<button type="button" onclick="montarNovoTr()" class="button button-3d button-green button-mini" title="Criar" style="height: 41px;"><i class="fa fa-plus" aria-hidden="true"></i> Cadastrar</button>
	</div>

</div>