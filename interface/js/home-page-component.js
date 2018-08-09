const axios = window.axios;
Vue.component('home-page', {
    template: `
        <div>
          <h2 class='titulos'>{{mensagemEntrada}}</h2>
          <table class="table table-striped">

          <thead>
                   <td>marca</td>
                   <td>modelo</td>
                   <td>ano</td>
                   <td>detalhe</td>
                   <td>apagar</td>
          </thead>
              <tr v-for='item in dados'>
                   <td>{{item.marca}}</td>
                   <td>{{item.modelo}}</td>
                   <td>{{item.ano}}</td>
                   <td><router-link :to="{name:'editar',params:{id:item.id}}" class="btn btn-sm btn-success">detalhes</router-link></td>
                   <td><button class="btn btn-sm btn-success" v-on:click=deletar(item.id)>apagar</button></td>
              </tr>
          </table>
        </div>
    `,
    data: function () {
        var carros
        return {
            mensagemEntrada:"carregando, espere um momento",
            nome: "teste",
            dados: [],
        }
    },
    mounted: function () {
        var App = this;
        axios.get('http://localhost/testeSlice/public/api/carros')
            .then(function (response) {
                console.log(response.data);
                App.dados = response.data;
            });
            App.mensagemEntrada = "lista de carros"
    },
    methods: {
        deletar: function (id) {
            var App = this;
            axios.delete('http://localhost/testeSlice/public/api/carros/' + id).then(function (response) {
                console.log(response.data);
                App.dados = response.data;
            })
        }
    }
})