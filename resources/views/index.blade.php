<html>
    <head>
        <title>Crud Carros</title>

        <!-- jQuery CDN -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

        <!-- Bootstrap CDN -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <!-- Vue.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>

        <!-- App.js -->
        <script src="/js/app.js"></script>
        <!-- App.css -->
        <link rel="stylesheet" href="/css/app.css">
    </head>

    <body>

        <main id="app" class="container">

            <!-- Cabeçario Navegação -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand">Crud Carros</a>
                <button class="btn btn-success" @click="adicionar" style="margin-top:8px">
                    Adicionar
                </button>
            </nav>

            <!-- Tabela Carros -->
            <table class="table">
                <tr>
                    <th># Cód</th>
                    <th>Nome</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    <th></th>
                </tr>
                <tr v-for="carro in carros">
                    <td>@{{ carro.id }}</td>
                    <td>@{{ carro.nome }}</td>
                    <td>@{{ carro.marca }}</td>
                    <td>@{{ carro.modelo }}</td>
                    <td>@{{ carro.ano }}</td>
                    <td>
                        <button class="btn btn-warning" @click="editar(carro)">
                            Editar
                        </button>
                        <button class="btn btn-danger" @click="deletar(carro)">
                            Deletar
                        </button>
                    </td>
                </tr>
                <tr>
                    <td colspan="100%" v-if="carros.length===0">
                        Nenhum carro cadastrado!
                    </td>
                </tr>
            </table>

            <!-- Modal Formulário -->
            <div class="modal" tabindex="-1" role="dialog" ref="modal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-if="dados.id==0">Adicionar Carro</h5>
                            <h5 class="modal-title" v-else>Editar Carro</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <form>

                                <div class="form-group" v-if="dados.id>0">
                                    <label for="nome">Cód</label>
                                    <input type="text" class="form-control" disabled v-model="dados.id">
                                </div>

                                <div class="form-group">
                                    <label for="nome">Nome</label>
                                    <input type="text" id="nome" class="form-control" placeholder="Nome do carro" v-model="dados.nome">
                                    <small class="erro form-text text-muted" v-if="erros.nome">@{{ erros.nome }}</small>
                                </div>

                                <div class="form-group">
                                    <label for="marca">Marca</label>
                                    <select id="marca" class="form-control" v-model="dados.marca">
                                        <option></option>
                                        <option>Chevrolet</option>
                                        <option>Citroen</option>
                                        <option>Ford</option>
                                        <option>Volkswagen</option>
                                        <option>Toyota</option>
                                    </select>
                                    <small class="erro form-text text-muted" v-if="erros.marca">@{{ erros.marca }}</small>
                                </div>

                                <div class="form-group">
                                    <label for="modelo">Modelo</label>
                                    <input type="text" id="modelo" class="form-control" placeholder="Modelo do carro" v-model="dados.modelo">
                                    <small class="erro form-text text-muted" v-if="erros.modelo">@{{ erros.modelo }}</small>
                                </div>

                                <div class="form-group">
                                    <label for="ano">Ano</label>
                                    <input type="number" id="ano" class="form-control" placeholder="Ano do carro" v-model="dados.ano">
                                    <small class="erro form-text text-muted" v-if="erros.ano">@{{ erros.ano }}</small>
                                </div>

                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" @click="salvar">Salvar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

        </main>

    </body>
</html>
