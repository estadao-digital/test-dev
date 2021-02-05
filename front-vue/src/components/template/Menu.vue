
<template>
<b-container>
  <div class="row m-0 p-0 relative">
    <b-nav>
      <b-nav-item  @click="$router.push('/app')">Início</b-nav-item>
      <b-nav-item  @click="$router.push('/app/car')">Listar Carros</b-nav-item>
      <b-nav-item  @click="$router.push('/app/car/new')">Cadastrar Carro</b-nav-item>
    </b-nav>
  </div>
</b-container>
</template>
<script>
export default {
  name: 'Menu'
}
</script>
