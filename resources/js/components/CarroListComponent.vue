<template>
<div>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div v-if="loading == true" class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                </div>
            </div>
        </div>
        
        <div v-if="showEditForm === true" >
            <br>
            <h3>Edição dos dados do veículo</h3>
            <div class="row">
                <div class="col-md-12">
                    <div v-if="errorsEdit === true" class="alert alert-warning">
                        <span v-for="errors in errors_edit" v-bind:key="errors.key">
                            <b> {{errors[0]}} </b> <br>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div v-if="successEdit === true" class="alert alert-success">
                            <b> O carro foi editado com sucesso </b>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <input class="form-control col-md-12" type="hidden" v-model="carroEdit.id" />
                    <span>marca</span>
                    <input class="form-control col-md-12" type="text" v-model="carroEdit.marca" />
                    <span>modelo</span>
                    <input class="form-control col-md-12" type="text" v-model="carroEdit.modelo" />
                    <span>ano</span>
                    <input class="form-control col-md-12" type="text" v-model="carroEdit.ano" />
                    <span>placa</span>
                    <input class="form-control col-md-12" type="text" v-model="carroEdit.placa" />
                </div>
                <div class="col-md-4">
                    <span>câmbio</span>
                    <input class="form-control col-md-12" type="text" v-model="carroEdit.cambio" />
                    <span>custo R$</span>
                    <input class="form-control col-md-12" type="text" v-model="carroEdit.custo" />
                    <span>valor de venda R$</span>
                    <input class="form-control col-md-12" type="text" v-model="carroEdit.venda" />
                </div>
                <div class="col-md-4">
                    <span>cole aqui o endereço web da imagem</span>
                    <textarea class="form-control col-md-12" v-model="carroEdit.link_img" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button style="margin-top:15px; margin-bottom:10px;" class="btn btn-danger float-right" v-on:click="closeEditForm">cancelar</button>
                    <button style="margin-top:15px; margin-bottom:10px;" class="btn btn-success float-right" v-on:click="editCar">Atualizar dados</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
        </div>
        
        <div v-if="showCreateForm === true" >
            <br>
            <h3>Novo veículo  </h3>
            <div class="row">
                <div class="col-md-12">
                    <div v-if="errorsCreate === true" class="alert alert-warning">
                        <span v-for="errors in errors_create" v-bind:key="errors.key">
                            <b> {{errors[0]}} </b> <br>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div v-if="successCreate === true" class="alert alert-success">
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
                    <input class="form-control col-md-12" type="text" v-model="carro.venda" />
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
        <br>
        <h3  v-if="showCreateForm === false">Listagem <button class="btn btn-info float-right btn-sm" v-on:click="openCreateForm">novo</button> </h3>
        
        <div  class="card border-primary" v-for="carro in carros" v-bind:key="carro.id" style="margin-top:20px">
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
                        <button v-on:click="getCar(carro.id)" class="btn btn-primary col-md-6 btn-sm">editar registro</button><br>   
                        <button v-on:click="deleteCar(carro.id)" style="margin-top:10px" class="btn btn-danger btn-sm col-md-6">excluir</button>
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
                errorsCreate: false,
                successCreate: false,
                successEdit: false,
                errors_create: [],
                errorsEdit: false,
                carroEdit: {
                    id: 0,
                    marca: '',
                    modelo: '',
                    ano: '',
                    cambio: '',
                    venda: 0,
                    custo: 0,
                    link_img: ""
                },
                carro: {
                    id: 0,
                    marca: '',
                    modelo: '',
                    ano: '',
                    cambio: '',
                    venda: 0,
                    custo: 0,
                    link_img: ""
                },
                showCreateForm: false,
                showEditForm: false,
                loading:false
            }
        },
        methods: {
            listar : function (){
                this.loading = true;
                axios.get('https://test-dev-estadao.herokuapp.com/api/carros')
                    .then(response => {
                        this.carros = response.data.data; 
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => this.loading = false)
            },
            openCreateForm : function (event) {
                this.showCreateForm = true;
                this.closeEditForm();
            },
            closeCreateForm : function () {
                this.showCreateForm = false;
            },
            openEditForm : function () {
                this.showEditForm = true;
                this.closeCreateForm();
            },
            closeEditForm : function () {
                this.showEditForm = false;
            },
            storeCar : async function() {
                this.loading = true;
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
                            venda: this.carro.venda,
                            custo: this.carro.custo,
                            link_img: this.carro.link_img,
                            placa: this.carro.placa,
                        }
                    })
                    .then(response => {
                        if(response.data.error){
                            this.errors_create = response.data.error;
                            this.errorsCreate = true;
                            this.successCreate = false;
                        } else {
                            this.errorsCreate = false;
                            this.successCreate = true;
                            //this.closeCreateForm();
                            this.listar();
                        }
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => this.loading = false)
            },
            getCar : function (id) {
                 this.loading = true;
                axios.get('http://127.0.0.1:8000/api/carros/'+id)
                    .then(response => {
                        console.log(response.data.data);
                        this.carroEdit = response.data.data; 
                        this.openEditForm();
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => this.loading = false)
            },
            editCar : function () {
                 this.loading = true;
                axios({
                    headers: {
                        Accept: "application/json",
                        ContentType: "application/json",
                        Authorization: "Bearer qxQnd4ZXzCAw5Ip1Cw1H0i3HOUcI7awf2js3g4aj"
                    },
                    method: 'put', // verbo http
                    url: 'http://127.0.0.1:8000/api/carros', // url
                    
                    data: {
                            id: this.carroEdit.id,
                            marca : this.carroEdit.marca,
                            modelo: this.carroEdit.modelo,
                            ano: this.carroEdit.ano,
                            cambio: this.carroEdit.cambio,
                            venda: this.carroEdit.venda,
                            custo: this.carroEdit.custo,
                            link_img: this.carroEdit.link_img,
                            placa: this.carroEdit.placa,
                        }
                    })
                    .then(response => {
                        if(response.data.error){
                            this.errors_edit = response.data.error;
                            this.errorsEdit = true;
                            this.successEdit = false;
                        } else {
                            this.errorsEdit = false;
                            this.successEdit = true;
                            //this.closeEditForm();
                            this.listar();
                        }
                    })
                    .catch(error => {
                        console.log(error)
                }).finally(() => this.loading = false)
            },
            deleteCar : function (id) {
                 this.loading = true;
                axios({
                    headers: {
                        Accept: "application/json",
                        ContentType: "application/json",
                        Authorization: "Bearer qxQnd4ZXzCAw5Ip1Cw1H0i3HOUcI7awf2js3g4aj"
                    },
                    method: 'delete',
                    url: 'http://127.0.0.1:8000/api/carros/'+id, 
                    })
                    .then(response => {
                        if(response.data.error){
                            //this.errors_create = response.data.error;
                            this.errors = true;
                            this.success = false;
                        } else {
                            this.errors = false;
                            this.success = true;
                            this.listar();
                        }
                    })
                    .catch(error => {
                        console.log(error)
                }).finally(() => this.loading = false)
            }
        }
    }
</script>
