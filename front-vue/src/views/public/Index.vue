<template>
  <div>
    <Header :title='title' />
    <router-view />
    <Footer :links='links' :year='year' :enterprise='enterprise' />
  </div>
</template>

<script>
import Header from '@/components/template/Header.vue'
import Footer from '@/components/template/Footer.vue'
import config from '@/config/config'
export default {
  name: 'Index',
  components: {
    Header,
    Footer
  },
  data () {
    return {
      title: config.name + config.version,
      links: [
        {
          title: 'Termos de uso',
          link: 'termos-uso'
        },
        {
          title: 'Política de privacidade',
          link: 'politica-privacidade'
        }
      ],
      year: 2021,
      enterprise: 'Estadão'
    }
  }
}
</script>
