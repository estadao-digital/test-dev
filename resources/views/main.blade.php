@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="panel panel-default card">
                <div class="panel-heading text-center">
                    <span class="text-success text-bordered">Carros</span>
                </div>
                <cars-component></cars-component>
            </div>
        </div>
    </div>
</div>
@endsection('content')