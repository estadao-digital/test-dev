<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="{{URL::asset('css/normalize.css')}}" rel="stylesheet" type="text/css" />

    <!-- JavaScript -->
    <script src="{{URL::asset('js/vendor/modernizr-2.8.3.min.js')}}"></script>
</head>

<h1 class="title-pg">Deletar Carro</h1>

<h1 class="title-pg">Carro: <b>{{$carro->modelo}}</b></h1>

<p><b>Marca: </b>{{$carro->marca}}</p>
<p><b>Ano: </b>{{$carro->ano}}</p>

<hr>

@if(isset($errors) && count($errors) > 0) 
    <div class="alert alert-danger">
        @foreach($errors->all() as $error) 
            <p>{{$error}}</p>
        @endforeach
    </div>
@endif

<form class='form' method='post' action="{{route('carros/destroy', $carro->id)}}">
    {{ method_field('delete') }}
    {{ csrf_field() }}
    <button class='btn btn-danger'>Deletar</button>
</form>