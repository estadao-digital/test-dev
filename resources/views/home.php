<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teste dos Carros</title>
</head>

<body>
    <div id="AppVue">
        <hr>
        <hr>

        <div  class="container">
            <h1>Lista de Carros</h1>
            <button class="btn btn-success" data-toggle="modal" data-target="#salvarModal">Adicionar</button>
            <p style="color: #00a;" v-if="cars.loading">Carregando...</p>
            <div v-else>
                <p style="color: #aa0;" v-if="!cars.list.length">Nenhum carro encontrado</p>
                <div v-else>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Modelo</th>
                            <th>Marca</th>
                            <th>Ano</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="car in cars.list">
                            <td>{{ car.id }}</td>
                            <td>{{ car.modelo }}</td>
                            <td>{{ car.marca }}</td>
                            <td>{{ car.ano }}</td>
                            <td>
                                <button data-toggle="modal" data-target="#editarModal" class="btn btn-secondary" @click.prevent="selectCar(car)"><span class="glyphicon glyphicon-pencil"></span></button>
                                <button class="btn btn-danger" @click.prevent="removeCar(car.id)"><span class="glyphicon glyphicon-trash"></span></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php include_once('includes/modalSalvar.html') ?>
            <?php include_once('includes/modalEditar.html') ?>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="js/home.js"></script>
</body>
</html>