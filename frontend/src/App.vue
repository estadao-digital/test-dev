<template>
    <div id="app">
        <v-app>
            <v-toolbar app dark color="primary">
                <v-toolbar-title class="white--text">Carros - App</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn flat to="/" exact>Carros</v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-content>
                <v-container fluid>
                    <router-view></router-view>
                </v-container>
            </v-content>
            <v-footer app class="footer pa-3">
                © Carros - App
                <v-spacer></v-spacer>
                Made with
                <v-icon class="red--text">favorite</v-icon>
            </v-footer>
        </v-app>
    </div>
</template>

<style lang="scss">
    .footer {
        border-top: 1px solid #d9d7d5;
    }
</style>
