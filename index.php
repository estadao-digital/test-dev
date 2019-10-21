<?php
    include('config.php');
    echo '<script>window.localStorage.setItem("token","3DFTaNupO5WSV142LxeiXgcZfOmWazto5pqN46rcNrsbCaRQrAt1BtD2xJyrIJkn");</script>';
    
?>

<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Seja Bem Vindo(a)!</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo PATH; ?>css/normalize.css">    
    <link rel="stylesheet" href="<?php echo PATH; ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo PATH; ?>css/main.css">
    <link rel="stylesheet" href="<?php echo PATH; ?>css/main.css">
</head>

<body>
    <base base="<?php echo PATH; ?>" />
    
	<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #006194;">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse p-2" id="menu" >
		    <ul class="navbar-nav mr-auto">
		        <li class="nav-item active">
		            <a class="nav-link" href="#list">Listagem</a>
		        </li>
		        <li class="nav-item">
		            <a class="nav-link" href="#add">Adicionar</a>
		        </li>
		        <li class="nav-item">
		            <a class="nav-link" href="#edit">Editar</a>
		        </li>
		        <li class="nav-item">
		            <a class="nav-link" href="#delete">Deletar</a>
		        </li>
		    </ul>
        </div>
        <a class="navbar-brand" href="#">
            <img src="<?php echo PATH; ?>imagens/logo.png" width="110" height="35" alt="">
        </a>
	</nav>

<div class="container">

    <div class="row error hidden m-3">
        <div class="col-12">
            <div class="alert alert-danger text-center"></div>
        </div>
    </div>


    <section class="m-3" id="list">
        <div class="table-responsive">
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Ano</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div><!--table-responsive-->        
    </section>


    <section id="add" class="hidden m-3">

                <form action="#" class="add-form">
                    <input type="hidden" name="id">
                        <div class="form-group w-100">
                            <label for="">Marca</label>
                            <select  class='form-control' name="marca" id="marcas">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Modelo</label>
                            <input name="modelo"  class='form-control' type="text">
                        </div>
                        <div class="form-group">
                            <label for="">Ano</label>
                            <input name="ano" class='form-control' type="number" min="1900">
                        </div>
                        <div class="row">
                            <div class="col-4"></div>
                            <div class="col-4">
                                <div class="row d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">Adicionar</button>
                                </div>
                            </div>
                        </div>
                </form>
    </section>


    <section id="edit" class="hidden">
        <div class="table-responsive">
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Ano</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div><!--table-responsive-->
    </section>


    <section id="delete" class="hidden">
        <div class="table-responsive">
            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Ano</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div><!--table-responsive-->
    </section>


    <div class="modal modal-edit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Editar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="#" class="edit-form">
                <input type="hidden" name="id">
                <div class="form-group">
                    <label for="">Marca</label>
                    <select  class='form-control' name="marca" id="marcas">
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Model</label>
                    <input name="modelo"  class='form-control' type="text">
                </div>
                <div class="form-group">
                    <label for="">Ano</label>
                    <input name="ano" class='form-control' type="number" min="1900">
                </div>
            
        </div>
        <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
        </div>
    </div>
    </div>
</div><!--container-->

<script src="<?php echo PATH; ?>js/jquery.min.js"></script>
<script src="<?php echo PATH; ?>js/vendor/modernizr-2.8.3.min.js"></script>
<script src="<?php echo PATH; ?>js/bootstrap.min.js"></script>
<script src="<?php echo PATH; ?>js/main.js"></script>
<script>

</script>
</body>
</html>