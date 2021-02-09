<template>
<b-container>
    <b-col cols="12" md="auto" class="container mt-4">
    <p>Aqui você tem acesso a edição e consulta dos carros cadastrados em nosso portal de veículos</p>
    <p></p>
    </b-col>
</b-container>
</template>
<script>
import { mapActions } from 'vuex'
export default {
  name: 'Home',
  created () {
    this.setTitle({ title: 'Dashboard' })
  },
  methods: {
    ...mapActions(['setLoad', 'setTitle', 'setToast'])
  }
}
</script>
