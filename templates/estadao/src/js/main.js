var RC = {};

RC.host = (document.querySelector("body").getAttribute("host") != undefined) ? document.querySelector("body").getAttribute("host") : "http://localhost/";

RC.getAllCars = function(){
    var xhr = new XMLHttpRequest();

    response = null;
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            respose = JSON.parse(this.responseText);
        }
    });

    xhr.open("GET", "http://localhost/carros");
    xhr.send();

    return response;
}

RC.getCar = function(id){

    var xhr = new XMLHttpRequest();
    
    var response = null;
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            response = JSON.parse(this.responseText);
        }
    });

    xhr.open("GET", "http://localhost/carros/" + id);
    xhr.send();
    return response;
}

RC.deleteCar = function(){

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

    xhr.open("DELETE", "http://localhost/carros/1");
    xhr.setRequestHeader("cache-control", "no-cache");
    xhr.setRequestHeader("postman-token", "7226111c-93c7-e858-36b1-07ee0b6d1ab8");

    xhr.send(data);
    return response;

}