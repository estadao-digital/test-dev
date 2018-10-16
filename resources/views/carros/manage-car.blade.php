<div class='container panel col-md-4 panel-primary'>
<div class='panel-heading text-center'>

				<h3>{{ $aView['head'] }}</h3>
				</div>
				@if(session()->has('message'))
				<div class="alert alert-success">
					{{ session()->get('message') }}
				</div>


				@elseif(session()->has('errors'))
				<div class="alert alert-danger">
					{{ session('errors')->first('message') }}
				</div>
				@endif

				@php

					$ID = isset($aView['selectCar']['ID']) ? $aView['selectCar']['ID'] : '';
					$Marca = isset($aView['selectCar']['Marca']) ? $aView['selectCar']['Marca'] : '';
					$Modelo = isset($aView['selectCar']['Modelo']) ? $aView['selectCar']['Modelo'] : '';
					$Ano = isset($aView['selectCar']['Ano']) ? $aView['selectCar']['Ano'] : '';

				@endphp

				<div class='panel-body'>
					<div class='form-group'>
						{!! Form::label('ID', '',['class' => 'form-text']) !!}
						{!! Form::text('ID', $ID,['class'=>'form-control']) !!}
						{!! Form::label('Marca', '',['class' => 'form-text']) !!}
						{!! Form::select('Marca', ['Chevrolet' => 'Chevrolet', 'Fiat' => 'Fiat', 'Honda' => 'Honda', 'Hyundai' => 'Hyundai'] ,null,['class'=>'form-control']) !!}
						{!! Form::label('Modelo', '',['class' => 'form-text']) !!}
						{!! Form::text('Modelo', $Modelo,['class'=>'form-control']) !!}
						{!! Form::label('Ano', '',['class' => 'form-text']) !!}
						{!! Form::text('Ano', $Ano,['class'=>'form-control']) !!}
					</div>
				</div>

				<div class='panel-footer panel-primary'>
					<div class='form-group'>
						@if (isset($aView['ID']))

							{{ Form::button('Editar', array('class' => 'btn btn-primary btn-warning', 'type' => 'submit', 'name' => 'edit', 'value' => 'editar', 'onClick' => '')) }}
							{{ Form::button('Deletar', array('class' => 'btn btn-primary btn-danger', 'type' => 'submit', 'name' => 'delete', 'value' => 'deletar', 'onClick' => '')) }}

						@else 	

							{{ Form::button('Criar', array('class' => 'btn btn-primary btn-success', 'type' => 'submit', 'name' => 'create', 'value' => 'criar', 'onClick' => '')) }}

						@endif
					</div>


</div>
</div>