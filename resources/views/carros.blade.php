
<div id="carros">
    <div class="row">
        <div class="col-md-10 col-sm-12 col-lg-9">
        <h2>Test-dev</h2>
        <button id="btn-add" name="btn-add" class="btn btn-primary btn-xs">Adicionar um novo carro</button>
        <div>
        <!-- Inicio da tabela -->
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Ano</th>
                    </tr>
                </thead>
                <tbody id="cars-list" name="cars-list">
                    @foreach ($cars as $car)
                    <tr id="car{{$car->id}}">
                        <td>{{$car->id}}</td>
                        <td>{{$car->marca}}</td>
                        <td>{{$car->modelo}}</td>
                        <td>{{$car->ano}}</td>
                        <td>
                            <button class="btn btn-warning btn-xs btn-detail open-modal" value="{{$car->id}}">Editar</button>
                            <button class="btn btn-danger btn-xs btn-delete delete-car" value="{{$car->id}}">Deletar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


            <!-- Final da tabela -->
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">Carro</h4>
                        </div>
                        <div class="modal-body">
                            <form id="frmcars" name="frmcars" class="form-horizontal" novalidate="">

                                <div class="form-group error">
                                    <label for="inputcar" class="col-sm-3 control-label">Marca</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control has-error" id="car" name="car" placeholder="marca" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Modelo</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="description" name="description" placeholder="modelo" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Ano</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="description" name="description" placeholder="ano" value="">
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save" value="add">Salvar</button>
                            <input type="hidden" id="car_id" name="car_id" value="0">
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
  </div>
</div>