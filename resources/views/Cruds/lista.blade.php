@extends('layouts.app')
@if(Auth::user())
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Carros
                        <a class="float-right btn btn-success" href="{{url ('cruds/novo')}}">Novo Carro </a>
                        
                    </div>
                    <div class="card-body">
                        @if (session('mensagem_sucesso'))
                            <div class="alert alert-success" role="alert">
                                {{ \Illuminate\Support\Facades\Session::get('mensagem_sucesso') }}
                            </div>
                        @endif

                        <table class="table">
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Ano</th>
                            <th>Ações</th>
                            <tdbody>
                                @foreach($cruds as $cruds)
                                <tr>
                                    <td>{{$cruds->marca}}</td>
                                    <td>{{$cruds->modelo}}</td>
                                    <td>{{$cruds->ano}}</td>
                                    <td>
                                        <a href="cruds/{{$cruds->id}}/editar" class="btn btn-primary btn-sm">Editar</a>

                                        <form method="post" style="display: inline" action="{{ action('CrudController@deletar', $cruds->id) }}">
                                            @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                                    @endforeach
                            </tdbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@endif
