<template>
    <div class="bg-light p-3">
        <div class="row">
            <div class="col-md-12" v-if="errors.length > 0">
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <li v-for="error in errors">{{error}}</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Modelo:
                        <input type="text" class="form-control" placeholder="Modelo"
                               v-model="novoCarro.modelo" required>
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Marca:
                        <select v-model="novoCarro.marca_id" class="custom-select">
                            <option value="" disabled selected>Escolha a montadora</option>
                            <option v-for="marca in marcas" :value="marca.id">{{marca.nome}}</option>
                        </select>
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Ano:
                        <input type="number" class="form-control"
                               placeholder="Ano"
                               v-model="novoCarro.ano" min="1900" max="2019">
                    </label>
                </div>
            </div>
            <div class="ml-auto col-md-1">
                <button v-on:click="criar()" class="float-right btn btn-primary btn-block">Salvar</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NovoCarroComponent",
        data() {
            return {
                marcas: null,
                novoCarro: {modelo: '', ano: '', marca_id: ''},
                msg: {exibir: false, texto: null},
                errors: []
            }
        },
        created() {
            NProgress.start();
            axios.get('/api/marcas').then(
                res => {
                    this.marcas = res.data;
                }).catch(
                error => {
                    console.log(error)
                }).finally(
                () => {
                    NProgress.done();
                })
        },
        methods: {
            criar() {

                const url = '/api/carros';
                this.errors = [];
                if (!this.novoCarro.marca_id) {
                    this.errors.push('Selecione uma marca');
                }
                if (!this.novoCarro.modelo) {
                    this.errors.push('Digite um modelo');
                }
                if (!this.novoCarro.ano) {
                    this.errors.push('Digite um ano');
                }
                if (this.novoCarro.ano < 1900 || this.novoCarro.ano > 2019) {
                    this.errors.push("O ano deve ser entre 1900 e 2019")
                }
                if (this.errors.length === 0) {
                    NProgress.start();
                    axios.post(url, {
                        marca_id: this.novoCarro.marca_id,
                        modelo: this.novoCarro.modelo,
                        ano: this.novoCarro.ano
                    }).then(res => {
                        alert("Adicionado com sucesso")
                    }).catch(error => {
                        console.log(error);
                    }).finally(() => {
                        NProgress.done();
                        location.reload();
                    })
                }
            },
        }

    }
</script>

<style scoped>

</style>