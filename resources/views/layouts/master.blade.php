<!DOCTYPE html>
<html>
<head>

<title>App Name - @yield('title')</title>

{{ Html::style('css/bootstrap.min.css') }}
{{ Html::style('css/styles.css') }}
{{ Html::script('js/main.js') }}
{{ Html::script('js/angular.js') }}
<meta id="_token" value="{{ csrf_token() }}"> 

</head>
<body>
        @section('sidebar')
        @show


        <div id="conteudo" class='panel panel-control panel-primary'>
            @yield('content')
        </div>
</body>
