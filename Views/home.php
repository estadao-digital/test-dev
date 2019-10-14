<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Carros</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 mt-5">
                <table class="table" id="carros">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Ano</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>    
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addCarro">Adicionar Carro</button>
            </div>
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="addCarro" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar carro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form>
                            <div class="form-group">
                                <label for="">Marca</label>
                                <select class="custom-select" name="add-marca" id="">
                                    <option selected>Selecione</option>
                                    <option value="fiat">Fiat</option>
                                    <option value="honda">Honda</option>
                                    <option value="bmw">BMW</option>
                                    <option value="ferrari">Ferrari</option>
                                    <option value="volksvagem">Wolkswagen</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Modelo</label>
                                <input name="add-modelo" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Ano</label>
                                <input name="add-ano" type="text" class="form-control" maxlength="4">
                            </div>
                            <input type="submit" class="btn btn-primary btn-add-carro" value="Adicionar carro">
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editCarro" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar carro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form>
                            <div class="form-group">
                                <label for="">Marca</label>
                                <select class="custom-select" name="marca" id="">
                                    <option selected>Selecione</option>
                                    <option value="fiat">Fiat</option>
                                    <option value="honda">Honda</option>
                                    <option value="bmw">BMW</option>
                                    <option value="ferrari">Ferrari</option>
                                    <option value="volksvagem">Wolkswagen</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Modelo</label>
                                <input name="modelo" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Ano</label>
                                <input name="ano" type="text" class="form-control" maxlength="4">
                            </div>
                            <input type="submit" class="btn btn-primary btn-update-carro" value="Atualizar">
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="viewCarro" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Carro <span class="carro-nome"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form>
                        <div class="form-group">
                                <label>Marca</label>
                                <input name="carro-marca" type="text" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label>Modelo</label>
                                <input name="carro-modelo" type="text" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label>Ano</label>
                                <input name="carro-ano" type="text" class="form-control" disabled maxlength="4">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
    <script>
        var BASE_URL = "<?php echo BASE_URL; ?>"
    </script>
</body>
</html>