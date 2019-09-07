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

<h1 class="title-pg">Listagem de Carros</h1>

@if(isset($message) > 0 || Session::get('message'))
    <div class="alert alert-success">
        @if(isset($message) && count($message) > 0)
            @foreach($message->all() as $msn) 
                <p>{{$msn}}</p>
            @endforeach
        @else
            <p>{{Session::get('message')}}</p>
        @endif
    </div>
@endif

<a href="{{route('carros/create')}}" class="btn btn-primary btn-add">
    Cadastrar
</a>

</p>

<table class="table table-striped">
    <tr>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Ano</th>
        <th width="100px">Ações</th>
    </tr>
    @foreach($carros as $carro) 
    <tr>
        <td>{{$carro->marca}}</td>
        <td>{{$carro->modelo}}</td>
        <td>{{$carro->ano}}</td>
        <td>
            <a href="{{route('carros/edit', $carro->id)}}">
                <img src="{{asset('imagens/alterar.png')}}">
            </a>
            <a href="{{route('carros/show', $carro->id)}}">
                <img src="{{asset('imagens/visualizar.png')}}">
            </a>
        </td>
    </tr>
    @endforeach
    <tfoot>
        <tr>
            <td colspan='5' id="center">{{$carros->links()}}</td>
        </tr>
    </tfoot>
</table>
</html>