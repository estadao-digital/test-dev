<style>
    .loader {
        border: 5px solid #f3f3f3;
        border-radius: 50%;
        border-top: 5px solid #3498db;
        width: 20px;
        height: 20px;
        position: absolute;
        -webkit-animation: spin 0.5s linear infinite;
        animation: spin 0.5s linear infinite;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<template>
    <div>
        <table class="table">
            <tbody>
            <tr v-for="car in cars">
                <td>
                    <div v-if="car.loading" class="loader"></div>
                    {{car.model}}
                </td>
                <td class="text-right">
                    <a v-on:click="handleEditForm(car)" data-toggle="modal" data-target="#editModal" class="btn btn-info btn-xs">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <a v-on:click="deleteId = car.id" data-toggle="modal" data-target="#confirmDelete" class="btn btn-danger btn-xs">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-center">
                        <a data-toggle="modal" data-target="#createModal" class="btn btn-primary">Criar Novo</a>
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- Modal Delete -->
        <div class="modal fade" id="confirmDelete" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-danger text-center">Atenção</h4>
                    </div>
                    <div class="modal-body">
                        <p>Após concluir esta ação, ela é irreversível!</p>
                        <p>Tem certeza que deseja prosseguir?</p>
                        <div class="text-right">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" v-on:click="deleteCar(deleteId)">Sim</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal" role="form">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-success text-center">Editar</h4>
                    </div>
                    <div class="modal-body">
                        <form id="editForm">
                            <div class="form-group">
                                <label for="edit_model">Modelo</label>
                                <input v-model="editForm.model" id="edit_model" name="model" class="form-control" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="edit_year">Ano</label>
                                <input type="number" min="1900" max="2100" v-model="editForm.year" id="edit_year" name="year" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="edit_brand_id">Marca</label>
                                <select v-model="editForm.brand_id" id="edit_brand_id" name="brand_id" class="form-control">
                                    <option v-for="brand in brands" :value="brand.id">{{brand.name}}</option>
                                </select>
                            </div>

                            <div class="text-right">
                                <button type="button" class="btn btn-success" data-dismiss="modal" @click="editCar()">Salvar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" @click="handleCancel(editForm.id)">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal Create -->
        <div class="modal fade" id="createModal" role="form">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-success text-center">Novo</h4>
                    </div>
                    <div class="modal-body">
                        <form id="createForm">

                            <div class="form-group">
                                <label for="create_model">Modelo</label>
                                <input v-model="createForm.model" id="create_model" name="model" class="form-control" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="create_year">Ano</label>
                                <input type="number" min="1900" max="2100" v-model="createForm.year" id="create_year" name="year" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="create_brand_id">Marca</label>
                                <select v-model="createForm.brand_id" id="create_brand_id" name="brand_id" class="form-control">
                                    <option v-for="brand in brands" :value="brand.id">{{brand.name}}</option>
                                </select>
                            </div>

                            <div class="text-right">
                                <button type="button" class="btn btn-success" data-dismiss="modal" @click="createCar()">Criar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    var tempCar = {
        model:null,
        year:null,
        brand_id:null
    }
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                cars: [],
                cachedCar: {},
                brands: [],
                deleteId: 0,
                editForm: {
                    model:'',
                    year:'',
                    brand_id:0
                },
                createForm: {
                    model:'',
                    year:'',
                    brand_id:0
                }
            };
        },

        /**
         * Prepare the component (Vue 1.x).
         */
        ready() {
            this.prepareComponent();
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },

        methods: {
            /**
             * Prepare the component (Vue 2.x).
             */
            prepareComponent() {
                this.getCarros();
                this.getBrands();
            },

            /**
             * Get all of the authorized tokens for the user.
             */
            getCarros() {
                axios.get('/api/cars')
                    .then(response => {
                        let cars = response.data;
                        for(let i in cars){
                            cars[i].loading = false;
                        }
                        this.cars = cars;
                    });
            },
            getBrands() {
                axios.get('/api/brands')
                    .then(response => {
                        let brands = response.data;
                        this.brands = brands;
                    });
            },
            /**
             * Delete a Car
             */
            deleteCar(id) {
                axios.delete('/api/cars/' + id)
                    .then(response => {
                        if(response.status === 204){
                            this.popFromCar(id);
                        }
                    });
            },
            popFromCar(id){
                for(let i in this.cars){
                    let car = this.cars[i];
                    if(car.id === id){
                        this.cars.splice(i, 1);
                    }
                }
            },
            editCar(){
                let data = this.editForm;
                axios.put('/api/cars/' + this.editForm.id, data)
                    .then(response => {
                        if(response.status === 200){
                            for(let i in this.cars){
                                let car = this.cars[i];
                                if(car.id === this.editForm.id){
                                    car.model = response.data.model;
                                    car.brand_id = response.data.brand_id;
                                    car.year = response.data.year;
                                    car.loading = false;
                                }
                            }
                        }
                    }).catch(error => {
                        this.handleError(error.response);
                    });
            },
            handleEditForm(car){
                this.cachedCar = Object.assign({}, car);
                this.editForm = this.cachedCar;
                car.loading = true;
            },
            handleCancel(id){
                let cars = this.cars;
                for(let i in cars){
                    let car = cars[i];
                    if(car.id === id){
                        car.loading = false;
                    }
                }
            },
            createCar(){
                let data = this.createForm;
                axios.post('/api/cars', data)
                    .then(response => {
                        this.handleCreate(response);
                    }).catch(error => {
                        this.handleError(error.response);
                    });
            },
            handleCreate(response){
                if(response.status === 201){
                    this.cars.push(response.data);
                }
                this.createForm.model = null;
                this.createForm.year = null;
                this.createForm.brand_id = null;
            },
            handleError(response){
                if(response.status === 422){
                    alert("Dados inválidos");
                }else{
                    alert("Algo deu errado durante a conexão, tente novamente.")
                }
            }
        }
    }
</script>
