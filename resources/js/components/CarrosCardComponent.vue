<template>
    <div>
        <div class="card h-100">
            <img src="https://via.placeholder.com/800x600.jpg" class="card-img-top">
            <div class="card-body p-1">
                <a class="h6 text-center d-block" href="#" v-on:click="detalhe()">{{modelo}}</a>
                <ul class="informacoes-card">
                    <li><i class="mdi mdi-car"></i> {{marca}}</li>
                    <li><i class="mdi mdi-calendar-blank-outline"></i> {{ano}}</li>
                </ul>
                <div class="btn-group w-100">
                    <a href="#" v-on:click="openModalEdit" class="btn btn-outline-primary"><i
                            class="mdi mdi-pencil"></i> Editar</a>
                    <a href="#" v-on:click="openModalDelete" class="btn btn-outline-danger"><i
                            class="mdi mdi-window-close"></i> Excluir</a>
                </div>
            </div>
        </div>

        <div class="modal fade" :id="'editModal-'+id" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{modelo}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" v-if="errors.length >0">
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        <li v-for="error in errors">{{ error }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label> Modelo
                                        <input type="text" required v-model="carro.modelo" class="form-control">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label> Ano
                                        <input type="number" min="1900" max="2019" v-model="carro.ano"
                                               class="form-control">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label> Marca
                                        <select v-model="carro.marca_id" class="custom-select">
                                            <option disabled selected>Selecione uma marca</option>
                                            <option v-for="marca in marcas" :value="marca.id">{{marca.nome}}</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" v-on:click="update()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" :id="'deleteModal-'+id" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Deseja Realmente excluir {{carro.modelo}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" v-on:click="excluir()">Excluir</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" :id="'detalheModal-'+id" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{carro.modelo}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-content">
                        <div class="row">
                            <div class="col-md-8">
                                <img src="https://via.placeholder.com/800x600.jpg" :alt="carro.modelo"
                                     style="width:100%">
                            </div>
                            <div class="col-md-4 pl-md-0">
                                <ul class="informacoes-card mt-3">
                                    <li>ID: {{carro.id}}</li>
                                    <li><i class="mdi mdi-car"></i> {{carro.marca}}</li>
                                    <li><i class="mdi mdi-calendar-blank-outline"></i> {{carro.ano}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CarrosCardComponent",
        props: ['id', 'modelo', 'marca', 'marca_id', 'ano'],
        data() {
            return {
                carro: {
                    id: this.id,
                    modelo: this.modelo,
                    marca_id: this.marca_id,
                    ano: this.ano,
                    marca: this.marca
                },
                marcas: null,
                errors: []
            }
        },
        created() {
            axios.get('/api/marcas/').then(res => {
                this.marcas = res.data
            })
        },
        methods: {
            openModalEdit() {
                $("#editModal-" + this.id).modal('show');
            },
            openModalDelete() {
                $("#deleteModal-" + this.id).modal('show');
            },
            update() {
                this.errors = [];
                if (!this.carro.marca_id) {
                    this.errors.push('Selecione uma marca');
                }
                if (!this.carro.modelo) {
                    this.errors.push('Digite um modelo');
                }
                if (!this.carro.ano) {
                    this.errors.push('Digite um ano');
                }
                if (this.carro.ano < 1900 || this.carro.ano > 2019) {
                    this.errors.push("O ano deve ser entre 1900 e 2019")
                }
                if (this.errors.length === 0) {
                    NProgress.start();
                    axios.put('/api/carros/' + this.carro.id, {
                        id: this.carro.id,
                        marca_id: this.carro.marca_id,
                        modelo: this.carro.modelo,
                        ano: this.carro.ano
                    })
                        .then(res => {
                            alert("Sucesso! ao atualizar o carro");
                        })
                        .catch(error => {
                            console.log(error)
                        })
                        .finally(() => {
                            $("#editModal-" + this.id).modal('hide');
                            NProgress.done();
                            location.reload();
                        })
                }
            },
            excluir() {
                NProgress.start();
                axios.delete('/api/carros/' + this.carro.id)
                    .then(res => {
                        alert("Removido com sucesso")
                    })
                    .catch(error => {
                        alert("Verifique o console para saber mais");
                        console.log(error);
                    })
                    .finally(() => {
                        $("#deleteModal-" + this.id).modal('hide');
                        NProgress.done();
                        location.reload();
                    })

            },
            detalhe() {
                $("#detalheModal-" + this.id).modal('show');
            },
        }
    }
</script>

<style scoped>

</style>