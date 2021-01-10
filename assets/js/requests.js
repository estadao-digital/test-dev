class Requests{
    async get(db){
        new Promise((res.rej),function(){
            $.ajax({
                url: 'json/db_'+db+'.json',
                type: 'GET',
                success: function(result) {
                 console.log(result);
                }
            });
        })
    }
}
module.exports = Requests;