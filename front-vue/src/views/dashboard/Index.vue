<template>
  <div>
    <Header />
    <Titulo :titulo="title" />
    <Menu />
    <hr>
    <div class="col m-0 p-0">
      <router-view />
    </div>
  </div>
</template>
<script>

import Menu from '@/components/template/Menu.vue'
import Titulo from '@/components/utils/Titulo.vue'
import Header from '@/components/template/Header.vue'

import { mapState } from 'vuex'
export default {
  name: 'Index',
  components: {
    Menu,
    Titulo,
    Header
  },
  computed: {
    ...mapState(['title']),
    ...mapState(['usuario'])
  }
}
</script>
<style scoped>
.relative {
  position: relative;
}
.content {
  margin-left: 68px !important;
}
</style>
