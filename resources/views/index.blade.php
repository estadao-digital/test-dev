@extends('layout.app', ["current" => "home"])

@section('body')

<div class="jumbotron bg-light border border-secondary">
    <div class="row">
        <div class="card-deck">
            <div class="card border border-primary">
                <div class="card-body">
                    <h5 class="card-title">Cadastro de Veículos</h5>
                    <p class="card=text">
                        Aqui você visualiza os veículos cadastrados.
                    </p>
                    <a href="/carros" class="btn btn-primary">Veículos</a>
                </div>
            </div>
            <div class="card border border-primary">
                <div class="card-body">
                    <h5 class="card-title">Cadastro de Veículos</h5>
                    <p class="card=text">
                        Cadastre as marcas dos seus veiculos
                    </p>
                    <a href="/marcas" class="btn btn-primary">Adicione as marcas</a>
                </div>
            </div>            
        </div>
    </div>
</div>

@endsection