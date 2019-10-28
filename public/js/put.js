function put(id, brand, model, year) {

    let dados = {
        id: id,
        brand: brand,
        model: model,
        year: year
    }

    console.log(JSON.stringify(dados))

    fetch(url + "/" + id, {
        method: "POST",
        async: false,
        body: JSON.stringify(dados)
    })
    .then((response) => {
        return response.json();
    })
    .then((response) => {
        console.log(response);
    });

    get();

}