<template>
<div id="light">
  <div class="centered">
    <b-spinner variant="primary" style="width: 3rem; height: 3rem;" label="Large Spinner" type="grow"></b-spinner>
  </div>
</div>
</template>

<style scoped>
html,body{width: 100%; height: 100%;}
#light{
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0px;
  background-color:#00000088;
  z-index: 99999999999;
}
.centered {
  position: fixed !important;
  top: 50%;
  left: 50%;
  /* bring your own prefixes */
  transform: translate(-50%, -50%);
}
</style>
