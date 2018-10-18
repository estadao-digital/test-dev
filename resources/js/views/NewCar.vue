<template>
    <form>
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" id="nome" aria-describedby="nomeHelp">
            <small id="nomeHelp" class="form-text text-muted">Digite o nome do carro:</small>
        </div>
        <div class="form-group">
            <label for="marca">Marca:</label>
            <input type="text" class="form-control" id="marca" aria-describedby="marcaHelp">
            <small id="marcaHelp" class="form-text text-muted">Digite o modelo do carro:</small>
        </div>
        <div class="form-group">
            <label for="modelo">Modelo:</label>
            <input type="text" class="form-control" id="modelo" aria-describedby="modeloHelp">
            <small id="modeloHelp" class="form-text text-muted">Digite o modelo do carro:</small>
        </div>
        <div class="form-group">
            <label for="modelo">Ano:</label>
            <input type="text" class="form-control" id="ano" aria-describedby="anoHelp">
            <small id="anoHelp" class="form-text text-muted">Digite o ano do carro:</small>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</template>

<script>
    import axios from "axios";

    export default {
        components: {},
        name: 'NewCar',
        data() {
            return {
                title : 'New Car',
                cars : null,
            }
        },
        computed: {

        },
        methods: {

        },
        mounted() {

        },
        destroyed() {

        },
        created() {

        }
    }
</script>