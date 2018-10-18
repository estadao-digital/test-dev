<template>
    <div>
        <h1>Teste Desenvolvedor</h1>
        <p>
            <router-link :to="{ name: 'home' }">HOME</router-link> |
            <router-link :to="{ name: 'cars' }">CARROS</router-link> |
            <router-link :to="{ name: 'new-car' }">NOVO CARRO</router-link>
        </p>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    import AppHeader from "./HeaderComponent";
    import AppMenu from "./AppMenuComponent";

    export default {
        components: {
            AppHeader,
            AppMenu,
        },
        name: "App",
        data() {
            return {

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
    };
</script>