
// Objeto que representa um carro
function Carro(carro_marca = "", carro_modelo = "", carro_ano = "") {
    this.carro_marca = carro_marca;
    this.carro_modelo = carro_modelo;
    this.carro_ano = carro_ano;
}

// Variável que contem dados úteis para a aplicação
var utils = {
    apiCarrosBaseUrl: "server/api.php/carros/"
};



// Instância do objeto Vue
var app = new Vue({
    el: '#app',
    data: {
        // Array que conterá os todos carros 
        carros: [],
        // Objeto Carro que é inserido na base de dados    
        currentCarro: new Carro(),
        // Objeto Carro que é editado e enviado para a base de dados
        carroEdit: { carroEdit: new Carro(), carroEditReferencia: new Carro() },

        // Objeto Carro que é usado para ser visualizado individualmente.
        tmpCarro: {},

        // Array com as marcas de carro
        marcas: ["Acura", "Agrale", "Alfa Romeo", "Am Gen", "Asia Motors", "Aston Martin", "Audi", "Baby", "Bmw", "Brm", "Bugre", "Cadillac", "Cbt Jipe", "Chana", "Changan", "Chery", "Chevrolet", "Chrysler", "Citroën", "Cross Lander", "Daewoo", "Daihatsu", "Dodge", "Effa", "Engesa", "Envemo", "Ferrari", "Fiat", "Fibravan", "Ford", "Foton", "Fyber", "Geely", "Gm - Chevrolet", "Great Wall", "Gurgel", "Hafei", "Honda", "Hyundai", "Isuzu", "Iveco", "Jac", "Jaguar", "Jeep", "Jinbei", "Jpx", "Kia Motors", "Lada", "Lamborghini", "Land Rover", "Lexus", "Lifan", "Lobini", "Lotus", "Mahindra", "Maserati", "Matra", "Mazda", "Mclaren", "Mercedes-benz", "Mercury", "Mg", "Mini", "Mitsubishi", "Miura", "Nissan", "Peugeot", "Plymouth", "Pontiac", "Porsche", "Ram", "Rely", "Renault", "Rolls-royce", "Rover", "Saab", "Saturn", "Seat", "Shineray", "Ssangyong", "Subaru", "Suzuki", "Tac", "Toyota", "Troller", "Volvo", "Vw - Volkswagen", "Wake", "Walk"]
    },
    computed: {
    },
    methods: {
        // Método responsável por remover um carro
        removeCarro: function (carro) {
            axios({
                url: utils.apiCarrosBaseUrl + carro.carro_id,
                method: 'DELETE'
            }).then(res => {
                this.carros.splice(this.carros.indexOf(carro), 1)
                toastr.success(res.data.message);
            }).catch(res => {
                toastr.error(res.response.data.message);
            }).finally((res) => {

            });
        },
        // Método responsável por adicionar um novo carro
        addCarro: function (carro) {

            axios({
                url: utils.apiCarrosBaseUrl,
                method: "POST",
                data: carro
            }).then(res => {
                this.carros.push(res.data.data);
                toastr.success(res.data.message);
                this.currentCarro = new Carro();

            }).catch(res => {
                toastr.error(res.response.data.message);
            });
        },
        // Método responsável por editar um carro já existente
        updateCarro: function (carro) {

            axios({
                url: utils.apiCarrosBaseUrl + carro.carroEdit.carro_id,
                method: "PUT",
                data: carro.carroEdit
            }).then(res => {
                this.carros.splice(this.carros.indexOf(carro.carroEditReferencia), 1, carro.carroEdit);
                toastr.success(res.data.message);
            })
                .catch(res => {
                    toastr.error(res.response.data.message);
                });
        },
        // Método executado quando o formulário de adição de um novo carro é submetido 
        onSubmit: function (evt) {
            this.addCarro(this.currentCarro);
        },
        // Método executado quando o formulário de edição de um carro é submetido 
        onSubmitEdit: function (evt) {
            this.updateCarro(this.carroEdit);
            $("#modalEditCarro").modal("hide");
        },
        // Método executado quando o painel modal de edição de um carro é solicitado
        showModalCarro: function (carro) {
            this.carroEdit.carroEdit = Object.assign({}, carro);
            this.carroEdit.carroEditReferencia = carro;
            this.tmpCarro = carro;
        }
    },
    // Método executado a instância Vue é montada
    mounted() {
        // Método que requisita ao servidor a lista de todos os carros
        axios.get(utils.apiCarrosBaseUrl)
            .then(res => {
                this.carros = res.data.data;
            })
            .catch((res) => {
                // console.log(res.response.data.message)
                toastr.error(res.response.data.message);
            });
    }
});

// Configurando o Toastr
toastr.options.preventDuplicates = true;
toastr.options.closeButton = true;
