import { reject } from "lodash";

class Requests{
    async get(db,data={}){
        return new Promise((res,rej)=>{
            let url="json/db_"+db+".json";
            console.log(url);
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

    
}
export default Requests;