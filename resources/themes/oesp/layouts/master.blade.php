<!DOCTYPE html>
<html ng-app="TestDev">
    <head>
@include('partials.head')
    </head>
    <body class="hold-transition skin-green sidebar-mini">
        <div class="wrapper">
@include('partials.header')
@include('partials.sidebar')
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {{ $breadcrumb['first'] }}
                        <small>{{ $breadcrumb['second'] }}</small>
                    </h1>
                </section>
                <!-- Main content -->
                <section class="content">
@yield('content')
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
@include('partials.footer')
@include('partials.sidebarctrl')
        </div>
        <!-- ./wrapper -->
        <!-- REQUIRED JS SCRIPTS -->
        <!-- angular -->
        <script src="{{ asset('js/angular/angular.min.js') }}"></script>
        <script src="{{ asset('js/angular/angular-route.min.js') }}"></script>
        <!-- jQuery 2.2.3 -->
        <script src="{{ asset('bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="{{ asset('bower_components/AdminLTE/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('bower_components/AdminLTE/dist/js/app.min.js') }}"></script>
    </body>
</html>
