<template>
    <div class="row">

        <div class="col-md-12 my-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2 class="h2">Carros</h2>
                <button class="btn btn-sm btn-outline-primary" @click="exibirBtnNovoCarro=true"><i
                        class="mdi mdi-plus"></i> Adicionar novo carro
                </button>
            </div>
            <novo-carro-component v-if="exibirBtnNovoCarro"></novo-carro-component>
        </div>

        <div class="col-md-12 mb-5" v-if="carros">
            <div class="row">
                <div class="col-md-3 p-2" v-for="carro in carros">
                    <carros-card-component :id="carro.id" :modelo="carro.modelo" :ano="carro.ano"
                                           :marca="carro.marca.nome" :marca_id="carro.marca_id"></carros-card-component>
                </div>
            </div>
        </div>
        <div class="col-md-12" v-else>
            <div class="alert alert-warning">
                <p class="mb-0">Ops! {{this.msg}}</p>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "TodosCarrosComponent",
        data() {
            return {
                exibirBtnNovoCarro: false,
                carros: null,
                msg: "Carregando...",
            }
        },
        created() {
            NProgress.start();
            axios.get('/api/carros').then(res => {
                (res.data) ? this.carros = res.data : this.msg = "Nenhum carro encontrado"
            }).catch(res => {
                this.msg = res
            }).finally(() => {
                NProgress.done();
            });
        }

    }
</script>

<style scoped>

</style>