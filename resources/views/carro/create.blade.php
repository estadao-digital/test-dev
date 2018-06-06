@extends('layouts.default')

@section('content')
    <h2 class="page-title">Adicionar novo carro</h2>
    <hr>
     <form action="/carro" method="post">
     {{ csrf_field() }}
      <div class="form-group">

          {{ Form::label('marca', 'Marca') }}

          {{ Form::select('marca', [
               'Ford' => 'Ford',
               'Fiat' => 'Fiat',
               'Volkswagen' => 'Volkswagen',
               'BMW' => 'BMW'],
               null,
               ['class' => 'form-control']
          )}}

      </div>
      <div class="form-group">
        {{ Form::label('modelo', 'Modelo') }}
        {{ Form::text('modelo', null, ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('ano', 'Ano') }}
        {{ Form::text('ano', null, ['class' => 'form-control']) }}
      </div>

      <div class="form-group">
        {{ Form::label('preco', 'Preço') }}
        {{ Form::number('preco', null, ['class' => 'form-control']) }}
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
      <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
@endsection
