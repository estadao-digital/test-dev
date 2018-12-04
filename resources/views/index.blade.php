@extends('layouts.web')

@section('title', 'Teste Dev Estadão')
@section('content')

    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="#">
            Teste Dev Estadão
        </a>
    </nav>

    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h3>Cadastro de carros</h3>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div id="table-div">
                        <table id="table" class="table table-hover table-sm">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('modal')
    @push('scripts')
        <script src="js/script.js"></script>
    @endpush
@endsection
