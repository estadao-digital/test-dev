<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'criaCarro'}" class="btn btn-success">Cadastrar novo carro</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Carros</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Ano</th>
                        <th width="100">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="carro, index in carros">
                        <td>{{ carro.id }}</td>
                        <td>{{ carro.marca }}</td>
                        <td>{{ carro.modelo }}</td>
                        <td>{{ carro.ano }}</td>
                        <td>
                            <router-link :to="{name: 'editaCarro', params: {id: carro.id}}" class="btn btn-sm btn-primary">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-sm btn-danger"
                               v-on:click="deleteEntry(carro.id, index)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                carros: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/carros')
                .then(function (resp) {
                    app.carros = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Não foi possível carregar os carros");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Deseja realmente deletar?")) {
                    var app = this;
                    axios.delete('/api/carros/' + id)
                        .then(function (resp) {
                            app.carros.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Não foi possível deletar o carro");
                        });
                }
            }
        }
    }
</script>