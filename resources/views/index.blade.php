<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Place favicon.ico in the root directory -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/normalize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">

    <script src="{{ asset('js/jquery-3.4.1.js') }}"></script>

</head>

<body>

    <div class="container">

        <section>
            <div class="row">
                <div class="col md-12">

                    <h1 class="text-center">Listagem de carros</h1>

                        <table class="table table-hover" id="carrosTable">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">Ano</th>
                                <th scope="col">Editar</th>
                                <th scope="col">Excluir</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                </div>
            </div>
        </section>


        <!-- Modal -->
        <div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Carro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form method="post" id="formEditar">
                            @method('PUT')
                            @csrf

                            <div class="form-group">
                                <label for="marca">Marca</label>
                                <select class="custom-select" id="marcaEdt" name="marcaEdt">
                                    <option>Abra este menu select</option>
                                    <option value="Volkswagen">Volkswagen</option>
                                    <option value="Ford">Ford</option>
                                    <option value="Chevrolet">Chevrolet</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="modeloEdt">Modelo</label>
                                <input type="text" class="form-control" id="modeloEdt" name="modeloEdt" placeholder="Modelo">
                            </div>

                            <div class="form-group">
                                <label for="anoEdt">Ano</label>
                                <input type="text" class="form-control" id="anoEdt" name="anoEdt" placeholder="Ano">
                            </div>

                            {{--<button type="button" class="btn btn-primary" id="update">Enviar</button>--}}
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" id="update" data-idupdatecarro="">Salvar mudanças</button>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <section>
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">Criar novo carro</h1>

                    <form method="post" id="formCadastro">
                        @csrf

                        <div class="form-group">
                            <label for="marca">Marca</label>
                            <select class="custom-select" id="marca" name="marca">
                                <option selected>Abra este menu select</option>
                                <option value="Volkswagen">Volkswagen</option>
                                <option value="Ford">Ford</option>
                                <option value="Chevrolet">Chevrolet</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="modelo">Modelo</label>
                            <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Modelo">
                        </div>

                        <div class="form-group">
                            <label for="ano">Ano</label>
                            <input type="text" class="form-control" id="ano" name="ano" placeholder="Ano">
                        </div>

                        <button type="button" class="btn btn-primary" id="store">Enviar</button>
                    </form>

                </div>
            </div>
        </section>
    </div>


    <footer>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
        <script src="{{ asset('js/vendor/modernizr-2.8.3.min.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="{{ asset('js/all.js') }}"></script>
    </footer>
</body>

</html>

