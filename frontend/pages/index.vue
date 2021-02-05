<template>
  <p v-if="$fetchState.pending">Fetching cars...</p>
  <p v-else-if="$fetchState.error">An error occurred :(</p>
  <div v-else>
    <div class="container">
    <b-container fluid>
       <b-table responsive striped hover :items="cars" :fields="fields"></b-table>
    </b-container>
  </div>
    <button @click="$fetch">Refresh</button>
  </div>
</template>

<script>
export default {
  name: 'HomePage',

  data() {
    return {
      // Note `isActive` is left out and will not appear in the rendered table
      fields: ['make', 'model', 'year'],
      cars: []
    }
  },
  
  async fetch() {
    this.cars = await fetch(
      'http://localhost:8000/carros'
    ).then(res => res.json())
  }
}
</script>
