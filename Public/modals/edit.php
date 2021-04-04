<div id="editModal" class="modal fade" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<div class="modal-header">
					<h4 class="modal-title">Editar Veículos</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Placa</label>
						<input id='input-placa' name='placa' type="text" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Modelo</label>
						<input type="email" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Ano</label>
						<input id='input-ano' name='ano' type="text" class="form-control" required>
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-info" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>