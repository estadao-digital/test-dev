<template>
  <div class="container">
    <div class="row text-center">
      <div class="col">
        <button
          v-for="(link, index) in links"
          :key="index"
          type="button"
          class="btn btn-link text-primary"
          @click="$router.push({ path: link.link })"
        >
          {{ link.title }}
        </button>
      </div>
    </div>
    <div class="row text-center">
      <div class="col">
        <p>© {{ year }} {{ enterprise }}</p>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'Footer',
  props: {
    year: Number,
    enterprise: String,
    links: Array
  }
}
</script>
