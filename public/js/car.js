class Car {
    constructor() {
        this._ajax = new Ajax();
    }

    //CRUD functions
    create(request, url = "car") {
        let result = this._ajax.get(url, null, request, "POST");
        return result.responseText;
    };

    retrieve(id = null, url = "car") {
        let result = this._ajax.get(url, id);

        return result.responseJSON;
    };

    update(id, request, url = "car") {
        let result = this._ajax.get(url, id, request, "PUT");
        return result.responseText;
    };

    delete(id, url = "car") {
        let result = this._ajax.get(url, id, null, "DELETE");
        return result.responseText;
    };
}