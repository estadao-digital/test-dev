<template>
  <div class='container-fluid'>
    <h1>Editar carro {{$route.params.id}}</h1>
    <hr/>
    <form>
      <div class="form-group">
        <label for="">Id</label>
        <input type="text"
               class="form-control"
               placeholder="Id do carro"
               disabled
               v-model="input.id">
      </div>
      <div class="form-group">
        <Combo :marca-selecionada="input.marca"
               v-on:novaMarca="trocaMarca"/>
      </div>
      <div class="form-group">
        <label for="">Modelo</label>
        <input type="text"
               class="form-control"
               placeholder="Digite o modelo do carro"
               v-model="input.modelo">
      </div>
      <div class="form-group">
        <label for="">Ano</label>
        <input type="text"
               class="form-control"
               placeholder="Digite o ano do carro"
               v-model="input.ano">
      </div>
      <div class="form-group">
        <button class="btn btn-success" v-on:click="salvarEdicao">Confirmar</button>
        <router-link class="btn btn-danger espaco_esquerda" :to="{name: 'listagem'}">Cancelar</router-link>
      </div>
    </form>
  </div>
</template>

<script>
  import Combo from './combo.vue';
  import axios from 'axios';
  axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
  axios.defaults.headers.post['X-Http-Method-Override'] = 'POST';
  axios.defaults.headers.put['X-Http-Method-Override'] = 'PUT';
  axios.defaults.headers.delete['X-Http-Method-Override'] = 'DELETE';

  export default{
    name: "Adicionar",
    data() {
      return {
        baseUri: "http://localhost/test-dev/api/",
        input: {
          marca: '',
          modelo: '',
          ano: '',
          id: ''
        }
      };
    },
    methods: {
      salvarEdicao(event){
        event.preventDefault();
        let url = this.baseUri + "carros";
        let self = this;
        axios.put(url, this.input)
          .then(() => {
            self.$router.push({name: 'listagem'});
          })
          .catch(e => window.console.log(e));
      },
      trocaMarca(payload){
        this.input.marca = payload.marca;
      }
    },
    components: {
      Combo
    },
    mounted() {
      let url = this.baseUri + "carros/" + this.$route.params.id;
      let self = this;
      axios.get(url)
        .then(response => {
          self.input.marca = response.data.marca;
          self.input.modelo = response.data.modelo;
          self.input.ano = response.data.ano;
          self.input.id = response.data.id;
        })
        .catch(e => window.console.log(e));
    }
  }
</script>

<style scoped>
.espaco_esquerda {
  margin-left: 10px;
}
h1 {
  margin-top: 10px;
}
</style>