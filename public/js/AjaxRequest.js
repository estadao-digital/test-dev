function AjaxRequest() {

    this.getJSON = getJSON;

    function getJSON(url, reqType) {
        reqType = reqType || 'get';
        return new Promise(function(resolve, reject) {
            var xhr = new XMLHttpRequest();
            xhr.open(reqType, url, true);
            xhr.responseType = 'json';
            xhr.onload = function() {
                var status = xhr.status;
                if (status == 200) {
                    resolve(xhr.response);
                } else {
                    reject(status);
                }
            };
            xhr.send();
        });
    };
}
