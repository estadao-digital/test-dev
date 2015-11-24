<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script> var BASE_URL = '<?php echo BASE_URL; ?>';</script>
    </head>
    <body>

        <?php require_once(APP_DIR . DS . 'views' . DS . 'header.php') ?>

        <div class='container-fluid'>
            <div id='content-wrapper'>
                <div class='container'>
                    <div id="main" class="container-fluid">
                        <h3 class="page-header">Meu Registros de carros</h3>
                        <div class="col-md-7">

                            <div id="content">
                                <div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Ano</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody id='tbody-cars'>
                                            <?php foreach ($car_list as $carro): ?>
                                                <tr data-id="<?php echo $carro->id; ?>">
                                                    <td><?php echo $carro->id; ?></td>
                                                    <td><?php echo $carro->marca; ?></td>
                                                    <td><?php echo $carro->modelo; ?></td>
                                                    <td><?php echo $carro->ano; ?></td>
                                                    <td>
                                                        <a href="javascript:void(0);" onclick="removeCar(<?php echo $carro->id; ?>)"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a> |  <a href="javascript:void(0);" onclick="showEditForm(this)" data-id='<?php echo $carro->id ?>' data-marca='<?php echo $carro->marca ?>' data-modelo='<?php echo $carro->modelo ?>' data-ano='<?php echo $carro->ano ?>'><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-5">
                            <div class="panel panel-default">

                                <div class="panel-heading">Criar/Atualizar </div>
                                <div class="panel-body" id="content-form">
                                    <form action="<?php echo BASE_URL . '/carros' ?>" method="POST" id='form-cars'>
                                        <input type='hidden' id='id_car' value='' name='id' />
                                        <div class="form-group">
                                            <label for="ano">Ano:</label>
                                            <input type="text" class="form-control" id="ano" maxlength="4" name='ano'>
                                        </div>
                                        <div class="form-group">
                                            <label for="marca">Marca:</label>
                                            <select name="marca" class='form-control' id='marca'>
                                                <option value=''>Selecionar Marca</option>
                                                <option value='Fiat'>Fiat</option>
                                                <option value='Ford'>Ford</option>
                                                <option value='Chevrolet'>Chevrolet</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label >Modelo:</label>
                                            <input type="text" class="form-control" id="modelo"  name='modelo'>
                                        </div>
                                        
                                        <button type="button" onclick="saveOrUpdate()" class="btn btn-default">Enviar</button>
                                        <button type="reset" onclick="jQuery('#form-cars').attr('METHOD','POST');jQuery('#id_car').val('');" class="btn btn-default">Limpar</button>
                                    </form>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.3.min.js"><\/script>')</script>
            <script src="js/main.js"></script>
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


    </body>
</html>
