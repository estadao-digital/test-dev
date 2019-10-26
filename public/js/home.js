var App = new Vue({
    el: '#AppVue',
    data: {
        api: '/api/carros/',

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
    },
    methods: {
        loadCars: function () {
            App.cars.loading = true;

            axios.get(App.api).then(req => {
                App.cars.list = [];

                for (var i in req.data.data) {
                    App.cars.list.push(req.data.data[i]);
                }

                App.cars.loading = false;
            });
        },
        addCar: function () {
            Swal.fire({
                title: 'Deseja confirmar?',
                text: "Será salvo um novo carro",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4cae4c',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim'
            }).then((result) => {
                if (result.value) {
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

                    axios.post(App.api, {
                        modelo: App.newCar.modelo.value,
                        marca: App.newCar.marca.value,
                        ano: App.newCar.ano.value,
                    }).then(req => {
                        App.newCar.modelo.value = '';

                        if(req.data.error != undefined) {
                            App.newCar.error = true;
                            App.newCar.messages = [req.data.msg];
                            for(var i in req.data.error) {
                                App.newCar[i].error = true;
                                App.newCar[i].messages.push(req.data.error[i].join(' | '));
                            }
                        } else {
                            Swal.fire({
                                title: 'Sucesso!',
                                text: req.data.msg,
                                type: 'success',
                                confirmButtonColor: '#00ff00'
                            });
                            $("#salvarModal").modal('toggle');
                        }
                        App.resetCar();
                        App.loadCars();
                    });
                }
            });

        },
        removeCar: function (id) {
            Swal.fire({
                title: 'Deseja confirmar?',
                text: "As alterações não serão revertidas",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4cae4c',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim'
            }).then((result) => {
                if (result.value) {
                    if(id == "") {
                        Swal.fire({
                            title: 'Erro',
                            text: 'Erro ao tentar enviar a solicitação para remover o carro',
                            type: 'danger'
                        });
                        return;
                    }
                    axios.delete(App.api + id).then(req => {
                        Swal.fire({
                            title: 'Sucesso',
                            text: req.data.msg,
                            type: 'success',
                            confirmButtonColor: '#4cae4c'
                        }).then((result) => {
                            App.loadCars();
                        });
                    });
                }
            })

        },
        resetCar: function() {
            App.newCar.modelo.value = '';
            App.newCar.marca.value = '';
            App.newCar.ano.value = '';
        },
        selectCar: function (car) {
            App.currentCar.id = car.id;
            App.currentCar.modelo.value = car.modelo;
            App.currentCar.marca.value = car.marca;
            App.currentCar.ano.value = car.ano;
        },
        editCar: function () {
            Swal.fire({
                title: 'Deseja confirmar?',
                text: "As alterações não serão revertidas",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4cae4c',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim'
            }).then((result) => {
                App.currentCar.error = false;
                App.currentCar.messages = [];

                App.currentCar.modelo.error = false;
                App.currentCar.modelo.messages = [];
                App.currentCar.modelo.value = App.currentCar.modelo.value.trim();

                App.currentCar.marca.error = false;
                App.currentCar.marca.messages = [];
                App.currentCar.marca.value = App.currentCar.marca.value.trim();

                App.currentCar.ano.error = false;
                App.currentCar.ano.messages = [];
                App.currentCar.ano.value = App.currentCar.ano.value.trim();


                var error = false;

                if (App.currentCar.modelo.value == '') {
                    error = true;
                    App.currentCar.modelo.error = true;
                    App.currentCar.modelo.messages.push('Campo obrigatorio');
                };

                if (App.currentCar.marca.value == '') {
                    error = true;
                    App.currentCar.marca.error = true;
                    App.currentCar.marca.messages.push('Campo obrigatorio');
                };

                if (App.currentCar.ano.value == '') {
                    error = true;
                    App.currentCar.ano.error = true;
                    App.currentCar.ano.messages.push('Campo obrigatorio');
                };

                if (error) {
                    App.currentCar.error = true;
                    App.currentCar.messages.push('Verifique todos os campos');
                    return;
                }

                if (result.value) {
                    axios.put(App.api + App.currentCar.id, {
                        modelo: App.currentCar.modelo.value,
                        marca: App.currentCar.marca.value,
                        ano: App.currentCar.ano.value,
                    }).then(req => {

                        if(req.data.error != undefined) {
                            App.currentCar.error = true;
                            App.currentCar.messages = [req.data.msg];
                            for(var i in req.data.error) {
                                App.currentCar[i].error = true;
                                App.currentCar[i].messages.push(req.data.error[i].join(' | '));
                            }
                        } else {
                            Swal.fire({
                                title: 'Sucesso!',
                                text: req.data.msg,
                                type: 'success',
                                confirmButtonColor: '#4cae4c'
                            });
                            $("#editarModal").modal('toggle');
                            App.loadCars();
                        }
                    });
                }
            });

        },
    },
});

$("#iptAno").mask('9999');
App.loadCars();
