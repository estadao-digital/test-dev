@extends('layouts.app')
@if(Auth::user())
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Informe abaixo as informações do Carro
                        <a class="float-right btn btn-secondary" href="{{url ('cruds')}}">Listagem de Carros </a>
                    </div>
                    <div class="card-body">

                        @if (session('mensagem_sucesso'))
                            <div class="alert alert-success" role="alert">
                                {{ \Illuminate\Support\Facades\Session::get('mensagem_sucesso') }}
                            </div>
                            @endif

                            @if(Request::is('*/editar'))
                                <form method="post" action="{{ action('CrudController@atualizar', $cruds->id) }}">
                                    @csrf
                                    <form class="form-group">
                                        <a class="float-left">Marca: </a>&nbsp
                                        <select class="form-control" name="marca" autofocus>
                                                    
                                                        <option value="" @if($cruds->marca == "") selected @endif>Selecionar Marca</option>
                                                        <option value="volvo" @if($cruds->marca == "Volvo") selected  @endif >Volvo</option>
                                                        <option value="saab" @if($cruds->marca == "Saab") selected  @endif>Saab</option>
                                                        <option value="mercedes" @if($cruds->marca == "Mercedes") selected  @endif>Mercedes</option>
                                                        <option value="audi" @if($cruds->marca == "Audi") selected  @endif>Audi</option>
                                                    
                                                </select>
                                        <a class="float-left">Modelo: </a>&nbsp
                                        <input class="form-control" placeholder="Preencha este campo" name="modelo" autofocus type="text" value="{{$cruds->modelo}}">
                                        <a class="float-left">Ano: </a>&nbsp
                                        <input class="form-control" placeholder="Preencha este campo" name="ano" autofocus type="text" value="{{$cruds->ano}}">
                                        <p></p>
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                    </form>
                                    @else
                                         <form method="post" action="{{route('salvar')}}">
                                            @csrf
                                            <form class="form-group">
                                                <a class="float-left">Marca: </a>&nbsp
                                                <select class="form-control" name="marca" autofocus>
                                                    <option value="">Selecionar Marca</option>
                                                    <option value="Volvo">Volvo</option>
                                                    <option value="Saab">Saab</option>
                                                    <option value="Mercedes">Mercedes</option>
                                                    <option value="Audi">Audi</option>
                                                </select>
                                                <a class="float-left">Modelo: </a>&nbsp
                                                <input class="form-control" placeholder="Preencha este campo" name="modelo" autofocus type="text" value="">
                                                <a class="float-left">Ano: </a>&nbsp
                                                <input class="form-control" placeholder="Preencha este campo" name="ano" autofocus type="text" value="">
                                                <p></p>
                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                            </form>


                            @endif







</div>
</div>
</div>
</div>
</div>
</div>
@endsection
@endif
