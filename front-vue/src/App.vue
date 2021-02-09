<template>
  <div>
    <router-view />
    <div class='text-center'>
      <Loading v-if='load' />
    </div>
    <Toast />
  </div>
</template>
<script>
import { mapState } from 'vuex'
import Loading from '@/components/utils/Loading.vue'
import Toast from '@/components/utils/Toast.vue'
export default {
  name: 'App',
  components: { Loading, Toast },
  computed: {
    ...mapState(['load'])
  }
}
</script>
<style>
.is-valid,
.is-invalid {
  border: 1px solid #ced4da !important;
}
</style>
