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

<h1 class="title-pg">Gerenciar Carros</h1>

@if(isset($errors) && count($errors) > 0) 
    <div class="alert alert-danger">
        @foreach($errors->all() as $error) 
            <p>{{$error}}</p>
        @endforeach
    </div>
@endif

@if(isset($carro)) {{--Alterar--}}
    <?php 
        $route  = route('carros/update', $carro->id);
    ?>
@else {{--Incluir--}}
    <?php 
        $route  = route('carros/store');
    ?>
@endif

<form class='form' method='post' action="{{$route}}">
    @if(isset($carro)) {{--Alterar--}}
        {!! method_field('put') !!}
    @endif

    {!! csrf_field() !!}
    
    <div class='form-group'>
        <select name='marca' class='form-control'>
            <option style='color:red'>Escolha a Marca</option>
            @foreach($marcas as $marca)
                <option value='{{$marca}}' 
                @if(isset($carro->marca) == $marca) ?? old('marca') 
                    selected
                @endif
                >{{$marca}}</option>
            @endforeach
        </select>
    </div>
    <div class='form-group'>
        <input type='text' name='modelo' value='{{isset($carro->modelo) ? $carro->modelo : old('modelo')}}' placeholder='Modelo: ' class='form-control'>
    </div>
    <div class='form-group'>
        <input type='text' name='ano' value='{{isset($carro->ano) ? $carro->ano : old('ano')}}' placeholder='Ano: ' class='form-control'>
    </div>
    <button class='btn btn-primary'>Enviar</button>
</form>
</html>