<template>
    <div class="card">
        <h5 class="card-header">Editar Carro</h5>
        <div class="card-body">
            <div class="alert alert-danger" role="alert" v-if="error">
                {{error.message}}
            </div>
            <form @submit.prevent="edit">
                <div class="form-group">
                    <label for="modelo">Modelo</label>
                    <input type="text" class="form-control" id="modelo" placeholder="Digite o modelo" v-model="carro.modelo">
                </div>

                <div class="form-group">
                    <label for="ano">Ano</label>
                    <input type="text" class="form-control" id="ano" placeholder="Digite o ano" v-model="carro.ano">
                </div>

                <div class="form-group">
                    <label for="marca">Marca</label>
                    <select class="form-control" id="marca" v-model="carro.marca_id">
                        <option v-for="marca in marcas" v-bind:value="marca.id">
                            {{marca.nome}}
                        </option>
                    </select>
                </div>
                <router-link to="/" class="btn default">Voltar</router-link>
                <button type="submit" class="btn btn-primary">Editar</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "EditarCarro",
        created(){
            axios.get(`/api/carros/${this.$route.params.id}`)
                .then(response => {
                    this.carro = response.data;
                })
                .catch(error => {
                    console.log(error.response.data);
                    this.error = error.response.data
                });
        },
        mounted(){
            this.$store.dispatch('getMarcas')
        },
        computed: {
            marcas(){
                return this.$store.getters.marcas;
            }
        },
        data(){
            return {
                carro: {
                    modelo: '',
                    ano: '',
                    marca_id: ''
                },
                error: null
            }
        },
        methods: {
            edit(){
                this.errors = null;

                axios.put(`/api/carros/${this.$route.params.id}`, this.$data.carro)
                    .then(() => {
                        this.$router.push('/');
                    })
                    .catch((error) => {
                        this.error = error.response.data;
                    });
            },

        }
    }
</script>

<style scoped>

</style>
