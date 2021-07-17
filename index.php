<!doctype html>

<html lang="pt-br">

<head>
    <meta charset="utf-8">

    <title>Meus Carros</title>
    <meta name="description" content="Meus Carros">
    <meta name="author" content="Raul Ferreira de Oliveira Neto">

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/ripplebutton.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="js/main.js"></script> 

</head>

<body>

    <div class="main">
        <div class="card" id="cardMain">
            <div class="card-header" id="mainheader">
                <div class="card-heading">
                    <h2>Meus Carros</h2>
                </div>
            </div>

            <div class="card-body">
                    <table id="tableCarros" class="table table-bordered">
                        <caption>Lista de Carros</caption>
                        <thead>
                            <tr>
                                <th scope="col">Modelo</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Ano</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
            </div>
        </div>

        <div class="card"  style="display:none;" id="cardAdd">
            <div class="card-header">
                <h2 id="cardAddText" >Adicionar Carro</h2>
                <span id="cardAddBack" class="close"> &#x2715; </span>
            </div>

            <div class="card-body">
                <div class="form">
                    <div class="form-group">
                        <label for="modelo">Modelo </label>
                        <input name="modelo" autocomplete="off" />
                    </div>
                    <div class="form-group">
                        <label for="marca">Marca </label>
                        <select name="marca">
                            <option value="Audi" selected>Audi</option>
                            <option value="BMW" >BMW</option>
                            <option value="Chevrolet" >Chevrolet</option>
                            <option value="Fiat">Fiat</option>
                            <option value="Ford">Ford</option>
                            <option value="Honda">Honda</option>
                            <option value="Hyundai">Hyundai</option>
                            <option value="Kia">Kia</option>
                            <option value="Nissan">Nissan</option>
                            <option value="Mercedes-Benz">Mercedes-Benz</option>
                            <option value="Toyota">Toyota</option>
                            <option value="Volkswagen">Volkswagen</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ano">Ano</label>
                        <input name="ano" autocomplete="off" />
                    </div>
                 </div>
            </div>
            <div class="card-footer">
                <button type="button" id="modalButton" style="width:100%; " class="ripple">Salvar</button>
            </div>
        </div>


    </div>
</body>

</html>