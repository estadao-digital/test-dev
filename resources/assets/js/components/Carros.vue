<template lang="html">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Minha Coleção de Carros</div>

          <div class="panel-body">

            <Alert v-if="success" :message="success" type="alert-success"></Alert>

            <div class="form-group">
              <div class="input-group carros">
                <select class="form-control marca" v-model="carro.marca_id" :class="{'has-error': errors.marca_id }">
                  <option value="null" selected>- Marca -</option>
                  <option v-for="marca in marcas" :value="marca.id">{{ marca.descricao }}</option>
                </select>
                <input type="text" v-model="carro.modelo" @keydown.enter="create" class="form-control modelo" :class="{'has-error': errors.modelo }" placeholder="Modelo"/>
                <input type="text" v-model="carro.ano" class="form-control ano" :class="{'has-error': errors.ano }" placeholder="Ano"/>
                <span class="input-group-btn">
                  <button class="btn btn-info" v-if="editMode" @click="update(carro)"><span class="glyphicon glyphicon glyphicon-pencil"></span></button>
                  <button class="btn btn-success" @click="create"><span class="glyphicon glyphicon glyphicon-plus"></span></button>
                </span>
              </div>
            </div>

            <div v-for="error in errors">
              <Alert  :message="error[0]" type="alert-warning"></Alert>
            </div>

            <ul class="list-group">
              <li class="list-group-item" v-for="carro in carros" :key="carro.id">
                {{ carro.marca }} - {{ carro.modelo}} ano {{ carro.ano}}
                <div class="btn-group pull-right">
                  <button class="btn btn-info btn-xs" @click.prevent="edit(carro)"><span class="glyphicon glyphicon glyphicon-pencil"></span></button>
                  <button class="btn btn-danger btn-xs"  @click.prevent="confirm(carro)"><span class="glyphicon glyphicon glyphicon-remove"></span></button>
                </div>
              </li>
            </ul>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Alert from './Alert.vue'

export default {
  components: { Alert },
  data(){
    return {
      editMode: false,
      carros: [],
      marcas: [],
      carro: {
        marca_id: null,
        modelo: '',
        ano: ''
      },
      errors: [],
      success: ''
    }
  },
  mounted() {
    this.fetchCarros()
  },
  methods: {
    fetchCarros(){
      axios.get('/api/carros')
        .then(response => {
          this.carros = response.data.values
          this.marcas = response.data.marcas
        })
        .catch((err) => {
          console.log(err.response.status);
        })
    },
    create () {
      axios.post('/api/carros', this.carro)
        .then(res => {
          this.fetchCarros()

          this.carro = {}
          this.success = res.data.message
          this.errors = []
        })
        .catch((err) => {
          this.success = ''
          this.errors = err.response.data.errors
          console.log(err.response.data.errors);
        })
    },
    edit (carro) {
      this.carro = carro
      this.marca_id = this.carro.marca.id
      this.editMode = !this.editMode
    },
    update (carro) {
      axios.put(`/api/carros/${ carro.id }`, carro)
        .then(res => {

          this.carro = {}
          this.success = res.data.message
          this.errors = []
          this.editMode = !this.editMode
          this.fetchCarros()
        })
        .catch((err) => {
          this.errors = err.response.data.errors
        })
    },
    remove (carro) {
      axios.delete(`/api/carros/${ carro.id }`)
        .then(res => {
          const carroIndex = this.carros.indexOf(carro)
          this.carros.splice(carroIndex, 1)

          this.$swal({
            title: 'Registro excluido!',
            type: 'success',
            timer: 2000
          }).catch(this.$swal.noop)

        })
        .catch((err) => {
          this.errors = err.response
        })
    },
    confirm(carro) {
      this.clear()
      this.$swal({
        title: 'Confirma exclusão?',
        text: `${ carro.marca } - ${ carro.modelo } ano ${ carro.ano }`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
        buttonsStyling: true,
        reverseButtons: true
      }).then((result) => {
        if (result) {
          this.remove(carro)
        }
      }).catch(this.$swal.noop)
    },
    clear(){
      this.carro = {}
      this.errors = []
      this.success = ''
    }
  }
}
</script>

<style lang="css">
  body{
    padding-top: 30px
  }

  .carros .form-control.has-error{
    border-color: #a94442;
    color: #a94442;
  }
  .carros .form-control.marca{
    width: 30%
  }

  .carros .form-control{
    width: 50%
  }

  .carros .form-control.ano{
    width: 20%
  }
</style>
