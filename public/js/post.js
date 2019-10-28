let brand   = document.querySelector('#brand');
let model   = document.querySelector('#model');
let year    = document.querySelector('#year');
let form    = document.querySelector('#form');

form.addEventListener("submit", (event)=>{
    event.preventDefault();

    let dados = {
        brand: brand.value,
        model: model.value,
        year: year.value
    }

    fetch(url, {
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

})
