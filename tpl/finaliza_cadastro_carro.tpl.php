<div>
	<h1 style="font-family: Arial;">Carro cadastrado com sucesso!</h1>
	<table class="table" style="font-family: Arial;">
		<thead style="font-family: Arial;">
			<tr style="font-family: Arial;">
			<th style="font-family: Arial;">ID</th>
				<th style="font-family: Arial;">Marca</th>
				<th style="font-family: Arial;">Modelo</th>
				<th style="font-family: Arial;">Ano</th>
			</tr>
		</thead>
		<tbody style="font-family: Arial;">
			<tr style="font-family: Arial;">
				<td style="font-family: Arial;"><?php echo $dados->id ?></td>
				<td style="font-family: Arial;"><?php echo $dados->marca ?></td>
				<td style="font-family: Arial;"><?php echo $dados->modelo ?></td>
				<td style="font-family: Arial;"><?php echo $dados->ano ?></td>
			</tr>
		</tbody>
	</table>
</div>