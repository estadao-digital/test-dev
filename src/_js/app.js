import Cars from './cars.js';

class App{
    constructor(){
        this.cars=new Cars();
        this.boot();
        
        
    }

    boot(){
        $(".nav_list_car").on("click",(e)=>{
            this.cars.listCars().then((res)=>{});
        })
        $(".new_car").on("click",(e)=>{
            $("#carsModal").modal("show");

            this.cars.renderNewCar().then((res)=>{
            });
            
        })
         this.cars.listCars().then((res)=>{});
         
      
    }
}

$( document ).ready(function() {
    new App();
});