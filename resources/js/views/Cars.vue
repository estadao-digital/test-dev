<template>
  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="btn-toolbar mb-2 mb-md-0">
      <router-link :to="{ name: 'new-car' }"><font-awesome-icon icon="plus-circle" />&nbsp;CREATE CAR</router-link>
    </div>
    <br>
    <div class="table-responsive" v-if="cars">
      <table class="tabl e table-bordered table-striped table-sm">
        <thead class="">
        <tr>
          <th style="width:5%">ID</th>
          <th style="width:25%">NOME</th>
          <th style="width:25%">MARCA</th>
          <th style="width:10%">MODELO</th>
          <th style="width:5%">ANO</th>
          <th style="width:30%">AÇÔES</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="car in cars" :key="car.id" >
          <td>{{ car.id }}</td>
          <td>{{ car.name }}</td>
          <td>{{ car.brand }}</td>
          <td>{{ car.model }}</td>
          <td>{{ car.year }}</td>
          <td class="crud">
            <ul>
              <li class="btn btn-sm btn-outline-info">
                <font-awesome-icon icon="edit" />&nbsp;edit
              </li>
              <li class="btn btn-sm btn-outline-danger">
                <font-awesome-icon icon="trash-alt" />&nbsp;delete
              </li>
            </ul>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
    <div class="table-responsive" v-else>
      <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>There's no users to display!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
  </main>
</template>

<script>
import axios from "axios";

export default {
    components: {},
    name: 'Cars',
    data() {
        return {
            title : 'Cars',
            cars : null,
        }
    },
    computed: {

    },
    methods: {

    },
    mounted() {
        let url = 'http://172.19.0.1:9000/api/carros';
        let config = {};
        axios.get(url, config)
            .then(response => {
                this.cars = response.data.data
            })
            .catch(ex => {
                this.errors.push(ex)
            })
    },
    destroyed() {

    },
    created() {
        console.log('test');
        console.log(this.cars);
    }
}
</script>