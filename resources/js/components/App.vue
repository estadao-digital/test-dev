<template>
    <div>
       <AppHeader></AppHeader>
       <br><br>
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