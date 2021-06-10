<template>
  <div class="">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
      <!-- <nav class="nav nav-pills nav-fill"> -->
      <div class="navbar-collapse">
        <div class="navbar-nav">
          <router-link to="/" class="nav-item nav-link"
            >Lista de Carros</router-link
          >
          <router-link to="/create" class="nav-item nav-link"
            >Criar um carro</router-link
          >
        </div>
      </div>
    </nav>
    <router-view> </router-view>
  </div>
</template>
 
<script>
export default {};
</script>