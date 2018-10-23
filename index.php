<!doctype html>
<html class="no-js" lang="">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

    <!-- Place favicon.ico in the root directory -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/test-dev/css/normalize.css">
    <link rel="stylesheet" href="/test-dev/css/main.css">
    <link href="data:text/css;charset=utf-8," data-href="https://getbootstrap.com.br/docs/3.3/dist/css/bootstrap-theme.css" rel="stylesheet" id="bs-theme-stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.0/angular-animate.min.js"></script>
    <script src="/test-dev/js/vendor/modernizr-2.8.3.min.js"></script>

</head>

<body ng-app="app" ng-controller="carrosController" >

<div class="curtain" data-ng-show="addMode"></div>


<div class="bs-docs-header" id="content" tabindex="-1" style="">
    <div class="container">
        <h1>Cadastro de Carros</h1>
        <p>Teste de Front-end. - Kaio Luiz Marques</p>
    </div>
</div>

<div class="main container">
    <div class="row" style="">
        <div class="col-md-12">
            <p data-ng-hide="addMode"><a data-ng-click="toggleAdd()" href="javascript:;" class="btn btn-warning adicionar"><span class="glyphicons glyphicons-pencil"></span>Adicionar Novo Carro</a></p>

            <form name="addCarro" class="addCarro" data-ng-show="addMode" >
                <h3 class="mb-3 bd-text-purple-bright">Insira os dados do novo carro</h3>
                <div class="form-group">
                    <label for="cname" class="col-sm-2 control-label">Marca:</label>
                    <div class="col-sm-10">

                        <select class="form-control" name="repeatSelect" id="marca"  data-ng-model="novoCarro.marca" required>
                            <option ng-repeat="marca in marcas" value="{{marca.id}}">{{marca.nome}}</option>
                        </select>

                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-sm-2 control-label">Modelo:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="modelo" placeholder="Modelo" data-ng-model="novoCarro.modelo" required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="city" class="col-sm-2 control-label">Ano:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ano" placeholder="Ano" data-ng-model="novoCarro.ano" required />
                    </div>
                </div>
                <br />
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Add" data-ng-click="add()" data-ng-disabled="!addCarro.$valid" class="btn btn-primary" />
                        <input type="button" value="Cancel" data-ng-click="toggleAdd()" class="btn btn-primary" />
                    </div>
                </div>
                <br />
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <br />
            <br />
        </div>
    </div>

    <!-- div class="top_input_field">
        <input type="text" name="id" id="id" value="" placeholder="Digite um id" ng-model="searchText" data-ng-change="getById(this)" />
    </div -->

    <table class="table table-dark">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Marca</th>
            <th scope="col">Modelo</th>
            <th scope="col">Ano</th>
        </tr>
        </thead>
        <tbody>
        <tr ng-repeat="carro in carros ">
            <th scope="row">{{carro.id}}</th>
            <td>
                <p data-ng-hide="carro.editMode">{{ carro.marcaNome }}</p>
                <select name="repeatSelect" data-ng-show="carro.editMode"  data-ng-model="carro.marca">
                    <option ng-repeat="marca in marcas" value="{{marca.id}}">{{marca.nome}}</option>
                </select>
            </td>
            <td>
                <p data-ng-hide="carro.editMode">{{ carro.modelo }}</p>
                <input data-ng-show="carro.editMode" type="text" data-ng-model="carro.modelo" />
            </td>
            <td>
                <p data-ng-hide="carro.editMode">{{ carro.ano }}</p>
                <input data-ng-show="carro.editMode" type="text" data-ng-model="carro.ano" />
            </td>
            <td>
                <p data-ng-hide="carro.editMode"><a data-ng-click="toggleEdit(carro)" href="javascript:;">Edit</a> | <a data-ng-click="deletecustomer(carro)" href="javascript:;">Delete</a></p>
                <p data-ng-show="carro.editMode"><a data-ng-click="save(carro)" href="javascript:;">Save</a> | <a data-ng-click="toggleEdit(carro)" href="javascript:;">Cancel</a></p>
            </td>
        </tr>
        </tbody>
    </table>
    <div id="mydiv" data-ng-show="loading">
        <img src="/test-dev/imagens/ajax-loader.gif" class="ajax-loader" />
    </div>


    <div class="alert alert-success" data-ng-show="success">
        <strong>Successo!</strong> {{successMessage}}
    </div>

    <div class="alert alert-danger" data-ng-show="error">
        <strong>Erro!</strong> {{errorMessage}}
    </div>



</div>

<script src="/test-dev/js/main.js"></script>
</body>

</html>