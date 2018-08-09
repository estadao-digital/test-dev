const axiosDetalhe = window.axios;
Vue.component('detalhe', {
    props: ['id'],
    template: `
        <div>
            <div class='container'>
                
                <h2>detalhe do modelo:</h2>

                <div class='row'>
                   <label>Modelo</label> 
                   <input  class='form-control' type='text' require='required' name='modelo' v-model='modelo'>
                </div>



                <div class='row'>
                <label>Ano</label>
                <input  class='form-control'  type='text' require='required' name='ano' v-model='ano'>
                </div>
                
                
                <div class='row'>
                <label>Marca</label>
                    <select v-model='marca' class='form-control' >
                        <option >fiat</option>
                        <option >volks</option>
                        <option >renault</option>
                        <option >ford</option>
                    </select>
                </div>


                <div class='row'>
                 <input v-on:click="salvaDados()" type='submit'value='salva'>
                </div>
            
            
           
            </div>
        </div>
    `,
    data: function () {
        var carros;
        return {
            marca: '',
            ano: '',
            modelo: '',
        }
    },
    mounted: function () {
        var App = this;
        var urlDetalhe = 'http://localhost/testeSlice/public/api/carros/' + App.id;
        axios.get(urlDetalhe)
            .then(function (response) {
                console.log(response.data);
                App.marca = response.data.marca;
                App.modelo = response.data.modelo;
                App.ano = response.data.ano;
            });
    },
    methods:{
       salvaDados:function(){
           var Apps = this;
           var urlUpdate = 'http://localhost/testeSlice/public/api/carros/' + Apps.id;
           axios.put(
               urlUpdate ,
               data={'modelo':Apps.modelo,'ano':Apps.ano,'marca':Apps.marca,"id":Apps.id}  
            )
           .then(function(response){
                 console.log(response.data); 
            });
        },
    }
})