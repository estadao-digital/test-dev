var RC = {};

RC.host = (document.querySelector("body").getAttribute("host") != undefined) ? document.querySelector("body").getAttribute("host") : "http://localhost/";

RC.getAllCars = function(){
    var xhr = new XMLHttpRequest();

    response = null;
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            response = JSON.parse(this.responseText);
        }
    });

    xhr.open("GET", "http://localhost/carros", false);
    xhr.send();

    for (var index = 0; index < response.response.length; index++) {
        const car = response.response[index];

        car_element = document.createElement("div");
        car_element.setAttribute("id", "car_" + car.id);
        car_element.setAttribute("class", "col-lg-3 col-md-6 mb-4");
        
        card = document.createElement("div");
        card.setAttribute("class", "card h-100");

        card_body = document.createElement("div");
        card_body.setAttribute("class", "card-body");
        card_body.innerHTML = '<h4 class="card-title">' + car.modelo + '</h4><p class="card-text"><b>Marca:</b> ' + car.marca + '</p><p class="card-text"><b>Ano:</b> ' + car.ano + '</p>';

        card_footer = document.createElement("div");
        card_footer.setAttribute("class", "card-footer");
        
        a = document.createElement("a");
        a.setAttribute("id", car.id);
        a.setAttribute("class", "btn btn-primary editar_carro");
        a.innerText = "Ver/Editar";
        
        a.addEventListener("click", function(e){
            e.preventDefault();
            RC.LoadUpdateForm(this.getAttribute("id"));
        });


        card_footer.append(a);

        card.append(card_body);
        card.append(card_footer);
        car_element.append(card);

        document.querySelector(".cars").append(car_element);

    }

}

RC.getCar = function(id){
    var xhr = new XMLHttpRequest();
    
    var response = null;
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            response = JSON.parse(this.responseText);
        }
    });

    xhr.open("GET", "http://localhost/carros/" + id, false);
    xhr.send();
    return response;
}

RC.UpdateCar = function(){

    var data = new FormData();
    data.append("marca", "Teste");
    data.append("modelo", "Teste");
    data.append("ano", "2020");

    var xhr = new XMLHttpRequest();
    var response = null;
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            response = JSON.parse(this.responseText);
        }
    });

    xhr.open("DELETE", "http://localhost/carros/1", false);

    xhr.send(data);
    return response;

}

RC.deleteCar = function(){
    var xhr = new XMLHttpRequest();
    var response = null;
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            response = JSON.parse(this.responseText);
        }
    });

    xhr.open("DELETE", "http://localhost/carros/1", false);

    xhr.send();
    return response;
}

RC.LoadHome = function(){
    console.log("ops")
    var xhr = new XMLHttpRequest();
    var pagina = null;
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            pagina = this.responseText;
        }
    });

    xhr.open("GET", RC.host + "home", false);
    xhr.send();

    document.querySelector("#content").innerHTML = pagina;
    RC.getAllCars();
}

RC.LoadInsertForm = function(id){
    var xhr = new XMLHttpRequest();
    var pagina = null;
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            pagina = this.responseText;
        }
    });

    xhr.open("GET", RC.host + "insert_form", false);
    xhr.send();

}

RC.LoadUpdateForm  = function(id){
    var xhr = new XMLHttpRequest();
    var pagina = null;
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            pagina = this.responseText;
        }
    });

    xhr.open("GET", RC.host + "update_form", false);
    xhr.send();

    document.querySelector("#content").innerHTML = pagina;

    var car = RC.getCar(id).response[0];
    
    document.querySelector("input[name=modelo]").setAttribute("value", car.modelo);
    document.querySelector("input[name=marca]").setAttribute("value", car.marca);
    document.querySelector("input[name=ano]").setAttribute("value", car.ano);
}