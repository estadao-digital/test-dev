<!DOCTYPE html>
<html ng-app="App">
<head>
	<title>teste PHP</title>
    <base href="/">
        <link href="./node_modules/bootstrap/dist/css/bootstrap.css" rel="stylesheet"/>
        <link href="./node_modules/bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet"/>
        <link href="./css/site.css" rel="stylesheet"/>

</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top ">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">  
                    <li><a href="./">Home</a></li>                  
                    <li><a href="./app/Marca">Marcas</a></li>
                    <li><a href="./app/Carro">Carros</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container body-content">
        <div ng-view></div>
        <hr />
    </div>
<script src="./js/vendor/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="./js/vendor/modernizr-2.8.3.min.js" type="text/javascript"></script>
<script src="./node_modules/angular/angular.js" type="text/javascript"></script>
<script src="./node_modules/angular-bootstrap/ui-bootstrap.js" type="text/javascript"></script>
<script src="./node_modules/angular-bootstrap/ui-bootstrap-tpls.js" type="text/javascript"></script>
<script src="./node_modules/angular-route/angular-route.js" type="text/javascript"></script>
<script src="./App/App.js" type="text/javascript"></script>
<script src="./App/Controllers/HomeController.js" type="text/javascript"></script>
<script src="./App/Controllers/CarroController.js" type="text/javascript"></script>
<script src="./App/Controllers/MarcaController.js" type="text/javascript"></script>
</body>
</html>


