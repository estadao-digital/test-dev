<template>
<div>
    <div>
        <div v-if="showCreateForm === true" >
            <h3>Novo veículo  </h3>
            <div class="row">
                <div class="col-md-12">
                    <div v-if="errors === true" class="alert alert-warning">
                        <span v-for="errors in errors_create" v-bind:key="errors.key">
                            <b> {{errors[0]}} </b> <br>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div v-if="success === true" class="alert alert-success">
                        
                            <b> Um novo carro foi cadastrado </b>
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <span>marca</span>
                    <input class="form-control col-md-12" type="text" v-model="carro.marca" />
                    <span>modelo</span>
                    <input class="form-control col-md-12" type="text" v-model="carro.modelo" />
                    <span>ano</span>
                    <input class="form-control col-md-12" type="text" v-model="carro.ano" />
                    <span>placa</span>
                    <input class="form-control col-md-12" type="text" v-model="carro.placa" />
                </div>
                <div class="col-md-4">
                    <span>câmbio</span>
                    <input class="form-control col-md-12" type="text" v-model="carro.cambio" />
                    <span>custo R$</span>
                    <input class="form-control col-md-12" type="text" v-model="carro.custo" />
                    <span>valor de venda R$</span>
                    <input class="form-control col-md-12" type="text" v-model="carro.valor" />
                </div>
                <div class="col-md-4">
                    <span>cole aqui o endereço web da imagem</span>
                    <textarea class="form-control col-md-12" v-model="carro.link_img" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button style="margin-top:15px; margin-bottom:10px;" class="btn btn-danger float-right" v-on:click="closeCreateForm">cancelar</button>
                    <button style="margin-top:15px; margin-bottom:10px;" class="btn btn-success float-right" v-on:click="storeCar">Cadastrar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
        </div>
        <h3  v-if="showCreateForm === false">Lista de Veículos <button class="btn btn-info float-right" v-on:click="openCreateForm">criar novo veiculo</button> </h3>
        <div  class="card border-primary" v-for="carro in carros" v-bind:key="carro.id" style="margin-top:10px">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <img v-if="carro.link_img != null" 
                            v-bind:src="carro.link_img" 
                            class="rounded float-left img-thumbnail" 
                            alt="">
                        <img v-if="carro.link_img == null || carro.link_img == ''" 
                            src="https://www.freeiconspng.com/uploads/no-image-icon-11.PNG" 
                            class="rounded float-left img-thumbnail" 
                            alt="">
                    </div>
                    <div class="col-md-4" style="list-style-type:none">
                        <ul>
                            <li><b>ID:</b> {{carro.id}}</li>
                            <li><b>Marca:</b> {{carro.marca}}</li>
                            <li><b>Modelo:</b> {{carro.modelo}}</li>
                            <li><b>Ano:</b> {{carro.ano}}</li>
                            <li><b>Placa:</b> {{carro.placa}}</li>
                            <li><b>Câmbio:</b> {{carro.cambio}}</li>
                            <li><b>Custo:</b> R$ {{carro.custo}}</li>
                            <li><b>Valor de venda:</b> R$ {{carro.venda}}</li>
                            <li><b>Lucro presumido:</b> R$ {{carro.venda - carro.custo}}</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <a href="" class="btn btn-primary col-md-6 btn-sm">editar registro</a><br>   
                        <a href="" style="margin-top:10px" class="btn btn-danger btn-sm col-md-6">excluir</a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>  
</template>

<script>
    export default {
        mounted() {
            this.listar();
        },
        data () {
        return {
                carros: [],
                errors: false,
                success: false,
                errors_create: [],
                carro: {
                    id: 0,
                    marca: '',
                    modelo: '',
                    ano: '',
                    cambio: '',
                    valor: 0,
                    custo: 0,
                    link_img: ""
                },
                showCreateForm: false
            }
        },
        methods: {
            listar : function (){
                axios.get('http://127.0.0.1:8000/api/carros')
                    .then(response => {
                        this.carros = response.data.data; 
                    })
                    .catch(error => {
                        console.log(error)
                        this.errored = true
                    })
                    .finally(() => this.loading = false)
            },
            openCreateForm : function (event) {
                this.showCreateForm = true;
            },
            closeCreateForm : function () {
                this.showCreateForm = false;
            },
            storeCar : async function() {
                axios({
                    headers: {
                        Accept: "application/json",
                        ContentType: "application/json",
                        Authorization: "Bearer qxQnd4ZXzCAw5Ip1Cw1H0i3HOUcI7awf2js3g4aj"
                    },
                    method: 'post', // verbo http
                    url: 'http://127.0.0.1:8000/api/carros', // url
                    
                    data: {
                            marca : this.carro.marca,
                            modelo: this.carro.modelo,
                            ano: this.carro.ano,
                            cambio: this.carro.cambio,
                            venda: this.carro.valor,
                            custo: this.carro.custo,
                            link_img: this.carro.link_img,
                            placa: this.carro.placa,
                        }
                    })
                    .then(response => {
                        if(response.data.error){
                            this.errors_create = response.data.error;
                            this.errors = true;
                            this.success = false;
                        } else {
                            alert("Carro cadastrado com sucesso!");
                            this.errors = false;
                            this.success = true;
                            this.listar();
                        }
                    })
                    .catch(error => {
                        console.log(error)
                })
            },
            getCar : function () {

            },
            editCar : function () {

            },
            confirmDeleteCar : function () {

            },
            deleteCar : function () {

            }
        }
    }
</script>
