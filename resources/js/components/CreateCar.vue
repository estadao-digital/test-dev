<template>
  <div class="container" style="margin-top: 25px">
    <h3 class="text-center">Adicionar Veículo</h3>
    <div class="row">
      <div class="col-md-6 col-lg-12 col-sm-12">
        <form @submit.prevent="addCar">
          <div class="form-group">
            <label class="required">Modelo</label>
            <input
              type="text"
              class="form-control"
              v-model="car.model"
              required
            />
          </div>
          <div class="form-group">
            <label class="required">Marca</label>
            <select v-model="car.brand" class="form-control" required>
              <option disabled>Escolha uma marca</option>
              <option>Fiat</option>
              <option>Toyota</option>
              <option>Volkswagen</option>
              <option>Ford</option>
              <option>Honda</option>
              <option>Hyundai</option>
              <option>Nissan</option>
              <option>Chevrolet</option>
              <option>Kia</option>
              <option>Ford</option>
            </select>
          </div>

          <div class="form-group">
            <label class="required">Ano</label>
            <input
              type="text"
              class="form-control"
              v-model="car.year"
              required
            />
          </div>
          <button type="submit" class="btn btn-primary">Adiconar</button>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>
.required:after {
  content: " *";
  color: red;
}
</style>
 
<script>
export default {
  data() {
    return {
      car: {},
    };
  },
  methods: {
    addCar() {
      this.axios
        .post("http://localhost:8080/api/carros", this.car)
        .then((response) => this.$router.push({ name: "home" }))
        .catch((err) => console.log(err))
        .finally(() => (this.loading = false));
    },
  },
};
</script>