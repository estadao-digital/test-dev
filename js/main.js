const promiseCarros = () => {
    return axios.get('/carros')
}

const mostraCarros = () => {
    carrosPromise = promiseCarros()

    carrosPromise.then(dados => {
        dados.data.forEach(item => {
            console.log(item)
        });
    })
}

const promiseMarcas = () => {
    return axios.get('/marcas')
}

const mostraMarcas = () => {
    marcasPromise = promiseMarcas()

    marcasPromise.then(dados => {
        dados.data.forEach(item => {
            console.log(item)
        });
    })
}