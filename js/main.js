new Vue({
    el: '#app',
    data: {
        title: 'Gerenciamento de Fronta',
        cars: [],
        newCar: {'id':null , 'marca':'', modelo:'', ano:2017},
        tempCars: [],
        brand: {},
        fEdit: false,
        nfEdit: 0,
        onEditing: false,
        cardSize: 'col-md-3',
        filterText: '',
        clsCard: 'card',
        onAdd: false,
    },
    methods: {
        onAddCar: function () {
            $('#new_car').modal('show');
        },

        addCar: function (car) {
            if(!car.marca) {
                swal("Ooops!","Preecha o campo 'Marca' no mínimo!", "warning");
                return false
            };
            tempCars = axios.post('services/api.php', {car: car})
                .then((response) => {
                console.log(response.data);
            $('#new_car').modal('hide');
            this.listCars();
        })
        .catch(function (error) {console.log(error); });
        },

        toggleEdit: function (id) {

            this.nfEdit = id;
            this.onEditing = (id == 0) ? false : true;
            this.cardSize = (id == 0) ? 'col-md-3' : 'col-md-6 col-md-offset-3 col-lg-offset-3';
        },

        saveEdit: function (id,car) {
            if(id!=0) {
                tempCars = axios.put('services/api.php', {data:{id:id,car:car}})
                    .then((response) => {
                    console.log(response.data);
                this.listCars();
                this.toggleEdit(0);
            })
            .catch(function (error) {console.log(error); });
            }
        },

        onDeleteCar: function (car) {
            swal({
                    title: "Tem certeza?",
                    text: "O " + car.marca + " " + car.modelo + " será apagado e não poderá ser recuperado.",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Sim, suma com ele!",
                    closeOnConfirm: false,
                },
                function () {
                    extraDelete(car.id);
                });
            index = this.cars.indexOf(car);
            if(index > -1) {this.cars.splice(index,1);}
        },

        listCars: function () {
            tempCars = axios.get('services/api.php')
                .then((response) => {
                this.cars = response.data;
        })
        .
            catch(function (error) {
                console.log(error);
            });
        }
    },

    mounted: function () {
        this.listCars();
    },
    computed: {
        filteredCars() {
            result = this.cars;
            result = result.filter((element) => {
                return element.marca.match(this.filterText) || element.modelo.match(this.filterText);
        });
            return result.sort((a, b) => a.marca.localeCompare(b.marca));
        }
    }
});

function extraDelete($id) {
    tempCars = axios.delete('services/api.php', {data: {id:$id}})
        .then((response) => {
        console.log(response.data);
    swal("Deletado! ", "Ninguém encontra mais esta carroça.", "success");
    return response.data;
})
.catch(function (error) { return 'error';console.log(error); });
}
