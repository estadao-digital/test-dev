<template>
    <v-container grid-list-xl fluid>
        <!-- Tabela dos grupos de acessos cadastrados no sistema -->
        <v-layout row wrap>
            <v-flex xs6 sm4 md4>
                <Breadcrumbs :items="breadcrumbs"></Breadcrumbs>
            </v-flex>
            <v-flex xs6 sm8 md8 class="text-sm-right">
                <v-btn color="grey darken-2" dark @click="cadastrarCarro()">
                    Cadastrar novo carro
                </v-btn>
            </v-flex>
            <v-flex xs12 sm12 md12>
                <v-card flat class="elevation-1">
                    <v-toolbar card color="grey darken-2" dark>
                        <v-toolbar-title class="font-weight-light">
                            <v-icon>directions_car</v-icon>
                            Carros cadastrados
                        </v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn icon @click="setCarros()">
                            <v-icon>refresh</v-icon>
                        </v-btn>
                    </v-toolbar>
                    <v-card-text>
                        <v-card-title>
                            <v-text-field v-model="search" append-icon="search" label="Pesquise..." single-line
                                          hide-details></v-text-field>
                        </v-card-title>
                        <v-data-table :headers="headers" :items="carros" :search="search">
                            <template slot="items" slot-scope="props">
                                <td>{{ props.item.id }}</td>
                                <td>{{ props.item.marca }}</td>
                                <td>{{ props.item.modelo }}</td>
                                <td>{{ props.item.ano }}</td>
                                <td>{{ props.item.created_at }}</td>
                                <td>{{ props.item.updated_at }}</td>
                                <td class="text-xs-center">
                                    <v-btn small color="warning" @click="editarCarro(props.item)">
                                        editar
                                    </v-btn>
                                    <v-btn small color="error" @click="excluirCarro(props.item)">
                                        Excluir
                                    </v-btn>
                                </td>
                            </template>
                            <v-snackbar slot="no-results" :value="true" color="error" icon="warning">
                                Sua pesquisa por "{{ search }}" não foi encontrada.
                            </v-snackbar>
                        </v-data-table>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <v-dialog v-model="modal" max-width="800px">
            <v-card>
                <v-toolbar card color="primary" dark>
                    <v-toolbar-title>
                        <v-icon>directions_car</v-icon>
                        {{ titulo }}
                    </v-toolbar-title>
                </v-toolbar>
                <v-card-text>
                    <v-form>
                        <v-text-field label="Modelo" v-model="formulario.modelo"
                                      v-validate="'required'"
                                      :error-messages="errors.collect('modelo')"
                                      data-vv-name="modelo"
                                      required
                        ></v-text-field>
                        <v-autocomplete label="Marcas" :items="marcas" v-model="formulario.marca" item-text="name"
                                        v-validate="'required'"
                                        :error-messages="errors.collect('marca')"
                                        data-vv-name="marca"
                                        required
                        ></v-autocomplete>
                        <v-text-field label="Ano" type="number" v-model="formulario.ano"
                                      v-validate="'required'"
                                      :error-messages="errors.collect('ano')"
                                      data-vv-name="ano"
                                      required
                        ></v-text-field>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="success" @click="enviarFormulario()">
                        Salvar
                    </v-btn>
                    <v-btn outline color="error" @click="modal = false">
                        cancelar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>

</template>

<script>
    import {mapGetters, mapActions} from 'vuex'
    import axios from 'axios'
    import Breadcrumbs from '@/components/Breadcrumbs';

    export default {
        name: 'inicio',
        data() {
            return {
                breadcrumbs: [
                    {
                        text: 'Carros',
                        disabled: false,
                        to: '/'
                    }
                ],
                modal: false,
                search: null,
                headers: [
                    {text: '#', value: 'id'},
                    {text: 'Marca', value: 'marca'},
                    {text: 'Modelo', value: 'modelo'},
                    {text: 'ano', value: 'ano'},
                    {text: 'Criado em', value: 'created_at'},
                    {text: 'Atualizado em', value: 'updated_at'},
                    {text: 'Ações', value: 'acoes', align: 'center', sortable: false},
                ],
                titulo: '',
                consulta: false,
                formulario: {
                    id: null,
                    marca: null,
                    modelo: null,
                    ano: null
                },
                marcas: []
            }
        },
        components: {Breadcrumbs},
        mounted() {
            this.$validator.localize('pt_BR')
            this.setCarros()
            this.setMarcas()
        },
        methods: {
            ...mapActions({
                setCarros: 'setCarros',
                novoCarro: 'novoCarro',
                atualizarCarro: 'atualizarCarro',
                deletarCarro: 'deletarCarro'
            }),
            async setMarcas() {
                const response = await axios.get('http://fipeapi.appspot.com/api/1/carros/marcas.json')
                this.marcas = response.data
            },
            enviarFormulario() {
                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        if (this.formulario.id === null) {
                            this.novoCarro(this.formulario)
                            this.modal = false
                            this.limparFormulario()
                        } else {
                            this.atualizarCarro(this.formulario)
                            this.modal = false
                            this.limparFormulario()
                        }
                    }
                })
            },
            cadastrarCarro() {
                this.limparFormulario()
                this.titulo = 'Cadastrar novo carro'
                this.modal = true
            },
            async editarCarro(carro) {

                this.limparFormulario()

                const response = await axios.get('carros/' + carro.id)
                this.formulario = {
                    id: response.data.id,
                    marca: response.data.marca,
                    modelo: response.data.modelo,
                    ano: response.data.ano
                }

                this.titulo = 'Editar carro'
                this.modal = true
            },
            excluirCarro(carro) {
                this.deletarCarro(carro)
            },
            limparFormulario() {
                this.titulo = ''
                this.formulario = {
                    id: null,
                    marca: null,
                    modelo: null,
                    ano: null
                }
                this.$validator.reset()
            }

        },
        computed: {
            ...mapGetters({
                carros: 'carros',
            })
        }

    }
</script>
