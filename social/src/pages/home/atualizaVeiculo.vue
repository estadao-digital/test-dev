<template>
    <form style="margin-top: 20px;"  @submit.prevent="atualiza()">

      <div class="form-group">
        <label>Modelo</label>
        <input type="text" id="modelo" class="form-control" v-model="carro.Modelo" >
      </div>
      
      <div class="form-group">
        <label>Ano</label>
        <input type="text" id="ano" class="form-control" v-model="carro.Ano" >
      </div>

      <div class="form-group">
        <label for="exampleFormControlSelect1" >Marca</label>
        <select class="form-control" id="marca" placeholder="Informe a Categoria" v-model="carro.Marca">
          <option>Marca</option>
          <option>Chevrolet</option>
          <option>Volkswagem</option>
          <option>Fiat</option>
        </select>
      </div>
  
     <div style="text-align: right;">
        <a style="margin-left:0;" href="#/" role="button" class="btn btn-dark" >Voltar</a>
       <button style="margin-left:0;"  role="button" class="btn btn-primary btn">Atualiza</button>
    </div>


  </form>
</template>

<script>

  export default {

    data() {
      return {
         carro:{
            Modelo : '',
            Marca : '',
            Ano: '',
        },

      }
    },
    mounted: function() {
      
      this.init();
    },

    methods:{

      init(){
        
        const _this = this;
            $.ajax({
                type: 'GET',
                url: 'http://localhost:8000/api/veiculo/' + this.$route.params.id,
                data: {get_param: 'value'},
                dataType: 'json',
                success: function (data)  {

                  _this.carro = data;   
                  
                }
            });   
      },

            atualiza(){    
              
              const _this = this;

            $.ajax({
                type: 'PUT',
                url: 'http://localhost:8000/api/veiculo/' + this.carro.id,                
                data: this.carro,
                dataType: 'json',
                }).always(function (resposta) {
                  if(resposta.status == 200){
                    alert('Cadastrado com sucesso!');

                 window.location.href = "#/listarVeiculos";

                  }else{

                    alert ('Verique os dados');
                    
                  }
            }); 
            
            
        }




    }
  } 
</script>