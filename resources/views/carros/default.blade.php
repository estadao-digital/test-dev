@extends('layouts.master')

@section('title', 'Carros')

@section('sidebar')
	@parent
	<div></div>
@stop

@section('content')

	{!! Form::open(array('url' => '/carros', 'method' => 'POST', 'class' => 'form-group form')) !!}
		<div class='row form-group'>

		@include('carros.manage-car')
		@include('carros.list-car')

		
		</div>
	{!! Form::close() !!}

@stop



