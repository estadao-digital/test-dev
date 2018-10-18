<template>
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky" v-if="items">
            <ul class="nav flex-column">
                <li class="nav-item" v-for="item in items" :key="item.title">
                    <a class="nav-link" v-bind:href="item.link"><font-awesome-icon v-bind:icon="item.icon" />&nbsp;{{ item.title }}</a>
                </li>
            </ul>
        </div>
        <div class="sidebar-sticky" v-else></div>
    </nav>
</template>

<script>
export default {
  name: 'AppMenu',
  data() {
    return {
      items: [
        {
          title: 'Users',
          icon: 'users',
          link: '/users'
        },
      ]
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