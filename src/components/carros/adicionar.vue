<template>
  <div class='container-fluid'>
    <h1>Adicionar carros</h1>
    <hr/>
    <form>
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
        <button class="btn btn-success" v-on:click="adicionar">Confirmar</button>
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
          marca: 'GM',
          modelo: '',
          ano: '',
        }
      };
    },
    components: {
      Combo
    },
    methods: {
      adicionar(event){
        event.preventDefault();
        let url = this.baseUri + "carros";
        let self = this;
        axios.post(url, this.input)
          .then(() => {
            self.$router.push({name: 'listagem'});
          })
          .catch(e => {
            window.console.log(e);
            //O registro está gravando mas ocorre um erro de CORS
            self.$router.push({name: 'listagem'});
          });
      },
      trocaMarca(payload){
        this.input.marca = payload.marca;
      }
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