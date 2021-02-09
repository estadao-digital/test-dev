<template>
    <div class="container">
      <b-container fluid>
        <h3 class="text-center">Add Car</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addCar()">
                    <div class="form-group">
                        <label>Make</label>
                        <input type="text" class="form-control" v-model="car.make">
                    </div>
                    <div class="form-group">
                        <label>Model</label>
                        <input type="text" class="form-control" v-model="car.model">
                    </div>

                    <div class="form-group">
                        <label>Year</label>
                        <input type="text" class="form-control" v-model="car.year">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Model</button>
                </form>
            </div>
        </div>
      </b-container>
    </div>
</template>

<script>
    import { axios } from "axios";

    export default {
        data() {
            return {
                car: {}
            }
        },
        async addCar() {
          
          await axios.post('carros', car)
          .then(response => {
            console.log(response)
          })
          .catch(err => {
            console.log(err)
          })
        }
    }
</script>
