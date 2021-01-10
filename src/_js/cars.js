import Requests from './requests.js';
class Cars{
    constructor(){
        this.requests=new Requests();
    }

   
    async listCars(){
        return new Promise((res,rejec)=>{
        
        this.requests.get("cars").then((response)=>{
           $(".receive_content").html(this.renderCars(response));
           $(".list_car").on("click",(e)=>{
            console.log(".list_car");
            })
            $(".new_car").on("click",(e)=>{
                console.log(".new_car");
            })
           res(true);
        },(error)=>{
            rejec(false);
        })
        })
    }

    async getById(){
        return new Promise((res,rejec)=>{
        this.requests.get("cars").then((response)=>{
            res(true);
        },(error)=>{
            rejec(false);
        })
        })
    }

    renderCars(cars){

        let lineCars=` 
        <div class="row head-cars bg-light">
            <div class="col-md-4"><b>CARRO</b></div>
            <div class="col-md-2"><b>MARCA</b></div>
            <div class="col-md-2"><b>MODELO</b></div>
            <div class="col-md-2"><b>ANO</b></div>
            <div class="col-md-1"></div>
            <div class="col-md-1"></div>
        </div>`;
        cars.map((v,i)=>{
            lineCars+=`
                <div class="cars_lines p-2">
                    <div class="row mt-3">
                        <div class="col-md-4"><span class="d-md-none d-block"><b>CARRO:</b></span>${v.carro}</div>
                        <div class="col-md-2"><span class="d-md-none d-block"><b>MARCA:</b></span>${v.marca}</div>
                        <div class="col-md-2"><span class="d-md-none d-block"><b>MODELO:</b></span>${v.modelo}</div>
                        <div class="col-md-2"><span class="d-md-none d-block"><b>ANO:</b></span>${v.ano}</div>
                        <div class="col-md-1 edit_car" data-value="${v.id}"><img src="dist/imgs/pencil.svg"></div>
                        <div class="col-md-1 delete_car" data-value="${v.id}"><img src="dist/imgs/trash.svg"></div>
                    </div>
                </div>
            `;
        })

        return lineCars;
        }

}

export default Cars;