<template>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="/">{{ 'DASHBOARD' }}</a>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="btn btn-outline-danger my-2 my-sm-0" href="#"><font-awesome-icon icon="power-off" />&nbsp;Logout</a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
  name: 'AppHeader',
  data() {
    return {
      title: "Header"
    }
  },
  computed: {

  },
  methods: {

  },
  mounted() {

  },
  destroyed() {

  },
  created() {
      
  }
}
</script>