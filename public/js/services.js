class Ajax {
    get(controller = null, id = null, data = null, method = "GET") {
        let url = controller + "/";
        url += (id != null) ? "/" + id : "";

        let ajax = $.ajax({
            url: url,
            data: data,
            method: method,
            dataType: 'json',
            contentType: "application/x-www-form-urlencoded", 
            async: false,
        });

        return ajax;
    }
}