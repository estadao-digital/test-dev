<template>
    <form style="margin-top: 20px;" @submit.prevent="salvar()">
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
        <a style="margin-left:0;" href="#/listarVeiculos" role="button" class="btn btn-dark" >Voltar</a>
        <button style="margin-left:0;"  role="button" class="btn btn-primary btn">Cadastrar</button>
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
        carros: [] 
      }
    },
     methods:{

      salvar(){        

            $.ajax({
                type: 'POST',
                url: 'http://localhost:8000/api/veiculo',                
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