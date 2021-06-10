<template>
  <div style="margin: 25px">
    <h2 class="text-center">Listagem de Carros</h2>
    <div class="table-responsive">
      <table class="table table-hover container">
        <thead class="thead-dark">
          <tr>
            <th style="text-align: center; vertical-align: middle">Código</th>
            <th style="text-align: center; vertical-align: middle">Modelo</th>
            <th style="text-align: center; vertical-align: middle">Marca</th>
            <th style="text-align: center; vertical-align: middle">Ano</th>
            <th style="text-align: center; vertical-align: middle">Ação</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="car in cars" :key="car.id">
            <td style="text-align: center; vertical-align: middle">
              {{ car.id }}
            </td>
            <td style="text-align: center; vertical-align: middle">
              {{ car.model }}
            </td>
            <td style="text-align: center; vertical-align: middle">
              {{ car.brand }}
            </td>
            <td style="text-align: center; vertical-align: middle">
              {{ car.year }}
            </td>
            <td style="text-align: center; vertical-align: middle">
              <div class="btn-group" role="group">
                <router-link
                  :to="{ name: 'edit', params: { id: car.id } }"
                  class="btn btn-success"
                  >Editar</router-link
                >
                <button class="btn btn-danger" @click="deleteCar(car.id)">
                  Deletar
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
 
<script>
export default {
  data() {
    return {
      cars: [],
    };
  },
  created() {
    this.axios.get("http://127.0.0.1:8080/api/carros/").then((response) => {
      this.cars = response.data;
    });
  },
  methods: {
    deleteCar(id) {
      this.axios
        .delete(`http://127.0.0.1:8080/api/carros/${id}`)
        .then((response) => {
          let i = this.cars.map((data) => data.id).indexOf(id);
          this.cars.splice(i, 1);
        });
    },
  },
};
</script>