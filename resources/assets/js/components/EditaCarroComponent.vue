<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Edit carro</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">

                        <div class="col-xs-12 form-group">
                            <label class="control-label">Modelo</label>
                            <input type="text" v-model="carro.modelo" class="form-control">
                        </div>

                        <div class="col-xs-12 form-group">
                            <label class="control-label">Marca</label>
                            <input type="text" v-model="carro.marca" class="form-control">
                        </div>

                        <div class="col-xs-12 form-group">
                            <label class="control-label">Ano</label>
                            <input type="text" v-model="carro.ano" class="form-control">
                        </div>

                        <div class="col-xs-12 form-group">
                            <button class="btn btn-success">Atualizar</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.carroId = id;
            axios.get('/api/carros/' + id)
                .then(function (resp) {
                    app.carro = resp.data;
                })
                .catch(function () {
                    alert("Não localizamos o carro")
                    window.location = "/"
                });
        },
        data: function () {
            return {
                carroId: null,
                carro: {
                    marca: '',
                    modelo: '',
                    ano: '',
                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var novoCarro = app.carro;
                axios.put('/api/carros/' + app.carroId, novoCarro)
                    .then(function (resp) {
                        app.$router.replace('/');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Não foi possível editar o carro");
                    });
            }
        }
    }
</script>