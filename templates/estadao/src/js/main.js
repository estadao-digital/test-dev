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
    var data = new FormData(document.querySelector("form"));

    var xhr = new XMLHttpRequest();
    var response = null;
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            response = JSON.parse(this.responseText);
        }
    });

    xhr.open("PUT", "http://localhost/carros/" + document.querySelector("input[name=id]").value, false);

    xhr.send(data);


    var data = new FormData();
    data.append("marca", document.querySelector("input[name=marca]").value);
    data.append("modelo", document.querySelector("input[name=modelo]").value);
    data.append("ano", document.querySelector("input[name=ano]").value);

    // var xhr = new XMLHttpRequest();
    // xhr.withCredentials = true;

    // xhr.addEventListener("readystatechange", function () {
    // if (this.readyState === 4) {
    //     console.log(this.responseText);
    // }
    // });

    // xhr.open("PUT", "http://localhost/carros/" + document.querySelector("input[name=id]").value);
    // xhr.setRequestHeader("cache-control", "no-cache");
    // xhr.setRequestHeader("postman-token", "07c553f1-2d65-07bf-50c3-17f994c9e839");

    // xhr.send(data);




    if(response.status){
        document.querySelector(".resposta").setAttribute("style", "color: green");
        document.querySelector(".resposta").innerText = response.response;
        
        setTimeout(function(){
            RC.fadeOut(".resposta");
            setTimeout(function(){
                RC.LoadHome();
            }, 2000);
        }, 1500);

    }
    else{
        document.querySelector(".resposta").setAttribute("style", "color: red");
        document.querySelector(".resposta").innerText = response.response;
        
        setTimeout(function(){
            RC.fadeOut(".resposta");
            
        }, 1500);

    }
}

RC.InsertCar = function(){
    var data = new FormData(document.querySelector("form"));

    var xhr = new XMLHttpRequest();
    var response = null;
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            response = JSON.parse(this.responseText);
        }
    });

    xhr.open("POST", "http://localhost/carros", false);

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
    
    document.querySelector("input[name=id]").setAttribute("value", car.id);
    document.querySelector("input[name=modelo]").setAttribute("value", car.modelo);
    document.querySelector("input[name=marca]").setAttribute("value", car.marca);
    document.querySelector("input[name=ano]").setAttribute("value", car.ano);

    document.querySelector("form").addEventListener("submit", function(e){
        e.preventDefault();
        RC.UpdateCar();
    });

}

RC.fadeOut = function(target) {
    var fadeTarget = document.querySelector(target);
    var fadeEffect = setInterval(function () {
        if (!fadeTarget.style.opacity) {
            fadeTarget.style.opacity = 1;
        }
        if (fadeTarget.style.opacity > 0) {
            fadeTarget.style.opacity -= 0.1;
        } else {
            clearInterval(fadeEffect);
        }
    }, 200);
}