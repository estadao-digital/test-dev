@extends('layouts.default')

@section('content')
    <h2 class="page-title">Editar Carro</h2>
    <hr>
     <form action="{{url('carro', [$carro->id])}}" method="POST">
     <input type="hidden" name="_method" value="PUT">
     {{ csrf_field() }}
     <div class="form-group">
       {{ Form::label('marca', 'Marca') }}

       {{ Form::select('marca', [
            'Ford' => 'Ford',
            'Fiat' => 'Fiat',
            'Volkswagen' => 'Volkswagen',
            'BMW' => 'BMW'],
            $carro->marca,
            ['class' => 'form-control']
       )}}
     </div>
      <div class="form-group">
        {{ Form::label('modelo', 'Modelo') }}
        {{ Form::text('modelo', $carro->modelo, ['class' => 'form-control']) }}
      </div>
      <div class="form-group">
        {{ Form::label('ano', 'Ano') }}
        {{ Form::text('ano', $carro->ano, ['class' => 'form-control']) }}
      </div>
      <div class="form-group">
        {{ Form::label('preco', 'Preço') }}
        {{ Form::number('preco', $carro->preco, ['class' => 'form-control']) }}
      </div>
      @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif
      <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
@endsection
