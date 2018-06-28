<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Voltar</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Cadastro de carro</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Marca</label>
                        <input type="text" v-model="carro.marca" class="form-control">
                    </div>


                    <div class="col-xs-12 form-group">
                        <label class="control-label">Modelo</label>
                        <input type="text" v-model="carro.modelo" class="form-control">
                    </div>

                    <div class="col-xs-12 form-group">
                        <label class="control-label">Ano</label>
                        <input type="text" v-model="carro.ano" class="form-control">
                    </div>

                    <div class="col-xs-12 form-group">
                        <button class="btn btn-success">Criar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                carro: {
                    id: '',
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
                axios.post('/api/carros', novoCarro)
                    .then(function (resp) {
                        console.log(resp)
                        app.$router.push({path: '/'});
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Não foi possível criar o carro");
                    });
            }
        }
    }
</script>