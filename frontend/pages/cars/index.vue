<template>
    <div>
        <h3 class="text-center">All cars</h3><br/>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>model</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="car in cars" :key="car.id">
                <td>{{ car.id }}</td>
                <td>{{ car.make }}</td>
                <td>{{ car.model }}</td>
                <td>{{ car.created_at }}</td>
                <td>{{ car.updated_at }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'edit', params: { id: car.id }}" class="btn btn-primary">Edit
                        </router-link>
                        <button class="btn btn-danger" @click="deletecar(car.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                cars: []
            }
        },

        methods: {
            deletecar(id) {
                this.axios
                    .delete(`http://localhost:8000/carros/${id}`)
                    .then(response => {
                        let i = this.cars.map(item => item.id).indexOf(id); // find index of your object
                        this.cars.splice(i, 1)
                    });
            }
        }
    }
</script>
