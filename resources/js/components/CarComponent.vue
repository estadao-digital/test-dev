<template>
    <div class="w-25">
        <form @submit.prevent="saveData" class="row g-3">
            <div class="input-group mb-3 w-100">
                <div class="col-md-4">
                    <label for="brand" class="form-label">Marca</label>
                    <select v-model="form.brand" id="brand" class="form-control" :class="{'is-invalid' : form.errors.has('marca')}" @change="form.errors.clear('marca')">
                        <option selected>Choose...</option>
                        <option value="7">Chevrolet</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="model" class="form-label">Modelo</label>
                    <input v-model="form.model" type="text" class="form-control" id="model" :class="{'is-invalid' : form.errors.has('modelo')}" @keydown="form.errors.clear('modelo')">
                </div>
                <div class="col-md-3">
                    <label for="year" class="form-label">Ano</label>
                    <input v-model="form.year" type="number" class="form-control" id="year" :class="{'is-invalid' : form.errors.has('ano')}" @keydown="form.errors.clear('ano')">
                </div>
                <div>&nbsp;</div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Cadastrar Carro</button>
                </div>
            </div>
            <span class="text-danger pt-3 pb-3" v-for="errors in form.errors.errors" v-text="errors"></span>
        </form>
        <div class="w-100">
            <div v-for="carro in carros" :key="carro.id" class="w-100">
                Marca: {{ carro.car_brand.name }} | Modelo: {{ carro.model}} | Ano: {{ carro.year }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
          return {
              carros: '',
              form: new Form({
                  brand: '',
                  model: '',
                  year: ''
              })
          }
        },
        methods:{
            getCars(){
                axios.get('/api/carros')
                    .then((response) => {
                        this.carros = response.data
                    }).catch((error) => {
                        console.log(error)
                    })
            },
            saveData(){
                let data = new FormData();

                data.append('marca', this.form.brand);
                data.append('modelo', this.form.model);
                data.append('ano', this.form.year);

                axios.post('/carros', data)
                    .then((response) => {
                        this.form.reset()
                        this.getCars()
                    }).catch((error) => {
                        this.form.errors.record(error.response.data.errors)
                        console.log(this.form.errors.errors)
                    })
            }
        },
        mounted() {
            this.getCars()
        }
    }
</script>
