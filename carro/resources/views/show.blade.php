@extends('app')

@section('title', "Detalhe do Carro {$carro->marca}")

@section('content')
<h1>Listagem de Carros</h1>
    <hr>
    @include('menu')
    <hr>
    <div class="content">

<h1>Carro {{ $carro->marca }} - {{ $carro->modelo }}</h1>

<table class="table table-hover">
  <thead>
      <th scope="col">Marca</th>
      <th scope="col">Modelo</th>
      <th scope="col">Ano</th>
      <th scope="col" width="100">Ação</th>
  </thead>
  <tbody>
    <tr>
      <td class="form-group mx-sm-3 mb-2">{{ $carro->marca }}</td>
      <td class="form-group mx-sm-3 mb-2">{{ $carro->modelo }}</td>
      <td class="form-group mx-sm-3 mb-2">{{ $carro->ano }}</td>
      <td class="form-group mx-sm-3 mb-2">
        <form action="{{ route('carros.destroy', $carro->id) }}" method="post">
          @csrf
          @method('DELETE')

          <div class="form-group mx-sm-3 mb-2">
            <button type="submit" class="btn btn-danger">Apagar</button>
          </div>
        </form>
      </td>
    </tr>
  </tbody>
</table>



@endsection