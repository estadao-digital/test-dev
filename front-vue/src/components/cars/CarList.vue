<template>
  <b-container class="mt-5">
  <b-row v-if="!car">
    <CarItem @viewCar="viewCar" v-for="(car, index) in cars" :key="index"  :car="car"/>
  </b-row>
  <b-row v-else>
    <CarDetail  @backList="backList" :car="car" />
  </b-row>
</b-container>
</template>
<script>
import axios from '@/config/axios'
import { mapActions } from 'vuex'
import CarItem from './CarItem'
import CarDetail from './CarDetail'
export default {
  name: 'CarList',
  components: {
    CarItem, CarDetail
  },
  data () {
    return {
      cars: [],
      car: null
    }
  },
  async created () {
    this.readCars()
  },
  methods: {
    ...mapActions(['setLoad', 'setToast']),
    async readCars () {
      try {
        this.setLoad({ load: true })

        await axios
          .get('cars')
          .then((resp) => {
            this.cars = resp.data.data
          })
      } catch (e) {
        console.log(e)
        this.setToast({
          toast: {
            show: true,
            variant: 'danger',
            message: 'Erro ao buscar Carros.',
            title: 'Erro!'
          }
        })
      } finally {
        this.setLoad({ load: false })
      }
    },
    viewCar (car) {
      this.car = car
    },
    backList () {
      this.car = null
    }
  }
}
</script>
