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
        
        a = document.createElement("button");
        a.setAttribute("id", car.id);
        a.setAttribute("class", "btn btn-primary");
        a.innerText = "Ver/Editar";

        a.addEventListener("click", function(e){
            e.preventDefault();
            RC.LoadUpdateForm(this.getAttribute("id"));
        });


        delete_btn = document.createElement("button");
        delete_btn.setAttribute("class", "btn btn-danger");
        delete_btn.setAttribute("style", "margin-left: 5px");
        delete_btn.setAttribute("id", car.id);
        delete_btn.innerText = "Excluir";
        delete_btn.addEventListener("click", function(e){
            if(confirm("Deseja realmente excluir?")){
                var _id = "#car_" + this.getAttribute("id");
                
                del = RC.DeleteCar(this.getAttribute("id"));
                
                if(del.status){
                    RC.fadeOut(_id, function(car){
                        car.parentNode.removeChild(car);
                    });
                }else{
                    document.querySelector(".resposta").setAttribute("style", "color: red; font-weight: bold;");
                    document.querySelector(".resposta").innerText = response.response;
                    
                    setTimeout(function(){
                        RC.fadeOut(".resposta", RC.getAllCars());
                    }, 1500);
                }
            }
        });

        card_footer.append(a);
        card_footer.append(delete_btn);
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

    xhr.open("PUT", RC.host + "carros/" + document.querySelector("input[name=id]").value, false);

    xhr.send(data);

    var data = new FormData();
    data.append("marca", document.querySelector("input[name=marca]").value);
    data.append("modelo", document.querySelector("input[name=modelo]").value);
    data.append("ano", document.querySelector("input[name=ano]").value);

    if(response.status){
        document.querySelector(".resposta").setAttribute("style", "color: green;font-weight: bold;");
        document.querySelector(".resposta").innerText = response.response;
        
        setTimeout(function(){
            RC.fadeOut(".resposta", RC.LoadHome());
        }, 1500);

    }
    else{
        document.querySelector(".resposta").setAttribute("style", "color: red;font-weight: bold;");
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

    xhr.open("POST", RC.host + "carros", false);

    xhr.send(data);

    if(response.status){
        document.querySelector(".resposta").setAttribute("style", "color: green; font-weight: bold;");
        document.querySelector(".resposta").innerText = response.response;
        
        setTimeout(function(){
            RC.fadeOut(".resposta", RC.LoadHome());
        }, 1000);

    }
    else{
        document.querySelector(".resposta").setAttribute("style", "color: red; font-weight: bold;");
        document.querySelector(".resposta").innerText = response.response;
        
        setTimeout(function(){
            RC.fadeOut(".resposta");
            
        }, 1500);

    }

}

RC.DeleteCar = function(id){
    var xhr = new XMLHttpRequest();
    var response = null;
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            response = JSON.parse(this.responseText);
        }
    });

    xhr.open("DELETE", RC.host + "carros/" + id, false);
    xhr.send();
    return response;
}

RC.LoadHome = function(){
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
    document.querySelector("title").innerText = "Estadão - Home";
    
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

    xhr.open("GET", RC.host + "form", false);
    xhr.send();

    document.querySelector("#content").innerHTML = pagina;
    document.querySelector("#title").innerText = "Novo Carro";
    document.querySelector("title").innerText = "Estadão - Novo Carro";

    document.querySelector("form").addEventListener("submit", function(e){
        e.preventDefault();
        RC.InsertCar();
    });

}

RC.LoadUpdateForm  = function(id){
    var xhr = new XMLHttpRequest();
    var pagina = null;
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            pagina = this.responseText;
        }
    });

    xhr.open("GET", RC.host + "form", false);
    xhr.send();

    document.querySelector("#content").innerHTML = pagina;
    document.querySelector("#title").innerText = "Atualizar Carro";
    document.querySelector("title").innerText = "Estadão - Atualizar Carro";

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

RC.fadeOut = function(target, callback = null) {
    var fadeTarget = document.querySelector(target);
    var fadeEffect = setInterval(function () {
        if (!fadeTarget.style.opacity) {
            fadeTarget.style.opacity = 1;
        }
        if (fadeTarget.style.opacity > 0) {
            fadeTarget.style.opacity -= 0.3;
        } else {
            clearInterval(fadeEffect);
            callback(fadeTarget);
        }
    }, 200);

}

document.addEventListener("DOMContentLoaded", function(event) { 
    RC.LoadHome();
});