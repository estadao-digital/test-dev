<template lang="html">
  <div class="alert" :class="type">{{ message }}</div>
</template>

<script>
export default {
  props: ['message', 'type']
}
</script>
