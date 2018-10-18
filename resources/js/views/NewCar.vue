<style>
.title-crud { color: #666666; margin: 25px 0; padding: 0 0 5px 0; border-bottom: 1px dotted #666666; }
</style>

<template>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <h2 class="title-crud">CRIAR NOVO CARRO</h2>
        <form id="newCar">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" id="name" aria-describedby="nameHelp">
                <small id="nameHelp" class="form-text text-muted">Digite o nome do carro:</small>
            </div>
            <div class="form-group">
                <label for="brand">Marca:</label>
                <input type="text" class="form-control" id="brand" aria-describedby="brandHelp">
                <small id="brandHelp" class="form-text text-muted">Digite o modelo do carro:</small>
            </div>
            <div class="form-group">
                <label for="model">Modelo:</label>
                <input type="text" class="form-control" id="model" aria-describedby="modelHelp">
                <small id="modelHelp" class="form-text text-muted">Digite o modelo do carro:</small>
            </div>
            <div class="form-group">
                <label for="year">Ano:</label>
                <input type="text" class="form-control" id="year" aria-describedby="yearHelp">
                <small id="yearHelp" class="form-text text-muted">Digite o ano do carro:</small>
            </div>
            <button class="btn btn-primary" v-on:click="postNewCar()">Save</button>
        </form>
    </main>
</template>

<script>
import axios from "axios";

export default {
    components: {},
    name: 'NewCar',
    data() {
        return {
            title : 'NewCar',
            name : null,
            brand : null,
            model : null,
            year : null

        }
    },
    computed: {

    },
    methods: {
        postNewCar(){
            var car = {
                name : document.getElementById('name').value,
                brand: document.getElementById('brand').value,
                model: document.getElementById('model').value,
                year: document.getElementById('year').value
            };

            let url = 'http://172.19.0.1:9000/api/carros';
            let config = { body: car };
            axios.post(url, config)
                .then(response => {})
                .catch(ex => {
                    this.errors.push(ex)
                })
            },
    },
    mounted() {

    },
    destroyed() {

    },
    created() {
        console.log('test');
        console.log(this.cars);
    }
}
</script>