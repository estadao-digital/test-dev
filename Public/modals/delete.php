<div id="deleteModal" class="modal fade" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id='deleteForm'>
				<div class="modal-header text-white bg-danger">
					<h4 class="modal-title">Apagar Veículo</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
				</div>
				<div class="modal-body">
					<p>Tem certeza de que vai apagar o veículo <br><span id='span-placa' class='fw-bold'></span></p>
					<p class="text-warning"><small>Esta operação não poderá ser desfeita.</small></p>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-danger" value="Delete">
				</div>
			</form>
		</div>
	</div>
</div>