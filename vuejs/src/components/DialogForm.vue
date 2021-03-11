<template>
  <v-dialog v-model="show" persistent max-width="500px">
    <template v-slot:activator="{ on, attrs }">
      <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
        Adicionar
      </v-btn>
    </template>
    <v-card>
      <v-card-title>
        <span class="headline">{{ formTitle }}</span>
      </v-card-title>

      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="12" sm="6" md="4">
              <v-select
                v-model="editedItem.brand"
                :items="brands"
                item-text="name"
                item-value="id"
                label="Marca"
                persistent-hint
                return-object
              ></v-select>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <v-text-field
                v-model="editedItem.model"
                label="Modelo"
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <v-text-field
                type="number"
                v-model="editedItem.year"
                label="Ano"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>

      <v-alert
        border="top"
        color="red lighten-2"
        dark
        v-if="alertMessage"
        v-html="alertMessage"
      />

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="$emit('close')"> Cancelar </v-btn>
        <v-btn
          color="blue darken-1"
          text
          @click="editedIndex === -1 ? $emit('save') : $emit('update')"
        >
          Salvar
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: ["show", "formTitle", "brands", "editedItem", "alertMessage"],
};
</script>

<style>
</style>