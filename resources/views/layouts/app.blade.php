<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/commons.js') }}"></script>
    <script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('jquery-ui/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/aux-theme.css') }}" rel="stylesheet">
</head>
 <script>
        urlPath = '{{ url("/") }}'
        _token = '{{ csrf_token() }}'
    </script>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg  navbar-dark bg-primary">
            <div class="container">
                    <a class="navbar-brand" href="{{ route('main') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

              
            </div>
        </nav>

        @yield('content')
    </div>

  
</body>
</html>
