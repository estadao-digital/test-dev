function remove(id) {

    fetch(url + "/" + id, {
        method: "POST",
        async: false
    })
    .then((response) => {
        return response.json();
    })
    .then((response) => {
        console.log(response);
    });

    get();

}