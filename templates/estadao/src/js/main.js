var RC = {};

RC.host = (document.querySelector("body").getAttribute("host") != undefined) ? document.querySelector("body").getAttribute("host") : "http://localhost/";

RC.getAllCars = function(){
    var xhr = new XMLHttpRequest();

    var cars = [];
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            cars = JSON.parse(this.responseText);
        }
    });

    xhr.open("GET", "http://localhost/carros");
    xhr.send();
    return cars;
}

RC.getCar = function(id){

    var xhr = new XMLHttpRequest();
    var cars = [];
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            cars = JSON.parse(this.responseText);
        }
    });

    xhr.open("GET", "http://localhost/carros/" + id);
    xhr.send();
    return cars[0];
}