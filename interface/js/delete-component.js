const axiosDelete = window.axios;
Vue.component('delete', {
    props: ['id'],
    template: `
        <div> veículo de id: {{id}} deletado com sucesso</div>
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
        var urlDeleta = 'http://localhost/testeSlice/public/api/carros/'+App.id;
        console.log(urlDeleta);
        axios.delete(urlDeleta,data={'id':App.id}).then(  function (response) { console.log(response.data); });
    },
    
})