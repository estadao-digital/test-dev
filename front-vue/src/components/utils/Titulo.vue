<template>
  <b-row
    v-if="titulo"
    class="m-0 mb-4 p-0 align-items-center border bg-white rounded title-border"
  >
    <b-icon class="ml-4 mr-3" icon="bookmark" aria-hidden="true"></b-icon>
    <b-col class="m-0 p-0">
      <p class="m-0 p-0 pt-4 pr-4 pb-4 font-italic font-weight-bold">
        <span class="font-weight-normal text-secondary">Você está em:</span>
        {{ titulo }}
      </p>
    </b-col>
  </b-row>
</template>
<script>
export default {
  props: {
    titulo: null
  }
}
</script>
<style scoped>
.title-border {
  position: relative;
  border-left: solid 10px #007bff !important;
}
</style>
