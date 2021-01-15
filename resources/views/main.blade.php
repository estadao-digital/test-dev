<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico in the root directory -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
    <link rel="stylesheet" href="/assets/main.css">
</head>
<body>
    <div class="row">
        <div class="cell" style="flex: 4">
            <div id="list">
                <table style="width: 100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Ano</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody id="list-body">

                    </tbody>
                </table>
            </div>
        </div>
        <div class="cell mobile-full">
            <div id="form-edit" style="display: none">
                <h4>Editar Carro</h4>
                <input type="hidden" name="id">
                <div class="input">
                    <label for="marca">Marca</label>
                    <select name="marca" id="marca">
                        <option value="Ford">Ford</option>
                        <option value="GM">GM</option>
                        <option value="VW">VW</option>
                        <option value="Porsche">Porsche</option>
                    </select>
                </div>
                <div class="input">
                    <label for="modelo">Modelo</label>
                    <input type="text" name="modelo">
                </div>
                <div class="input">
                    <label for="ano">Ano</label>
                    <input type="number" min="1900" max="2040" name="ano">
                </div>
                <button type="button" id="edit-bt" onclick="App.edit.form.submit()">Editar</button>
            </div>
            <div id="form-create" style="">
                <h4>Criar Novo Carro</h4>
                <div class="input">
                    <label for="marca">Marca</label>
                    <select name="marca" id="marca">
                        <option value="Ford">Ford</option>
                        <option value="GM">GM</option>
                        <option value="VW">VW</option>
                        <option value="Porsche">Porsche</option>
                    </select>
                </div>
                <div class="input">
                    <label for="modelo">Modelo</label>
                    <input type="text" name="modelo">
                </div>
                <div class="input">
                    <label for="ano">Ano</label>
                    <input type="number" min="1900" max="2040" name="ano">
                </div>

                <button type="button" id="save" onclick="App.create.submit()">Criar</button>
            </div>
        </div>
    </div>
<script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>
<script src="/assets/main.js"></script>
</body>

</html>


<?php
//dd(\App\Models\JsonService::load());
