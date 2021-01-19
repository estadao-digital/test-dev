@extends('layout.app')
@section('title', 'Listando todos os registros')
 
@section('content')
<h1>Listagem de Clientes</h1>
<hr>
<div class="container">
    <table class="table table-bordered table-striped table-sm">
        <thead>
      <tr>
          <th>#</th>
          <th>ID</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Ano</th>
          <th>
        <a href="{{ route('add-carros') }}" class="btn btn-info btn-sm" >Novo</a>
          </th>
      </tr>
        </thead>
        <tbody>
      @forelse($cars as $car)
      <tr>
          <td>{{ $car->id }}</td>
          <td>{{ $car->marca }}</td>
          <td>{{ $car->modelo }}</td>
          <td>{{ $car->ano }}</td>
          <td>
        <a href="{{ edit-carros, ['id' => $car->id]) }}" class="btn btn-warning btn-sm">Editar</a>
        <form method="POST" action="{{ route('car.destroy', ['id' => $car->id]) }}" style="display: inline" onsubmit="return confirm('Deseja excluir este registro?');" >
            @csrf
            <input type="hidden" name="_method" value="delete" >
            <button class="btn btn-danger btn-sm">Excluir</button>
        </form>
          </td>
      </tr>
      @empty
      <tr>
          <td colspan="6">Nenhum registro encontrado para listar</td>
      </tr>
      @endforelse
        </tbody>
    </table>
</div>
@endsection