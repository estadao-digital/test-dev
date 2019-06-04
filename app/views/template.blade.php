<!DOCTYPE html>
<html lang="pt-BR" dir="ltr">
  <head>
    <meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ trans('application.config.name') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-table/css/bootstrap-table.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/_style.css') }}">

    @yield('CSS')
  </head>

  <body>

    <div class="header">

      <nav class="navbar fixed-top navbar-expand-md">

        <a class="navbar-brand home-btn"><i class="fa fa-home"></i><b> {{ trans('application.config.name') }}</b></a>

      </nav>

    </div>

    <div class="card border-success content">

      @yield('CONTENT')

    </div>

    <div id="modais">

      @include('carros/modais/_modal-create')

      @include('carros/modais/_modal-edit')

      @include('carros/modais/_modal-delete')

      @include('carros/modais/_modal-error')

    </div>

    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-table/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-table/js/bootstrap-table-locale-all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/$_main.js') }}"></script>
    <script src="{{ asset('assets/js/$_table.js') }}"></script>

    @yield('SCRIPTS')
  </body>
</html>
