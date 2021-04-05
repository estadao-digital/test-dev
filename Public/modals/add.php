<div id="addModal" class="modal fade" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<div class="modal-header text-white bg-success">
					<h4 class="modal-title">Adicionar Veículo</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Placa</label>
						<input type="text" id='add-placa' class="form-control" required>
					</div>
					<div class="form-group">
						<label>Marca</label>
						<select class='form-select' name='marca_id' id='add-marca'>
							
						</select>
					</div>
					<div class="form-group">
						<label>Modelo</label>
						<select class='form-select' id='add-modelo' name='modelo_id' >
							
						</select>
					</div>
					<div class="form-group">
						<label>Ano</label>
						<input type="number" id='add-ano' class="form-control" required>
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-success" value="Add">
				</div>
			</form>
		</div>
	</div>
</div>