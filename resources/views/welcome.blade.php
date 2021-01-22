@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @livewire('cars')
            </div>
        </div>
    </div>
@endsection
