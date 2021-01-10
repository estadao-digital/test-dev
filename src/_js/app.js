import Cars from './cars.js';

class App{
    constructor(){
        this.cars=new Cars();
        this.boot();
        
    }

    boot(){
         this.cars.listCars().then((res)=>{
             if(res){
                $(".edit_car").on("click",(e)=>{
                    console.log(".edit_car");
                })
                $(".delete_car").on("click",(e)=>{
                    console.log(".delete_car");
                })
               
             }
            
        });
      
    }
}

$( document ).ready(function() {
    new App();
});