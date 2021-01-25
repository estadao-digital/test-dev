mostraCarros()

function mostraCarros(){
    carrosPromise = promiseCarros()
    marcasPromise = promiseMarcas()

    $('#carros_container')[0].innerHTML = ''
    carrosPromise.then(dados => {
        dados.data.forEach(carro => {
            geraElementoCarro(carro, marcasPromise)
        });
        geraCarroVazio()
    })
}

function promiseCarros(){
    return axios.get('/carros')
}

function promiseMarcas() {
    return axios.get('/marcas')
}

function axiosPost(rota, dados){
    return axios({
        method: 'post',
        url: rota,
        data: dados
    })
}

function geraElementoCarro(carro, marcasPromise){
    count = $('.marca_id_valor').size() + 1
    let elemento = `<div id="carro${count}">`+
    `<input disabled class="modelo_valor" id="modelo${count}" type="text" value="${carro.modelo}">`+
    `<select disabled value="${carro.marca_id}" class="marca_id_valor" id="marca_id${count}"></select>`+
    `<input disabled class="ano_valor" id="ano${count}" type="text" placeholder="digite o ano" value="${carro.ano}">`+
    `<button id="habilita${count}" class="habilita" onClick="habilitaEdicao(${count});">Edita</button>`+
    `<button id="edita${count}" class="edita" onClick="editaCarro(${count}, ${carro.id});">Confirma</button>`+
    `<button onClick="deletaCarro(${carro.id});">Deleta</button>`+
    '</div>'
    selectMarcas(marcasPromise, count)
    
    $('#carros_container').append(elemento)
}

function selectMarcas(marcasPromise, count) {
    marcasPromise.then(dados => {
        dados.data.forEach(item => {
            $(`#marca_id${count}`).append(`<option value="${item.id}">${item.nome}</option>`) 
        })
        refreshMarcas()
    })
}

function refreshMarcas() {
    const carros_size = $('#carros_container').children().size()
    for(i = 1; i <= carros_size; i++) {
        $(`#marca_id${i}`)[0].value = $(`#marca_id${i}`)[0].getAttribute("value")
    }
}

function geraCarroVazio() {
    count = $('.marca_id_valor').size() + 1
    let elemento = `<div>`+
    `<input class="modelo_valor" type="text" id="modelo${count}" placeholder="Insira o modelo">`+
    `<select class="marca_id_valor" id="marca_id${count}"></select>`+
    `<input class="ano_valor" type="text" id="ano${count}" placeholder="Insira o ano">`+
    `<button onClick="adicionaCarro(${count})">Adiciona</button>`+
    '</div>'
    selectMarcas(marcasPromise, count)
    
    $('#carros_container').append(elemento)
}

const adicionaCarro = numero => {
    const campos = ['modelo', 'marca_id', 'ano']
    let carro = {}
    campos.forEach(item => {
        elemento = $(`#${item}${numero}`)[0]
        carro[item] = !elemento ? '' : elemento.value
    })

    const resposta = axiosPost('/carros', carro)
    resposta.then(dado => { console.log(dado.data) })

    mostraCarros()
}

const habilitaEdicao = numero => {
    const campos = ['modelo', 'ano', 'marca_id']
    campos.forEach(item => $(`#${item}${numero}`).removeAttr('disabled'))
    $(`#habilita${numero}`).css('display', 'none')
    $(`#edita${numero}`).css('display', 'block')
}

const editaCarro = (numero, id) => {
    const campos = ['modelo', 'ano', 'marca_id']
    let carro = { id: id }
    campos.forEach(item => {
        elemento = $(`#${item}${numero}`)[0]
        carro[item] = !elemento ? '' : elemento.value
    })

    const resposta = axiosPost('/edita_carros', carro)
    resposta.then(dado => { console.log(dado.data) })

    mostraCarros()
}

const deletaCarro = id => {
    const carro = { id: id }

    const resposta = axiosPost('/deleta_carros', carro)
    resposta.then(dado => { console.log(dado.data) })

    mostraCarros()
}
