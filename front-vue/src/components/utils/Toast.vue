
<template>
  <div></div>
</template>
<script>
import { mapState } from 'vuex'
export default {
  name: 'Toast',
  created () {
    // this.makeToast()
  },
  computed: {
    ...mapState(['toast'])
  },
  watch: {
    toast: {
      handler: function () {
        // do stuff
        if (this.toast.show) this.makeToast()
      },
      deep: true
    }
  },
  methods: {
    makeToast () {
      this.$bvToast.toast(this.toast.message, {
        title: this.toast.title,
        variant: this.toast.variant || 'info',
        solid: true
      })
    }
  }
}
</script>
