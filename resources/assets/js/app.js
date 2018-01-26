require('./bootstrap');

let baseURL = window.location.href + "api/v1";
let marcas = [];

document.getElementById("btnNovoCarro").addEventListener("click", novoCarro);

function novoCarro(){
    let carro = new Carro();
    exibeCarro(carro);
}

class Carro {
    constructor(id = 0, modelo = "", marca = "", ano = ""){
        this.id = id;
        this.modelo = modelo;
        this.marca = marca;
        this.ano = ano;
    }
    validaUpdate(){
        return true;
    }
    validaCreate(){
        return true;
    }
}

function requestHttp(rota, metodo, callback){
    axios[metodo](rota)
    .then(function(response){
        callback(response);
    })
    .catch(function (error) {
        alert("deu pau!");
        return error;
    });
}

function preencheListaDeCarros(response){
    let divLista = document.getElementById("carrosList");
    let ul = document.createElement("ul");
    let data = response.data.data;

    for (var i = 0; i < data.length; i++) {
        let item = document.createElement("li");
        
        let link = document.createElement("a");
        link.innerHTML = data[i].modelo + ' ( ' + data[i].marca.marca + ' / ' + data[i].ano + ' ) ';
        link.href = baseURL + '/carros/' + data[i].id;
        link.addEventListener("click",
        function (e) {
            e.preventDefault();
            cliqueLista(link.href);
        });

        let deletar = document.createElement("a");
        deletar.innerHTML = "Deletar";
        deletar.style.color = "Red";
        deletar.href = baseURL + '/carros/' + data[i].id;
        deletar.addEventListener("click",
        function (e) {
            e.preventDefault();
            deletarCarro(deletar.href);
        });

        item.appendChild(link);
        item.appendChild(deletar);
        ul.appendChild(item);
    }

    divLista.appendChild(ul);
}

function deletarCarro(href){
    requestHttp(href, 'delete', (response) => carroDeletado(response.data.data));
    return false;
}

function carroDeletado(){
    atualizaListaDeCarros();
    excluiInputs();
}

function cliqueLista(href){
    requestHttp(href, 'get', (response) => exibeCarro(response.data.data));
    return false;
}

function exibeCarro(carro){

    let divCarro = document.getElementById("carro");
    divCarro.setAttribute("idDoCarro", carro.id);

    let nomeCarro, marca, marcasList, ano;

    if(divCarro.hasChildNodes()){
        nomeCarro = document.getElementById("nomeCarro");
        marca = document.getElementById("marca");
        marcasList = document.getElementById("marcasList");
        ano = document.getElementById("ano");
    }else{
        nomeCarro = document.createElement("input");
        nomeCarro.setAttribute("type", "text");
        nomeCarro.setAttribute("id", "nomeCarro");
        nomeCarro.setAttribute("class", "form-control");
        nomeCarro.setAttribute("placeholder", "Modelo");

        marca = document.createElement("input");
        marca.setAttribute("type", "text");
        marca.setAttribute("list", "marcasList");
        marca.setAttribute("id", "marca");
        marca.setAttribute("class", "form-control");
        marca.setAttribute("placeholder", "Marca");

        marcasList = document.createElement("datalist");
        marcasList.setAttribute("id", "marcasList");
        
        ano = document.createElement("input");
        ano.setAttribute("type", "number");
        ano.setAttribute("id", "ano");
        ano.setAttribute("class", "form-control");
        ano.setAttribute("placeholder", "Ano");
    }

    nomeCarro.value = carro.modelo;
    marca.value = carro.marca;
    ano.value = carro.ano;

    if(!divCarro.hasChildNodes()){
        divCarro.appendChild(nomeCarro);
        divCarro.appendChild(marca);
        divCarro.appendChild(marcasList)
        divCarro.appendChild(ano);

        let salvarBtn = document.createElement("button");
        salvarBtn.innerText = "Salvar";
        salvarBtn.setAttribute("class", "btn btn-primary");
        salvarBtn.addEventListener("click", salvarCarro);

        divCarro.appendChild(salvarBtn);

        let cancelarBtn = document.createElement("button");
        cancelarBtn.innerText = "Cancelar";
        cancelarBtn.setAttribute("class", "btn btn-default");
        cancelarBtn.addEventListener("click", excluiInputs);

        divCarro.appendChild(cancelarBtn);
    }
    
    pegarTodasAsMarcas(atualizaListaDeMarcas);
}

function atualizaListaDeMarcas(response){
    let marcasList = document.getElementById("marcasList");
    while (marcasList.firstChild)
        marcasList.removeChild(marcasList.firstChild);
    
    for (var i = 0; i < response.data.length; i++) {
        let marcaItem = document.createElement("option");
        marcaItem.setAttribute("value", response.data[i].marca);
        marcasList.appendChild(marcaItem);
    }
}

function pegarTodasAsMarcas(callback){
    axios.get(baseURL + "/marcas")
    .then(function(response){
        if(response.status == 200){
            callback(response);
        }else{
            console.log("não foi possível atualizar a lista de marcas!");
            mensagemNaoFoiPossivelSalvar(response);
        }
    })
    .catch(function (error) {
        mensagemNaoFoiPossivelSalvar(error);
    });
}

function salvarCarro(){

    let id = document.getElementById("carro").getAttribute("idDoCarro");
    let modelo = document.getElementById("nomeCarro").value;
    let marca = document.getElementById("marca").value;
    let ano = document.getElementById("ano").value;

    let carro = new Carro(id, modelo, marca, ano);

    if(!carro.validaUpdate()){
        mensagemValidacaoNegada();
        return;
    }

    if(carro.id > 0){
        axios.put(baseURL + "/carros/" + carro.id, carro)
        .then(function(response){
            if(response.status == 200){
                mensagemSalvoComSucesso();
                excluiInputs();
                atualizaListaDeCarros();
            }else{
                mensagemNaoFoiPossivelSalvar(response);
            }
        })
        .catch(function (error) {
            mensagemNaoFoiPossivelSalvar(error);
        });
    } else{
        axios.post(baseURL + "/carros", carro)
        .then(function(response){
            mensagemSalvoComSucesso();
            excluiInputs();
            atualizaListaDeCarros();
        })
        .catch(function(error){
            mensagemNaoFoiPossivelSalvar(error);
        });
    }
}

function mensagemSalvoComSucesso(){
    console.log("Salvo com Sucesso!");
}

function mensagemNaoFoiPossivelSalvar(mensagem){
    console.log("Não foi possível salvar");
}

function mensagemValidacaoNegada(){
    console.log("");
}

function atualizaListaDeCarros(){
    let divLista = document.getElementById("carrosList");
    while (divLista.firstChild)
        divLista.removeChild(divLista.firstChild);
    
    montaListaDeCarros();
}

function excluiInputs(){
    let divCarro = document.getElementById("carro");
    divCarro.removeAttribute("idDoCarro");

    while (divCarro.firstChild)
        divCarro.removeChild(divCarro.firstChild);
}

function montaListaDeCarros(){
    requestHttp(
        baseURL + '/carros', 
        'get', 
        (response) => preencheListaDeCarros(response));
}

montaListaDeCarros();