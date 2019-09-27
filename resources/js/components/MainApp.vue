<template>
    <div id="main">
        <Header />
        <main role="main" class="container mt-3">
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
    import Header from "./Header";
    export default {
        name: 'main-app',
        components: {Header}
    }
</script>
