var App = new Vue({
    el: '#AppVue',
    data: {
        api: '/api/carros',

        cars: {
            loading: false,
            list: [],
        },

        newCar: {
            error: false,
            messages: [],

            modelo: {
                value: '',
                error: false,
                messages: [],
            },
            marca: {
                value: '',
                error: false,
                messages: [],
            },
            ano: {
                value: '',
                error: false,
                messages: [],
            },
        },

        currentCar: {
            error: false,
            messages: [],

            id: '',

            modelo: {
                value: '',
                error: false,
                messages: [],
            },
        },
    },
    methods: {
        loadCars: function () {
            App.cars.loading = true;

            axios.get(App.api + '/').then(req => {
                App.cars.list = [];

                for (var i in req.data.data) {
                    App.cars.list.push(req.data.data[i]);
                }

                App.cars.loading = false;
            });
        },
        addCar: function () {
            App.newCar.error = false;
            App.newCar.messages = [];

            App.newCar.modelo.error = false;
            App.newCar.modelo.messages = [];
            App.newCar.modelo.value = App.newCar.modelo.value.trim();

            App.newCar.marca.error = false;
            App.newCar.marca.messages = [];
            App.newCar.marca.value = App.newCar.marca.value.trim();

            App.newCar.ano.error = false;
            App.newCar.ano.messages = [];
            App.newCar.ano.value = App.newCar.ano.value.trim();

            var error = false;

            if (App.newCar.modelo.value == '') {
                error = true;
                App.newCar.modelo.error = true;
                App.newCar.modelo.messages.push('Campo obrigatorio');
            };

            if (App.newCar.marca.value == '') {
                error = true;
                App.newCar.marca.error = true;
                App.newCar.marca.messages.push('Campo obrigatorio');
            };

            if (App.newCar.ano.value == '') {
                error = true;
                App.newCar.ano.error = true;
                App.newCar.ano.messages.push('Campo obrigatorio');
            };

            if (error) {
                App.newCar.error = true;
                App.newCar.messages.push('Verifique todos os campos');
                return;
            }

            axios.get(App.api, {
                params: {
                    action: 'add-car',
                    modelo: App.newCar.modelo.value,
                },
            }).then(req => {
                App.newCar.modelo.value = '';
                App.loadCars();
            });
        },
        removeCar: function (id) {
            axios.get(App.api, {
                params: {
                    action: 'remove-car',
                    id: id,
                },
            }).then(req => {
                App.cancelEditCar();
                App.loadCars();
            });
        },
        selectCar: function (car) {
            App.currentCar.id = car.id;
            App.currentCar.modelo.value = car.modelo;
        },
        cancelEditCar: function () {
            App.currentCar.id = '';
            App.currentCar.modelo.value = '';
        },
        editCar: function () {
            App.currentCar.error = false;
            App.currentCar.messages = [];

            App.currentCar.modelo.error = false;
            App.currentCar.modelo.messages = [];
            App.currentCar.modelo.value = App.currentCar.modelo.value.trim();

            var error = false;

            if (App.currentCar.modelo.value == '') {
                error = true;
                App.currentCar.modelo.error = true;
                App.currentCar.modelo.messages.push('Campo obrigatorio');
            };

            if (error) {
                App.currentCar.error = true;
                App.currentCar.messages.push('Verifique todos os campos');
                return;
            }

            axios.get(App.api, {
                params: {
                    action: 'edit-car',
                    id: App.currentCar.id,
                    modelo: App.currentCar.modelo.value,
                },
            }).then(req => {
                App.cancelEditCar();
                App.loadCars();
            });
        },
    },
});

App.loadCars();
