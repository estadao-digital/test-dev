<template>
  <div class="form-group">
    <label for="select-marca">Marca</label>
    <select class="form-control" 
            id="select-marca" 
            v-model="marcaEscolhida"
            @change="onChange">
      <option v-for="marca in marcas" :key="marca">{{marca}}</option>
    </select>
  </div>
</template>

<script>
export default{
  name: 'Combo',
  props: {
    marcaSelecionada: String
  },
  data (){
    return {
      marcas:[
        'GM', 'Fiat', 'Volks', 'Hyndai', 'Ford', 'Mercedes', 'Jeep'
      ],
      marcaEscolhida: this.marcaSelecionada
    }
  },
  watch: {
    marcaSelecionada: function(){
      this.marcaEscolhida = this.marcaSelecionada;
    }
  },
  methods: {
    onChange: function(){
      this.$emit('novaMarca', {marca: this.marcaEscolhida});
    }
  }
}
</script>

<style scope>

</style>