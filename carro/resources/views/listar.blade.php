@extends('app')

@section('title', 'Listagem de carros')

@section('content')
<h1>Listagem de Carros</h1>
    <hr>
    @include('menu')
    <hr>
    <div class="content">
        <table class="table table-hover">
            <thead>
                <th scope="col">Marca</th>
                <th scope="col">Modelo</th>
                <th scope="col">Ano</th>
                <th scope="col" width="100">Ação</th>
                <th scope="col" width="100">Ação</th>
            </thead>
            <tbody>
                @if (isset($carros))
                @foreach($carros as $carro)
                    <tr>
                        <td>{{ $carro->marca}}</td>
                        <td>{{ $carro->modelo}}</td>
                        <td>{{ $carro->ano}}</td>
                        <td>
                            <form action="{{ route('carros.edit', $carro->id) }}" method="post">
                                @csrf
                                @method('GET')
                                <div class="form-group mx-sm-3 mb-2">
                                  <button type="submit" class="btn btn-success">Editar</button>
                                </div>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('carros.destroy', $carro->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                      
                                <div class="form-group mx-sm-3 mb-2">
                                  <button type="submit" class="btn btn-danger">Apagar</button>
                                </div>
                              </form>
                        </td>
                    </tr>
                @endforeach
                @endif
                
            </tbody>
        </table>
        {!! $carros->links() !!}
        
    </div>

@endsection