import { reject } from "lodash";

class Requests{

    
    constructor(){
       this.base_url=this.getUrl();
    }
    async get(db,data={}){
        return new Promise((res,rej)=>{
            var request = $.ajax({
                url: "json/db_"+db+".json",
                method: "GET",
                dataType: "json"
              });
              request.done(function( msg ) {
                 res(msg);
              });
              request.fail(function( jqXHR, textStatus ) {
                reject( "Request failed: " + textStatus );
              });
        })
    }

    async delete(db,id){
        let self=this;
        return new Promise((res,rej)=>{
            var request = $.ajax({
                url: self.getUrl()+"api/"+db+"/delete/"+id,
                method: "DELETE",
                dataType: "json"
              });
               
              request.done(function( msg ) {
                res(msg);
              });
               
              request.fail(function( jqXHR, textStatus ) {
                reject( "Request failed: " + textStatus );
              });
        })
    }

    async show(db,id){
        let self=this;
        return new Promise((res,rej)=>{
            var request = $.ajax({
                url: self.getUrl()+"api/"+db+"/show/"+id,
                method: "GET",
                dataType: "json"
              });
               
              request.done(function( msg ) {
                res(msg);
              });
               
              request.fail(function( jqXHR, textStatus ) {
                reject( "Request failed: " + textStatus );
              });
        })
    }

    async post(db,data){
      let self=this;
      return new Promise((resp,rejec)=>{
        $.ajax({
          url: self.getUrl()+"api/"+db+"/new",
          type: 'post',
          data: data,
          success: function(response) {
            let returned=JSON.parse(response);
            if(returned.hasOwnProperty("success") && returned.success){
              resp(returned);
            }else{
              rejec({"error": returned});
            }
          },
          fail: function(err){
            rejec({"error": err});
          }
      });
    })
    }

    async update(db,data,id){
      let self=this;
      return new Promise((resp,rejec)=>{
        $.ajax({
          url: self.getUrl()+"api/"+db+"/update/"+id,
          type: 'PUT',
          data: data,
          success: function(response) {
            let returned=JSON.parse(response);
            if(returned.hasOwnProperty("success") && returned.success){
              resp(returned);
            }else{
              rejec({"error": returned});
            }
          },
          fail: function(err){
            rejec({"error": err});
          }
      });
    })
    }
    getUrl(){
        return window.location.href;
    }
    
}
export default Requests;