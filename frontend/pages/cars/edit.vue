<template>
    <div>
        <h3 class="text-center">Edit Car</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateCar">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="car.make">
                    </div>
                    <div class="form-group">
                        <label>Author</label>
                        <input type="text" class="form-control" v-model="car.author">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Car</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                car: {}
            }
        },
        created() {
            this.axios
                .get(`http://localhost:8000/carros/${this.$route.params.id}`)
                .then((response) => {
                    this.car = response.data;
                    // console.log(response.data);
                });
        },
        methods: {
            updateCar() {
                this.axios
                    .put(`http://localhost:8000/carros/update/${this.$route.params.id}`, this.car)
                    .then((response) => {
                        this.$router.push({make: 'home'});
                    });
            }
        }
    }
</script>
