<template>
  <div>
    <b-navbar
      class="shadow-sm"
      toggleable="lg"
      type="light"
      variant="white border-bottom"
    >
      <b-navbar-brand href="/">
        <img src="@/assets/logo-estadao-cavalo.svg"  />
      </b-navbar-brand>
      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-text class="font-weight-bold font-italic cursor">{{
            title
          }}</b-nav-text>
        </b-navbar-nav>

      </b-collapse>
    </b-navbar>
  </div>
</template>

<script>
export default {
  name: 'Header',
  props: {
    title: String,
    menu: Array
  },
  methods: {

  }
}
</script>

<style scoped>
.cursor {
  cursor: pointer;
}
</style>
