<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- utilizando os assets scss compilados disponiveis em /resources/sass/app.scss --}}
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    {{-- utilização da biblioteca do nprogress para efeitos de loading --}}
    <link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet"/>
    <title>Carros</title>
</head>
<body>
<div>

    <div class="container w-80">
        @yield('content')
    </div>
</div>
<script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
{{-- utilizando os assets scss compilados disponiveis em /resources/js/app.js está incluso bootstrap,jquery,vue--}}
<script src="{{mix('js/app.js')}}"></script>
@yield('script')
</body>
</html>