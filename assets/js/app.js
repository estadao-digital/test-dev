const Requests = require('requests.js');

class App{
    constructor(){
        this.boot();
    }

    boot(){
        new Requests();
        Requests.get();
    }
}

$( document ).ready(function() {
    new App();
});