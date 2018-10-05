<template>
  <div class='container-fluid'>
    <div class="alert alert-danger col-md-4 quadro" role="alert">
      Deseja realmente excluir o carro com id {{$route.params.id}}<br>
      Marca: {{input.marca}}<br>
      Modelo: {{input.modelo}}<br>
      Ano: {{input.ano}}
    </div>
    <button class="btn btn-danger" v-on:click="deletar">Apagar</button>
    <router-link class="btn btn-success espaco_esquerda" :to="{name: 'listagem'}">Cancelar</router-link>
  </div>
</template>

<script>
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
      deletar(event){
        event.preventDefault();
        let url = this.baseUri + "carros/" + this.$route.params.id;
        let self = this;
        axios.delete(url)
          .then(() => {
            self.$router.push({name: 'listagem'});
          })
          .catch(e => window.console.log(e));
      }
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
.quadro{
  margin-top: 15px;
}
</style>