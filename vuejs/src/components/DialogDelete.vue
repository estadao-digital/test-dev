<template>
  <v-dialog v-model="show" max-width="500px">
        <v-card>
        <v-card-title class="headline">Deseja remover esse item?</v-card-title>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="$emit('closeDelete')">Cancelar</v-btn>
            <v-btn
            color="blue darken-1"
            text
            @click="$emit('deleteItemConfirm')">Sim</v-btn>
            <v-spacer></v-spacer>
        </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: ['show']
}
</script>

<style>

</style>