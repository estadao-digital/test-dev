<template>
  <div class="container" style="margin-top: 25px">
    <h3 class="text-center">Editar carro</h3>
    <div class="row">
      <div class="col-md-6 col-lg-12">
        <form @submit.prevent="updateCar">
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
              <option>{{ car.brand }}</option>
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

          <button type="submit" class="btn btn-primary">Update</button>
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
  created() {
    this.axios
      .get(`http://127.0.0.1:8080/api/carros/${this.$route.params.id}`)
      .then((res) => {
        this.car = res.data;
      });
  },
  methods: {
    updateCar() {
      this.axios
        .patch(
          `http://127.0.0.1:8080/api/carros/${this.$route.params.id}`,
          this.car
        )
        .then((res) => {
          this.$router.push({ name: "home" });
        });
    },
  },
};
</script>