@extends('app')

@section('title', "Edição do Carro {$carro->marca}")

@section('content')
<h1>Edição de Carros</h1>
    <hr>
    @include('menu')
    <hr>

    @if ($errors->any())
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif

<div class="content">
      <table class="table table-hover">
        <thead>
            <th scope="col">Marca</th>
            <th scope="col">Modelo</th>
            <th scope="col">Ano</th>
            <th scope="col" width="50">Editar</th>
        </thead>
        <tbody>
            <form action="{{ route('carros.update', $carro->id) }}" method="post">
                @method('PUT')
                @csrf
                <tr>
                  <td>
                    <select class="custom-select" name="marca">
                      @foreach($carros as $carro)
                          <option value="{{ $carro->marca }}">{{ $carro->marca }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td><input type="text" class="form-control" name="modelo" placeholder="Modelo: " value="{{ $carro->modelo }}"></td>
                  <td> <input type="text" class="form-control" name="ano" placeholder="Ano: " value="{{ $carro->ano }}"></td>
                  <td><button type="submit" class="btn btn-primary mb-2">Enviar</button></td>
                </tr>
               
            </form>
        </tbody>
    </table>
</div>

@endsection