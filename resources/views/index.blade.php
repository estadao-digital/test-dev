@extends('layout.default')

@section('title', 'Test-dev')

@section('content')
    
    @include('carros')
    <hr>
    @include('doc')
    <hr>
    @include('autor')

@endsection