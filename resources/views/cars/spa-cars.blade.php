@extends('layouts.app')

@section('content')
    <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center">
        <h1 class="text-white display-4">Cadastro de Carros</h1>

        <car-component></car-component>
    </div>
@endsection

{{--<script src="{{ url(mix('js/app.js')) }}" defer></script>--}}
{{--<link href="{{ url(mix('css/app.css')) }}" rel="stylesheet">--}}

{{--<div id="app">--}}
{{--    <example-component></example-component>--}}
{{--    <car-component></car-component>--}}
{{--</div>--}}

