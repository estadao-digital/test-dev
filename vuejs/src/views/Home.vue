<template>
    <v-container class="grey lighten-5">
      <v-row dense>
        <v-col>
          <v-data-table
            :headers="headers"
            :items="cars"
            sort-by="calories"
            class="elevation-1"
          >
            <template v-slot:top>
              <v-toolbar flat>
                <v-toolbar-title>CRUD de Carros </v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>

                <app-dialog-loading :show="dialogLoading"/>

                <v-dialog v-model="dialog" persistent max-width="500px">
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      color="primary"
                      dark
                      class="mb-2"
                      v-bind="attrs"
                      v-on="on"
                    >
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
                      <v-btn color="blue darken-1" text @click="close">
                        Cancelar
                      </v-btn>
                      <v-btn color="blue darken-1" text @click="editedIndex === -1 ? save() : update()">
                        Salvar
                      </v-btn>
                    </v-card-actions>
                  </v-card>
                </v-dialog>

                <app-dialog-delete :show="dialogDelete" @closeDelete="closeDelete" @deleteItemConfirm="deleteItemConfirm"/>

              </v-toolbar>
            </template>
            <template v-slot:item.brand="{ item }">
              <span v-html="item.brand.name"></span>
            </template>
            <template v-slot:item.actions="{ item }">
              <v-icon small class="mr-2" @click="editItem(item)">
                mdi-pencil
              </v-icon>
              <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
            </template>
            <template v-slot:no-data>
              <v-btn color="primary" @click="initialize"> Recarregar </v-btn>
            </template>
          </v-data-table>
        </v-col>
      </v-row>
    </v-container>
</template>

<script>
import DialogLoading from '../components/DialogLoading';
import DialogDelete from '../components/DialogDelete';

export default {
  components: {
    'app-dialog-loading': DialogLoading,
    'app-dialog-delete': DialogDelete
  },
    data: () => ({
      dialog: false,
      dialogLoading: false,
      dialogDelete: false,
      alertMessage: '',
      brands: [
        { id: 1, name: 'Fiat' },
        { id: 2, name: 'Toyota' },
        { id: 3, name: 'BMW' },
        { id: 4, name: 'Mercedez' },
        { id: 5, name: 'Volkswagen' },
      ],
      headers: [
        {
          text: 'ID',
          align: 'start',
          sortable: false,
          value: 'id',
        },
        { text: 'Marca', value: 'brand' },
        { text: 'Modelo', value: 'model' },
        { text: 'Ano', value: 'year' },
        { text: 'Ação', value: 'actions', sortable: false },
      ],
      cars: [],
      editedIndex: -1,
      editedItem: {
        brand: '',
        model: '',
        year: '',
      },
      defaultItem: {
        brand: '',
        model: '',
        year: '',
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Novo carro' : 'Editar carro'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      initialize () {
        this.cars = [];
        fetch('http://localhost:81/carros')
        .then(response => response.json())
        .then(data => {
          let result = data.data;
          result.forEach(item => {
            this.cars.push(item);
          });
        })
        .catch(e => {
          alert('Ocorreu um erro ao tentar executar a operação. Tente novamente mais tarde.');
        });
      },

      editItem (item) {
        this.editedIndex = this.cars.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.cars.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        this.dialogLoading = true;
        
        fetch(`http://localhost:81/carros/${this.editedItem.id}`, {
          method: 'DELETE',
        })
        .then(response => response.json())
        .then(response => {
          let result = response.data;

          if (!result.success) {
            
          }

          this.closeDelete()
          this.initialize();
          this.dialogLoading = false;
        })
        .catch(e => {
          this.dialogLoading = false;
        });
      },

      close () {
        this.dialog = false
        this.alertMessage = '';
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      getBrand (brandId) {
        let brand = this.brands.find((brand, i) => {
          return brand.id == brandId
        });

        return brand.name;
      },

      update () {
        this.dialogLoading = true;

        fetch(`http://localhost:81/carros/${this.editedItem.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type':'application/json'
          },          
          body: JSON.stringify(this.editedItem),
        })
        .then(response => response.json())
        .then(response => {
          if (!response.success) {
            this.alertMessage = 'Preencha todos os campos!';
          } else {          
            this.close();
            this.initialize();
          }

          this.dialogLoading = false;
        })
        .catch(e => {
          this.alertMessage = 'Ocorreu um erro ao tentar executar a operação. Tente novamente mais tarde.';
          this.dialogLoading = false;
        });
      },

      save () {
        this.dialogLoading = true;

        fetch('http://localhost:81/carros', {
          method: 'POST',
          headers: {
            'Content-Type':'application/json'
          },          
          body: JSON.stringify(this.editedItem),
        })
        .then(response => response.json())
        .then(response => {
          if (!response.success) {
            this.alertMessage = 'Preencha todos os campos!';
          } else {
            this.close();
            this.initialize();
          }

          this.dialogLoading = false;
        })
        .catch(e => {
          this.alertMessage = 'Ocorreu um erro ao tentar executar a operação. Tente novamente mais tarde.';
          this.dialogLoading = false;
        });
      },
    },
  }
</script>
