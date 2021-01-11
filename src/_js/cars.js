import Requests from './requests.js';
import Swal from 'sweetalert2'
import Spinner from "./components/spinner";

class Cars{
    
    constructor(){
        this.requests=new Requests();
        this.Spinner=new Spinner();
    }

   
    async listCars(){
        let self=this;
        return new Promise((res,rejec)=>{
            this.requests.get("cars").then((response)=>{
                $(".receive_content").html(this.renderCars(response));
                response ? self.eventsForList() : null;
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

    deleteCar(id){
        console.log("class deleteCar");

        let self=this;
        self.carId=id;
        Swal.fire({
            title: 'Você esta certo sobre deletar?',
            text: "Esta ação será irreversível",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Não',
            confirmButtonText: 'Sim, vamos em frente!'
          }).then((result) => {
            if (result.isConfirmed) {
                new Promise((res,rejec)=>{
                    this.requests.delete("cars",id).then((response)=>{
                        if(response.success){
                            let element=$("#line_"+self.carId);
                            element.hide("fade");
                            setTimeout(() => {
                                element.remove()
                            }, 2000);
                        }
                        res(response);
                    },(error)=>{
                        rejec(false);
                    })
                    })
               
            }
          })
    }

    renderCars(cars){
        let self=this;
        let lineCars=` 
        <div class="row head-cars ">
            <div class="col-md-4"><b>CARRO</b></div>
            <div class="col-md-2"><b>MARCA</b></div>
            <div class="col-md-2"><b>MODELO</b></div>
            <div class="col-md-2"><b>ANO</b></div>
            <div class="col-md-1"></div>
            <div class="col-md-1"></div>
        </div>`;
        $.each(cars,(i,v)=>{
            let bg="bg_even";
            i % 2 == 0 ? bg="bg_odd" : null;
            lineCars+=  self.newRowList(bg,v.id,v.carro,v.marca,v.modelo,v.ano);
        })

        return lineCars;
    }

    newRowList(bg,id,carro,marca,modelo,ano){
        return `
        <div class="cars_lines pt-2 pb-2 ${bg}" id="line_${id}">
            ${this.contentNewRowList(id,carro,marca,modelo,ano)}
        </div>
    `;

    }

    contentNewRowList(id,carro,marca,modelo,ano){
        return `<div class="row  p-3">
                    <div class="col-md-4"><span class="d-md-none d-block"><b>CARRO:</b></span>${carro}</div>
                    <div class="col-md-2"><span class="d-md-none d-block"><b>MARCA:</b></span>${marca}</div>
                    <div class="col-md-2"><span class="d-md-none d-block"><b>MODELO:</b></span>${modelo}</div>
                    <div class="col-md-2"><span class="d-md-none d-block"><b>ANO:</b></span>${ano}</div>
                    <div class="col-md-1" ><img class="edit_car" data-value="${id}" src="dist/imgs/pencil.svg"></div>
                    <div class="col-md-1" ><img class="delete_car" data-value="${id}" src="dist/imgs/trash.svg"></div>
                </div>`;
    }
    async renderNewCar(){
        let self=this;
       $(".car_name").html=("Novo Carro");
        return new Promise((resp,rej)=>{
            self.requests.get("brands").then((res)=>{
            let formContent=self.renderModal(res);
            $(".receive_modal").html(formContent);

            $("#car_form" ).submit(function( event ) {
                event.preventDefault();
                let TypeAction=$('[name ="type_action"]').val();
            
                    self.requests.post("cars",$("#car_form").serialize()).then((res)=>{
                        let btnForm=$(".btn_form");
                        btnForm.attr('disabled','disabled');
                        btnForm.html(self.Spinner.spinner());
                       if(res.hasOwnProperty('success') && res.success){
                            let getCar=res.data;
                            btnForm.attr('disabled',false);
                            btnForm.html("Salvar");
                            $(".receive_content").append(self.newRowList("bg-info",getCar.id,getCar.carro,getCar.marca,getCar.modelo,getCar.ano));
                            self.eventsForList();
                        }
                    },(err)=>{
                        self.modalInfo(err.error,"danger");
                    })
              
              });
           resp(formContent);
        })
        })
        
    }

    async renderEditCar(id){
        let self=this;
        this.requests.show("cars",id).then((res_carro)=>{
            res_carro=res_carro.data;
            $(".car_name").html("Editando Carro "+res_carro.carro);
        
            return new Promise((resp,rej)=>{
                self.requests.get("brands").then((res)=>{
                let formContent=self.renderModal(res,res_carro);
                
                $(".receive_modal").html(formContent);
    
                $("#car_form" ).submit(function( event ) {
                    event.preventDefault();
                    let TypeAction=$('[name ="type_action"]').val();
                        self.requests.update("cars",$("#car_form").serialize(),id).then((res)=>{
                            let btnForm=$(".btn_form");
                            btnForm.attr('disabled','disabled');
                            btnForm.html(self.Spinner.spinner());
                           if(res.hasOwnProperty('success') && res.success){
                                let getCar=res.data;
                                self.afterUpdate(id,getCar,btnForm);
                            }
                        },(err)=>{
                            self.modalInfo(err.error,"danger");
                        })
                   
                  
                  });
               resp(formContent);
            })
            }) 
        })
        
        
    }
    renderModal(res_marcas,res_carro={}){
        let formContent=` 
        <div class="error_form"></div>
        <form id="car_form">
        <input type="hidden" id="typeAction" value="${res_carro.hasOwnProperty("carro") ? "edit" : "create"}">
            <div class="mb-3">
                <label for="cars_input" class="form-label">Carro</label>
                <input type="text" class="form-control" id="cars_input" name="carro" value="${res_carro.hasOwnProperty("carro") ? res_carro.carro : ""}">
            
                </div>
            <div class="mb-3">
                <label for="brands_input" class="form-label">Marcas</label>
                <select class="form-control" id="brands_input" name="marca" >`;
                
                    $.each(res_marcas,(i,v)=>{

                        formContent+=`<option ${res_carro.hasOwnProperty("marca") && res_carro.marca== v.name ? 'selected' : ""} value="${v.name}">${v.name}</option>`;
                    })
            
                formContent+=` 
                </select>
            </div>
            <div class="mb-3">
                <label for="model_input" class="form-label">Modelo</label>
                <input type="text" class="form-control" id="model_input" name="modelo" value="${res_carro.hasOwnProperty("modelo") ? res_carro.modelo : ""}">
            </div>
            <div class="mb-3 ">
                <label for="year_input" class="form-label">Ano</label>
                <select class="form-control" id="year_input" name="ano" >`;
                
                for(let i=new Date().getFullYear();i>1950;i--){
                    formContent+=`<option ${res_carro.hasOwnProperty("ano") && res_carro.ano== i ? 'selected' : null} value="${i}">${i}</option>`;
                }
        
            formContent+=` 
            </select>
            
                </div>
            <button type="submit" class="w-100 btn btn-primary btn_form">Salvar</button>
        </form>`;

        return formContent;
    }

    eventsForList(){
        let self=this;
        $(".edit_car").unbind();
        $(".edit_car").on("click",(e)=>{
            $("#carsModal").modal("show");
            self.renderEditCar($(e.target).data("value"));
        })
        $(".delete_car").unbind();
        $(".delete_car").on("click",(e)=>{
            self.deleteCar($(e.target).data("value"));
           
        })
    }

    afterUpdate(id,getCar,btnForm){
        let element=$("#line_"+id);
        let ActualBg;

        btnForm.attr('disabled',false);
        btnForm.html("Salvar");
        
        $("#carsModal").modal("hide");
        element.hasClass("bg_even") ? ActualBg="bg_odd" : "bg-white";
        element.switchClass(ActualBg, "bg-custom", 100, "easeInOutQuad" );
        setTimeout(() => {
            element.switchClass("bg-custom", ActualBg, 100, "easeInOutQuad" )
        }, 1000);

        element.html(this.contentNewRowList(id,getCar.carro,getCar.marca,getCar.modelo,getCar.ano));
       
       
       

        this.eventsForList();
        this.cleanForm();
        }

    cleanForm(){
        $('#car_form')[0].reset();
        //$("#car_form").trigger("reset");
    }

    modalInfo(msn,type){
        let self=this;
        let n_msn=``;
        $.each(msn,(i,v)=>{
            n_msn+="<b>"+self.capitalize(i)+"</b> "+v+"<br>";
        })
        console.log(n_msn);
        $(".error_form").attr('class','error_form alert alert-'+type)
        $(".error_form").html(n_msn);
        $(".error_form").show("fade");
        setTimeout(function(){ $(".error_form").hide("fade"); }, 5000);
    }

     capitalize(s){
        if (typeof s !== 'string') return ''
        return s.charAt(0).toUpperCase() + s.slice(1)
      }

}

export default Cars;