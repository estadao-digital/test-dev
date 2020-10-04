/*
 * Exibir dados dos carros via tela
 */
document.addEventListener('DOMContentLoaded', function() {
    
    exibirCarros()

}, false)

/*
 * Gravar dados do carro via tela
 */
document.getElementById("btn-salvar-carro").addEventListener("click", function(e) {
    e.preventDefault()

    // Elementos da tela
    const modelo = document.getElementById('input-modelo')
    const ano = document.getElementById('input-ano')
    const marcaId = document.getElementById('input-marca')
    const marca = getMarcaCarroById(marcaId.value)

    // Dados de comunicação e transmissão
    const url = "/test-dev/api/carro/"
    let formData = new FormData()
    
    // Criando o corpo da requisição
    formData.append('marca', marca)
    formData.append('modelo', modelo.value)
    formData.append('ano', ano.value)

    // Requisição de gravação para a API
    fetch(url, {
        body: formData,
        method: 'POST'
    }).then(() => {
        
        // Atualiza a tela com os carros
        exibirCarros()

        // Limpa o formulário
        ano.value = ""
        modelo.value = ""
        marcaId.value = ""

        // Mensagem de sucesso
        setMensagemSucesso("Carro cadastrado com sucesso!")
        
    })

})

/*
 * Função para exibir os carros 
 */
function exibirCarros() {

    const div = document.getElementById('lista-carros')
    div.innerHTML = ""

    const url = '/test-dev/api/carro/'

    fetch(url)
    .then((resp) => resp.json())
    .then(function(data){
        
        for(var info in data){
        
            const carro = data[info]
            const id = carro.id
            const modelo = capitalizarPrimeiraLetra(carro.modelo)
            const marca = capitalizarPrimeiraLetra(carro.marca)
            const ano = carro.ano
        
            div.innerHTML += '<div class="col-sm-4">' +
            '<div class="card mb-5" style="width: 18rem;">' +
                '<img src="img/carro.jpg" class="card-img-top" alt="Imagem de um carro">' +
                '<div class="card-body">' +
                    '<input type="hidden" value="' + id + '">' +
                    '<input id="input-modelo-' + id + '" type="text" class="form-control input-edicao" value="' + modelo + '" hidden>' +
                    '<select id="input-marca-'+ id +'"  class="form-control input-edicao" placeholder="Selecione..." hidden>' +
                    '<option value="" disabled selected>Selecione...</option>' +
                        '<option value="1">Chevrolet</option>' +
                        '<option value="2">Volkswagen</option>' +
                        '<option value="3">Fiat</option>' +
                        '<option value="4">Renault</option>' +
                        '<option value="5">Ford</option>' +
                        '<option value="6">Toyota</option>' +
                        '<option value="7">Hyundai</option>' +
                        '<option value="8">Jeep</option>' +
                        '<option value="9">Honda</option>' +
                        '<option value="10">Nissan</option>' +
                        '<option value="11">Citroën</option>' +
                        '<option value="12">Peugeot</option>' +
                    '</select>' +
                    '<input id="input-ano-' + id + '" type="text" class="form-control input-edicao" value="' + ano + '" hidden>' +
                    '<h5 id="texto-modelo-'+ id +'" class="card-title">' + modelo + '</h5>' +
                    '<p id="texto-marca-'+ id +'" class="card-text">' + marca + '</p>' +
                    '<p id="texto-ano-'+ id +'">' + ano + '</p>' +
                    '<a href="#" id="btn-edicao-'+ id +'" id-alteracao="'+ id +'" class="btn btn-primary btn-alterar-carro">Editar</a>' +
                    '<a href="#" id="btn-atualizacao-'+ id +'" id-atualizacao="'+ id +'" class="btn btn-success btn-atualizar-carro" hidden>Atualizar</a>' +
                    ' ' +
                    '<a href="#" id-exclusao="'+ id +'" class="btn btn-danger btn-excluir-carro">Excluir</a>' +
                '</div>' +
            '</div>' +
            '</div>'

        }

        /*
         * Define instruções para excluir carro
         */
        excluirCarro()

        /*
         * Define instruções para alterar carro
         */
        alterarCarro()

    })

}

/*
 * Função para excluir um carro
 */
function excluirCarro() {
    document.querySelectorAll('.btn-excluir-carro').forEach(item => {
        item.addEventListener('click', e => {
            e.preventDefault()
        
            const idCarro = item.getAttribute('id-exclusao')
            
            const url = '/test-dev/api/carro/' + idCarro
        
            // Requisição de gravação para a API
            fetch(url, {
                method: 'DELETE'
            }).then(() => {
                
                // Atualiza a tela com os carros
                exibirCarros()
                
                // Mensagem de sucesso
                setMensagemSucesso("Carro excluído com sucesso!")
            })

        })
    })
}

/*
 * Função para alterar um carro
 */
function alterarCarro() {
    document.querySelectorAll('.btn-alterar-carro').forEach(item => {
        item.addEventListener('click', e => {
            e.preventDefault()
        
            const idCarro = item.getAttribute('id-alteracao')
            
            // Exibe as inputs no card da tela, para edição
            const inputModelo = document.getElementById('input-modelo-' + idCarro)
            const inputAno = document.getElementById('input-ano-' + idCarro)
            const inputMarca = document.getElementById('input-marca-' + idCarro)
            const botaoAtualizar = document.getElementById('btn-atualizacao-' + idCarro)
            
            inputModelo.hidden = false
            inputAno.hidden = false
            inputMarca.hidden = false
            botaoAtualizar.hidden = false

            // Oculta os textos
            const textoModelo = document.getElementById('texto-modelo-' + idCarro)
            const textoAno = document.getElementById('texto-ano-' + idCarro)
            const textoMarca = document.getElementById('texto-marca-' + idCarro)
            const botaoEditar = document.getElementById('btn-edicao-' + idCarro)

            textoModelo.hidden = true
            textoAno.hidden = true
            textoMarca.hidden = true
            botaoEditar.hidden = true
    
            // Define select
            const marcaCarro = getMarcaCarroByNome(textoMarca.innerHTML)
            inputMarca.value = marcaCarro;

            atualizarCarro()
            
        })
    })
}

/*
 * Função para alterar um carro
 */
function atualizarCarro() {
    document.querySelectorAll('.btn-atualizar-carro').forEach(item => {
        item.addEventListener('click', e => {
            e.preventDefault()

            const idCarro = item.getAttribute('id-atualizacao')
            
            // Elementos da tela
            const novoModelo = document.getElementById('input-modelo-' + idCarro)
            const novoAno = document.getElementById('input-ano-' + idCarro)
            const novaMarcaId = document.getElementById('input-marca-' + idCarro)
            
            // Dados de comunicação e transmissão
            const url = '/test-dev/api/carro/' + idCarro
            let formData = new FormData()
            
            // Criando o corpo da requisição
            formData.append('marca', novaMarcaId.value)
            formData.append('modelo', novoModelo.value)
            formData.append('ano', novoAno.value)
                
            // Requisição de gravação para a API
            fetch(url, {
                body: formData,
                method: 'PUT'
            }).then(() => {
                
                // Atualiza a tela com os carros
                exibirCarros()
                
                // Mensagem de sucesso
                setMensagemSucesso("Carro atualizado com sucesso!")

            })

        })
    })
}

/*
 * Função para deixar a primeira letra da palavra em maísculo
 */
function getMarcaCarroById(id) {

    var marca = getMarcas()

    return marca[id]

}

/*
 * Função para deixar a primeira letra da palavra em maísculo
 */
function getMarcaCarroByNome(nome) {

    var marcas = getMarcas()
    return Object.keys(marcas)[Object.values(marcas).indexOf(nome)]

}

function getMarcas() {
    
    var marca = {}
    marca['1'] = "Chevrolet"
    marca['2'] = "Volkswagen"
    marca['3'] = "Fiat"
    marca['4'] = "Renault"
    marca['5'] = "Ford"
    marca['6'] = "Toyota"
    marca['7'] = "Hyundai"
    marca['8'] = "Jeep"
    marca['9'] = "Honda"
    marca['10'] = "Nissan"
    marca['11'] = "Citroën"
    marca['12'] = "Peugeot"

    return marca
}