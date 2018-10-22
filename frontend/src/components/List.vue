<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <router-link class="btn btn-success" :to="{ name: 'NovoCarro' }">Novo Carro</router-link>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Ano</th>
                    <th scope="col" colspan="2">Açoes</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(car, index) in cars" :key="car.id">
                    <th>{{ car.id }}</th>
                    <td>{{ car.brand.name }}</td>
                    <td>{{ car.model }}</td>
                    <td>{{ car.year }}</td>
                    <td>
                        <router-link class="btn btn-primary" :to="{ name: 'EditarCarro', params: { id: car.id }}">Editar</router-link>
                        <button type="button" class="btn btn-danger" @click.prevent="remove(car.id, index)">Remover</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    methods: {
        remove: function (id, index) {
            this.$store.dispatch('removeCar', id)
            .then(() => {
                this.cars.splice(index, 1);
            })
        }
    },
    computed: {
        cars () {
            return this.$store.state.cars.carsList
        }
    },
    created () {
        this.$store.dispatch('getCars')
    }
}
</script>

<style>
    tbody tr {
        cursor: pointer
    }
</style>
