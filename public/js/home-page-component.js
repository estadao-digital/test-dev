const axios = window.axios;
Vue.component('home-page', {
    template: `
        <div>
          <h2>lista de carros</h2>
          <table>
              <tr v-for='item in dados'>
                   <td>{{item.id}}</td>
                   <td>{{item.marca}}</td>
                   <td>{{item.modelo}}</td>
                   <td>{{item.ano}}</td>
                   <td><router-link :to="{name:'editar',params:{id:item.id}}">detalhes</router-link></td>
                   <td>deletar</td>
              </tr>
          </table>
        </div>
    `,
    data: function () {
        var carros
        return {
            nome: "teste",
            dados: [],
        }
    },
    mounted: function () {
        var App = this;
        axios.get('http://localhost/testeSlice/public/api/carros')
            .then(function (response) {
                console.log(response.data.marca);
                App.dados = response.data;
            });
    },
})