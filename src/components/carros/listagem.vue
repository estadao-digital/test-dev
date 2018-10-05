<template>
  <div class='container-fluid'>
    <h1>Listagem de carros</h1>
    <hr>
    <div col='col-md-12'>
      <router-link class="btn btn-success" to="/adicionar">Adicionar</router-link>
    </div>
    <table class='table'>
      <thead>
        <th>ID</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Ano</th>
        <th>Opções</th>
      </thead>
      <tbody>
        <tr v-for="record in records" :key="record.id">
          <td>{{record.id}}</td>
          <td>{{record.marca}}</td>
          <td>{{record.modelo}}</td>
          <td>{{record.ano}}</td>
          <td>
            <router-link class="btn btn-primary" :to="{name: 'editar', params:{id: record.id}}">Editar</router-link>
            <router-link class="btn btn-danger espaco_esquerda" :to="{name: 'deletar', params:{id: record.id}}">Apagar</router-link>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Listagem",
  data() {
    return {
      baseUri: "http://localhost/test-dev/api/",
      records: []
    };
  },
  mounted() {
    let uri = this.baseUri + "carros";
    axios.get(uri).then(response => {
      this.records = response.data;
    });
  }
};
</script>

<style scoped>
table {
  margin-top: 20px;
}
.espaco_esquerda {
  margin-left: 10px;
}
h1 {
  margin-top: 10px;
}
</style>
