<template>
    <div>
        <h3 class="text-center">Add Car</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addCar">
                    <div class="form-group">
                        <label>Make</label>
                        <input type="text" class="form-control" v-model="book.make">
                    </div>
                    <div class="form-group">
                        <label>Model</label>
                        <input type="text" class="form-control" v-model="book.model">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Model</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                book: {}
            }
        },
        methods: {
            addCar() {

                this.axios
                    .post('http://localhost:8000/carros/', this.book)
                    .then(response => (
                        this.$router.push({make: 'home'})
                        // console.log(response.data)
                    ))
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            }
        }
    }
</script>
