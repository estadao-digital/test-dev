
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
                <tbody id="carros-list" name="carros-list">
                    @foreach ($carros as $carro)
                    <tr id="carro{{$carro->id}}">
                        <td>{{$carro->id}}</td>
                        <td>{{$carro->marca}}</td>
                        <td>{{$carro->modelo}}</td>
                        <td>{{$carro->ano}}</td>
                        <td>
                            <button class="btn btn-warning btn-xs btn-detail open-modal" value="{{ $carro->id}}">Editar</button>
                            <button class="btn btn-danger btn-xs btn-delete delete-carro" value="{{$carro->id}}">Deletar</button>
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
                            <form id="frmcarros" name="frmcarros" class="form-horizontal" novalidate="">

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Marca</label>
                                    <div class="col-sm-9">
                                        <select name="marca" id="marca" class="form-control" style="width:350px">
                                            <option value="">--- Selecione a Marca ---</option>
                                            @foreach ($marcas as $marca)
                                                <option value="{{ $marca->id }}">{{ $marca->marca }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Modelo</label>
                                    <div class="col-sm-9">
                                        <select name="modelo" id="modelo" class="form-control" style="width:350px">
                                            <option value="">--- Selecione o Modelo ---</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group error">
                                    <label for="inputcarro" class="col-sm-3 control-label">Ano</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control has-error" id="ano" name="ano" placeholder="Ano" value="">
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
  </div>
</div>