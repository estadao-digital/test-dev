<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    @include('partials.styles')
    
</head>

<body>

    @include('partials.menu')
    <div class="container">
        @yield('content')
    </div>
    @include('partials.scripts')
    @yield('extrascript')

</body>
        
</html>
