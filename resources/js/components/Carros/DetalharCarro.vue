<template>
    <div class="card">
        <h5 class="card-header">Detalhes do Carro</h5>
        <div class="card-body">
            <div class="alert alert-danger" role="alert" v-if="error">
                {{error.message}}
            </div>

            <template v-if="carro">
                <div class="form-group">
                    <label for="modelo">Modelo</label>
                    <input type="text" class="form-control" id="modelo" v-model="carro.modelo" disabled>
                </div>

                <div class="form-group">
                    <label for="ano">Ano</label>
                    <input type="text" class="form-control" id="ano" v-model="carro.ano" disabled>
                </div>

                <div class="form-group">
                    <label for="marca">Marca</label>
                    <input type="text" class="form-control" id="marca" v-model="carro.marca.nome" disabled>
                </div>
            </template>
            <router-link to="/" class="btn btn-light">Voltar</router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: "DetalharCarro",
        created(){
            axios.get('/api/carros/' + this.$route.params.id)
                .then(response => {
                    this.carro = response.data;
                })
                .catch(error => {
                    console.log(error.response.data);
                    this.error = error.response.data
                });
        },
        data(){
            return {
                carro: null,
                error: null
            }
        }
    }
</script>
