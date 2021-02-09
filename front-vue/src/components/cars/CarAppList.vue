<template>
  <div class="mt-4">

  <b-table class="m-0 p-0 border" striped hover :items="cars" :fields="fields" >
    <template v-slot:cell(Opcoes)="{ item }">
      <b-button variant="primary" @click="$router.push('/app/car/form/' + item.id)" class="mr-2">
      <b-icon icon="pencil" aria-hidden="true"></b-icon> Editar</b-button>
      <b-button variant="danger" @click="excluir(item)">Excluir</b-button>
    </template>
  </b-table>
  </div>
</template>
<script>
import axios from '@/config/axios'
import { mapActions } from 'vuex'

export default {
  name: 'CarList',
  data () {
    return {
      cars: [],
      fields: [
        { key: 'id', label: 'Cód', sortable: true },
        { key: 'brand.name', label: 'Marca', sortable: true },
        { key: 'model', label: 'Modelo', sortable: true },
        { key: 'year', label: 'Ano', sortable: true },
        { key: 'Opcoes', label: 'Opções', sortable: false }
      ],
      car: null
    }
  },
  async created () {
    this.setTitle({
      title: 'Dashboard / Carros'
    })
    this.readCars()
  },
  methods: {
    ...mapActions(['setLoad', 'setTitle', 'setToast']),
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
    async excluir (car) {
      const confirmar = window.confirm('Deseja realmente excluir ?')
      if (confirmar) {
        try {
          this.setLoad({ load: true })
          await axios
            .delete('cars/' + car.id)
            .then((resp) => {
              if (resp.status === 200) {
                const indice = this.cars.findIndex(t => t.id === car.id)
                this.cars.splice(indice, 1)
                this.setToast({
                  toast: {
                    show: true,
                    variant: 'success',
                    message: 'Carro excluido com sucesso.',
                    title: 'Sucesso!'
                  }
                })
              }
            })
        } catch (e) {
          console.log(e)
          this.setToast({
            toast: {
              show: true,
              variant: 'danger',
              message: 'Erro ao deletar o carro.',
              title: 'Erro!'
            }
          })
        } finally {
          this.setLoad({ load: false })
        }
      }
    }
  }
}
</script>
