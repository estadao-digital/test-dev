<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>CRUD Eduardo Trova - Estadao</title>

    <!-- Load Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-narrow">
    <h2>CRUD Teste Eduardo Trova - Estadao</h2>
    <button id="btn-add" name="btn-add" class="btn btn-primary btn-xs">Add Novo Carro</button>
    <div>

        <!-- Table-to-load-the-data Part -->
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Carro</th>
                <th>Cor</th>
                <th>Ação</th>

            </tr>
            </thead>
            <tbody id="carros-list" name="carros-list">
            @foreach ($carros as $carro)
                <tr id="carro{{$carro->id}}">
                    <td>{{$carro->id}}</td>
                    <td>{{$carro->nome_carro}}</td>
                    <td>{{$carro->cor}}</td>
                    <td>
                        <button class="btn btn-warning btn-xs btn-detail open-modal" value="{{$carro->id}}">Editar</button>
                        <button class="btn btn-danger btn-xs btn-delete delete-carro" value="{{$carro->id}}">Deletar</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!-- End of Table-to-load-the-data Part -->

        <!-- Modal (Pop up when detail button clicked) -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Editar Carro</h4>
                    </div>
                    <div class="modal-body">
                        <form id="frmcarros" name="frmcarros" class="form-horizontal" novalidate="">

                            <div class="form-group error">
                                <label for="inputcarro" class="col-sm-3 control-label">Nome do Carro</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control has-error" id="carro" name="carro" placeholder="carro" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Cor</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="cor" name="cor" placeholder="Cor" value="">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-save" value="add">Salvar</button>
                        <input type="hidden" id="carro_id" name="carro_id" value="0">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<meta name="_token" content="{!! csrf_token() !!}" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="{{asset('js/ajax-crud.js')}}"></script>
</body>
</html>