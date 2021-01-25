mostraMarcas()

function mostraMarcas() {
    marcasPromise = promiseMarcas()

    $('#marcas_lista').append('<select name="marcas" id="marca_id_valor"></select>')
    marcasPromise.then(dados => {
        dados.data.forEach(item => {
            $('#marca_id_valor').append(`<option value="${item.id}">${item.nome}</option>`) 
        })
    })
}

function promiseMarcas() {
    return axios.get('/marcas')
}

const promiseCarros = () => {
    return axios.get('/carros')
}

const mostraCarros = () => {
    carrosPromise = promiseCarros()

    carrosPromise.then(dados => {
        dados.data.forEach(item => {
            
        });
    })
}

const axiosPost = (rota, dados) => {
    return axios({
        method: 'post',
        url: rota,
        data: dados
    })
}

const adicionaCarro = () => {
    const campos = ['modelo', 'marca_id', 'ano']
    let carro = {}
    campos.forEach(item => {
        elemento = $(`#${item}_valor`)[0]
        carro[item] = !elemento ? '' : elemento.value
    })

    const resposta = axiosPost('/carros', carro)
    resposta.then(dado => { console.log(dado.data) })
}

const editaCarro = () => {
    const campos = ['id', 'modelo', 'marca_id', 'ano']
    let carro = {}
    campos.forEach(item => {
        elemento = $(`#${item}_valor`)[0]
        carro[item] = !elemento ? '' : elemento.value
    })

    const resposta = axiosPost('/edita_carros', carro)
    resposta.then(dado => { console.log(dado.data) })
}

const deletaCarro = () => {
    const campos = ['id']
    let carro = {}
    campos.forEach(item => {
        elemento = $(`#${item}_valor`)[0]
        carro[item] = !elemento ? '' : elemento.value
    })

    const resposta = axiosPost('/deleta_carros', carro)
    resposta.then(dado => { console.log(dado.data) })
}
