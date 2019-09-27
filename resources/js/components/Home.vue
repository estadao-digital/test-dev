<template>
    <div class="card">
        <h5 class="card-header">Carros</h5>
        <div class="card-body">
            <router-link to="/carro/novo" class="btn btn-primary">Novo Carro</router-link>

            <table class="table table-bordered mt-4">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Ano</th>
                    <th scope="col">Detalhar</th>
                    <th scope="col">Editar</th>
                </tr>
                </thead>
                <tbody>
                <template v-if="!carros.length">
                    <tr>
                        <td colspan="4" class="text-center">Nenhum carro foi adicionado até agora</td>
                    </tr>
                </template>
                <template v-else>
                    <tr v-for="carro in carros" :key="carro.id">
                        <td>{{ carro.id }}</td>
                        <td>{{ carro.modelo }}</td>
                        <td>{{ carro.marca.nome }}</td>
                        <td>{{ carro.ano }}</td>
                        <td>
                            <router-link :to="`/carro/${carro.id}`">Ver</router-link>
                        </td>
                        <td>
                            <router-link :to="`/carro/editar/${carro.id}`">Editar</router-link>
                        </td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Home",
        mounted(){
            this.$store.dispatch('getCarros')
        },
        computed: {
            carros(){
                return this.$store.getters.carros;
            }
        }
    }
</script>

<style scoped>

</style>
