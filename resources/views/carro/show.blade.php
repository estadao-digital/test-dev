@extends('layouts.default')

@section('content')
            <h1>Carro #{{ $carro->id }}</h1>

    <div class="jumbotron text-center">
            <p><strong>Marca:</strong> {{ $carro->marca }}</p>
            <p><strong>Modelo:</strong> {{ $carro->modelo }}</p>
            <p><strong>Ano:</strong> {{ $carro->ano }}</p>
            <p><strong>Preço:</strong> {{ $carro->preco }}</p>

    </div>

@endsection
