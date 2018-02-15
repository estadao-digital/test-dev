class App {
    constructor() {
        this._car = new Car;
        this._table = new Table;
        this._formCar = new FormCar;
        this._formDeleteCar = new FormDeleteCar;

        this.listCar();
    };

    listCar() {
        this._table.clean();
        this._table.setTable(this._car.retrieve());
    };

    getCar(id = null) {
        return this._car.retrieve(id);
    };

    addCar() {
        let dataValues = this._formCar.getValues();
        let id = this._formCar.getId();

        if(dataValues) {
            if (id == "null") {
                this._car.create(dataValues);
            } else {
                this._car.update(id, dataValues);
            }

            this._formCar.clean();

            return dataValues;
        };
    };


    deleteCar(id = null) {
        this._car.delete(id);
        this.unsetFormDeleteCar();
        this.listCar();
    };

    unsetFormDeleteCar() {
        this._formDeleteCar.clean();
        this._formDeleteCar.hide();
    }
}

$(function () {
    // Instantiate Main class
    var app = new App();

    // Get all cars and set to the table
    app.listCar();

    /****** Event Listeners *******/
    // Before submit car form
    $("#addForm").submit(function (event) {
        event.preventDefault();
        app.addCar();
        app.listCar();
    });

    // Delete car
    $("#removeCar").click(function () {
        event.preventDefault();
        let id = $(".formModal input[name=id]").val();

        app.deleteCar(id);
    });

    // Close the modal to delete car
    $("#closeModal").click(function () {
        event.preventDefault();

        app.unsetFormDeleteCar();
    });
});