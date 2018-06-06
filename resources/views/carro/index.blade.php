@extends('layouts.default')

@section('content')

        <div class="main-banner col-md-12">
          <h1>DEVEL. TEST</h1>
        </div>

        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Marca</th>
              <th scope="col">Modelo</th>
              <th scope="col">Ano</th>
              <th scope="col">Preço</th>
              <th scope="col">Ações</th>
            </tr>
          </thead>
          <tbody>
            @foreach($carros as $carro)
            <tr>
              <td>{{$carro->marca}}</td>
              <td>{{$carro->modelo}}</td>
              <td>{{$carro->ano}}</td>
              <td>R$ {{number_format($carro->preco, 2)}}</td>
              <td>
              <div class="btn-group" role="group" aria-label="Basic example">
                  <a href="{{ URL::to('carro/' . $carro->id . '/edit') }}">
                   <button type="button" class="btn btn-default">Alterar</button>
                  </a>&nbsp;
                  <form action="{{url('carro', [$carro->id])}}" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-danger" value="Excluir"/>
   				        </form>
              </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div id="adicionar-form" class="col-md-12">
          <a href="{{ URL::to('carro/create') }}">
           <button type="button" class="btn btn-success">ADICIONAR NOVOS CARROS</button>
          </a>
        </div>
@endsection
