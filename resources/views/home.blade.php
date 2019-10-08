@extends('layouts.app')

@if(Auth::user())
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Painel</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Você esta logado!!
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@endif
