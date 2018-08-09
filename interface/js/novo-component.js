const axiosNovo = window.axios;
Vue.component('novo', {
    template: `
        <div>
            <div class='container'>
                <h2>Adicionar novo modelo:</h2>
                   <label>Modelo</label> 
                   <input class='form-control' type='text' require='required' name='modelo' v-model='modelo'>
                    <label>Ano</label>
                    <input class='form-control'  type='text' require='required' name='ano' v-model='ano'>
                        <label>Marca</label>
                        <select v-model='marca' class='form-control' >
                            <option >fiat</option>
                            <option >volks</option>
                            <option >renault</option>
                            <option >ford</option>
                        </select>
                <br><input v-on:click="create()" type='submit' :value="mensagem" class='btn btn-sm btn-success'>
            </div>
        </div>
    `,
    data: function () {
        var carros;
        return {
            mensagem:'salvar',
            marca: '',
            ano: '',
            modelo: '',
        }
    },
    mounted: function () { },
    methods: {
        create: function () {
            var AppCad = this;
            AppCad.mensagem="aguarde, salvando os dados";
            var urlCad = 'http://localhost/testeSlice/public/api/carros';
            axios.post(urlCad, data = { 'modelo': AppCad.modelo, 'ano': AppCad.ano, 'marca': AppCad.marca }).then(function (response) {
                console.log(response.data);
            });
            AppCad.mensagem="salvar";
        }
    }
})