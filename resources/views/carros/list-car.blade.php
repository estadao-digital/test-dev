<div class='container panel col-md-4 panel-primary'>
	<div class='panel-heading text-center form-group'>
		
		{{ Form::button('Atualizar Dados', array('class' => 'btn btn-primary btn-info form-group', 'type' => 'button', 'name' => 'create', 'value' => 'refresh', 'onClick' => 'location = location')) }}

		@if ($content == null) 
			Não existe registro na base de dados!
		@else
		<br>
		<div clas='form-group'>Clique em um dos ids para editar e excluir.</div>
		<br>
				<table class='table table-striped table-hover table-light' id="carrosTable" name="carrosTable">
					<thead>
						<tr>
							<td>ID</td>
							<td>Marca</td>
							<td>Modelo</td>
							<td>Ano</td>
						</tr>
					</thead>
					<tbody>
						@if(isset($aView['car']))
						@foreach($aView['car'] as $car)
							<tr>
								@foreach($car as $attrib)
								<td><a href=' @if(isset($car["ID"]))/carros/detail/{{$car["ID"]}} @endif'>{{$attrib}}</a></td>
								@endforeach
							</tr>
						@endforeach
						@endif
					</tbody>
				</table>


		@endif
	</div>
</div>			