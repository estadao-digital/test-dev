<template>
  <CarList cars="cars" />
</template>
<script>
import CarList from '@/components/cars/CarList.vue'
export default {
  name: 'Home',
  components: {
    CarList
  }
}
</script>
