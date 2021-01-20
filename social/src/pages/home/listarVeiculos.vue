<template>
  <div  >
    <table>
        <thead>
          <tr>
              <th>Cod</th>
              <th>Ano</th>
              <th>Marca</th>
              <th>Modelo</th>
              <th>Editar</th>
              <th>Excluir</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="item in carros" :key="item.id">
            <td>{{ item.id }}</td>
            <td>{{ item.Ano }}</td>
            <td>{{ item.Marca }}</td>
            <td>{{ item.Modelo }}</td>
            <td><router-link class="btn btn-primary btn-sm" :to="{name:'atualiza',params:{id:item.id}}">Editar</router-link></td>
            <td><button style="margin-left:0;"  role="button" class="btn btn-primary btn" v-on:click="deletar(item.id)">Excluir</button></td>
            
          </tr>
        </tbody>
      </table>
  </div>
</template>

<script>

  export default {

    data() {
      return {
        carros: [] 

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
                url: 'http://localhost:8000/api/veiculo',
                data: {get_param: 'value'},
                dataType: 'json',
                success: function (data)  {

                  _this.carros = data;       

                }
            });   
      },
        
        deletar(id){

            const _this = this;

            if (window.confirm("Você deseja Excluir o item selecionado? ")) {
                $.ajax({
                    type: 'DELETE',
                    url: 'http://localhost:8000/api/veiculo/' + id,   
                    dataType: 'json',
                  }).always(function (resposta) {
                    if(resposta.status == 200){
                      alert('Excluido com sucesso');
                      _this.init();
                    
                    }else{

                      alert ('Verique os dados');
                      

                    }
                });   

            } 
           
           
        }
    }
  } 
</script>