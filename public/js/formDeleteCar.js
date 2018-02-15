class FormDeleteCar {
    constructor() {

    };

    set(request) {
        let id = request[0].id;
        let message = "";

        message += `Tem certeza que deseja excluir ${request[0].marca} - ${request[0].modelo} - ${request[0].ano}?`;    
        
        $(".formModal .messageDelete").append(message);
        $(".formModal input[name=id]").val(id);
    };
    
    show() {
        $(".modal").css("display", "flex");
    };

    hide() {
        $(".modal").css("display", "none");
    };

    getId() {
        let id = $("input[name=id]").val();
        return id;
    };

    clean() {
        $(".formModal .messageDelete").empty();
        $(".formModal input[name=id]").val(null);
    };
}