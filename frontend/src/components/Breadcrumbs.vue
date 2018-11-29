<template>
    <v-breadcrumbs :items="items" divider=">"></v-breadcrumbs>
</template>

<script>
    export default {
        name: 'breadcrumbs',
        props: ['items']
    }
</script>
