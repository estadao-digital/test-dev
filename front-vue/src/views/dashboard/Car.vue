<template>
 <b-container>
  <CarList cars="cars" />
 </b-container>
</template>
<script>
import CarList from '@/components/cars/CarAppList.vue'
export default {
  name: 'Home',
  components: {
    CarList
  }
}
</script>
