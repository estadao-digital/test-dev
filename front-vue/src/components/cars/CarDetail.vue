<template>
  <b-col col="12" >
  <b-card
    :title="car.model"
    :img-src="`${imageCar+car.image}`"
    img-alt="Image"
    img-top
    tag="article"
    style="max-width: 50rem;"
    class="m-2 p-1"
  >
    <b-card-text>
     <p class="p2">R${{car.amount}}</p>
     <p class="p2">Ano: {{car.year}}</p>
     <p class="p2">Modelo: {{car.model}}</p>
     <p class="p2">Marca: {{car.brand.name}}</p>
     <hr>
     {{car.description}}
    </b-card-text>

    <b-button @click="$emit('backList')" variant="danger">Voltar</b-button>
  </b-card>
  </b-col>
</template>
<script>
import config from '@/config/config'
export default {
  name: 'CarItem',
  data () {
    return {
      imageCar: config.imageCar
    }
  },
  props: {
    car: {}
  }
}
</script>
<style scoped>
.p2{line-height: 12px;}
</style>
