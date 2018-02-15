describe("Car Test", function () {
    var car = new Car;
    var id = null;
    var url = "http://localhost/simpleMVC/public/car";

    it("create car", function() {
        let request = {
            "marca": "volks",
            "modelo": "jasmine",
            "ano": 3018
        };

        let response = car.create($.param(request), url);
        
        //get the id
        id = (response != false) ? parseInt(response) : false;
        
        expect(id).not.toEqual(false);
    });
  
    it("get car", function() {
        let response = car.retrieve(null, url);
        let count = 0;

        //get the total
        for(let x in response){
            count++;
        }

        expect(parseInt(count)).toBeGreaterThan(0);
    });

    it("get car by id", function() {
        let response = car.retrieve(id, url);
        let count = 0;

        //get the total
        for(let x in response){
            count++;
        }
    
        expect(parseInt(count)).toBe(1);
    });

    it("update car", function() {
        //set variable
        let request = {
            "marca": "honda",
            "modelo": "jasmine turbo",
            "ano": '2018'
        };

        //set the new values to car
        let response = car.update(id, $.param(request), url);
        
        //get the new values
        response = car.retrieve(id, url);
        
        //test the expect
        expect(response[0].id).toEqual(id);
        expect(response[0].marca).toEqual(request.marca);
        expect(response[0].modelo).toEqual(request.modelo);
        expect(response[0].ano).toEqual(request.ano);
    });

    it("delete car", function() {
        let response = car.delete(id, url);
           
        expect(parseInt(response)).toEqual(1);
    });

    it("delete car by invalid id", function() {
        let response = car.delete(id, url);
                   
        expect(parseInt(response)).toEqual(0);
    });

    it("get car by deleted id", function() {
        let response = car.retrieve(id, url);
        let message = JSON.parse(response).message;

        expect(message).toBe("Id inválido");
    });
});