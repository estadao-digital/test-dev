class FormCar {
    getValues() {
        let dataValues = {
            "id": null,
            "marca": $("select[name=marca] option:selected").val(),
            "modelo": $("input[name=modelo]").val(),
            "ano": $("input[name=ano]").val()
        }

        if(dataValues.marca == "" || dataValues.ano == ""){
            return false;
        }

        return dataValues;
    };
    
    getId() {
        let id = $("input[name=id]").val();

        return id;
    };

    clean() {
        $("input[name=id]").val("");
        $("input[name=modelo]").val("");
        $("input[name=ano]").val("");
        
        $("select[name=marca]").val(
            $("select[name=marca] option:first").val()
        );
    };

    set(request) {
        $("input[name=id]").val(request[0].id);

        $("input[name=modelo]").val(request[0].modelo);
        $("input[name=ano]").val(request[0].ano);
        
        $("select[name=marca]").val(request[0].marca);
    };
}