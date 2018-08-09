const axiosDetalhe = window.axios;
Vue.component('detalhe', {
    template: `
        <div>
            <div class='container'>
                <div class='row'>
                <h2>detalhe do modelo:</h2>
               
               
               <label>id {{id}}</label> 
               <input type="text" :value='$route.params.id'>
               <br>

                <label>Modelo {{id}}</label> <input type='text' require='required' name='modelo'>
                <label>Ano</label><input type='text' require='required' name='ano'>
                <label>Marca</label><input type='text' require='required' name='marca'>
                </div>
            </div>
        </div>
    `,
    data: function () {
        var carros
        return {
            nome: "teste",
            dados: [],
            id:'',
        }
    },
    mounted: function () {
        var App = this;
        axios.get('http://localhost/testeSlice/public/api/carros')
            .then(function (response) {
                console.log("o código é ");
                //console.log(response.data.marca);
                App.dados = response.data;
            });
         

    },
})