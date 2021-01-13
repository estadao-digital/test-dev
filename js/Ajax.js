let Ajax = {
    get: (url, callback) => {
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4) {
                callback(xhr.responseText);
            }
        }
        xhr.open('get', url, true);
        xhr.send();
    },
};