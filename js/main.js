//Inicia o XMLHttpRequest para as requisições ajax
var xhttp = new XMLHttpRequest();
var carros;
if (!window.XMLHttpRequest) {
    // code for old IE browsers
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}

//Pega todos os carros do banco de dados
pegaCarros();


//Pega todos os carros e carrega na tela
function pegaCarros(){
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            carros = JSON.parse(this.responseText);
            carregaCarros();
        }
    };
    xhttp.open("GET", "/api.php/carros", true);
    xhttp.send();
}

//Carrega todos os carros na tela
function carregaCarros() {
    var out = "";
    var i;
    for(i = carros.length-1; i >= 0; i--) {
        out +=
            '<div id="carro_card" class="carro_card">'+
            '<div id="info" class="carro_info">'+
            '<div class="top_info">'+
            '<div class="td">'+
            '<span><strong style="font-size: 30px;">'+ carros[i].Marca +'</strong></span>'+
            '</div>'+
            '</div>'+
            '<div class="bottom_info">'+
            '<div class="bd mobile_hidden" style="margin-right: 1rem;">'+
            '<span class="dark_font"><strong class="dark_font">ID: </strong>'+ carros[i].ID +'</span>'+
            '</div>'+
            '<div class="bd width_40">'+
            '<span><strong class="white_font">Modelo: </strong>'+ carros[i].Modelo +'</span>'+
            '</div>'+
            '<div class="bd width_40">'+
            '<span><strong class="white_font">Ano: </strong>'+ carros[i].Ano +'</span>'+
            '</div>'+
            '<div class="bd mobile_show" style="margin-right: 1rem;">'+
            '<span class="dark_font"><strong class="dark_font">ID: </strong>'+ carros[i].ID +'</span>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '<div id="botoes" class="carro_botoes">'+
            '<div class="botao editar" onclick="abreModalEditar('+i+')">Editar</div>'+
            '<div class="botao deletar" onclick="abreModalDeletar('+i+')">Deletar</div>'+
            '</div>'+
            '</div>';
    }
    document.getElementById("conteudo").innerHTML = out;
}

//Atualiza a tela depois do carro ser deletado
function carroDeletado(){
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            carros = JSON.parse(this.responseText);
            carregaCarros();
            fechaModalDeletar();
        }
    };
    xhttp.open("GET", "/api.php/carros", true);
    xhttp.send();
}

//Deleta o carro chamando a api
function deletarCarro(ID){
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            carroDeletado();
        }
    };
    xhttp.open("DELETE", "/api.php/carros/"+ID, true);
    xhttp.send();
}

//Fecha o modal de deletar
function fechaModalDeletar(){
    document.getElementById("fundo_modal").classList.remove("mostra_modal");
    document.getElementById("modal_deleta").classList.remove("mostra_modal");
}

//Abre o modal de deletar e mostra o carro nele
function abreModalDeletar(index){
    document.getElementById("modal_deletar_deletar").onclick = function() { deletarCarro(carros[index].ID) };
    document.getElementById("fundo_modal").classList.add("mostra_modal");
    document.getElementById("modal_deleta").classList.add("mostra_modal");
    let out =
        '<div id="carro_card" class="carro_card">' +
        '<div id="info" class="carro_info">' +
        '<div class="top_info">' +
        '<div class="td">' +
        '<span><strong style="font-size: 30px;">' + carros[index].Marca + '</strong></span>' +
        '</div>' +
        '</div>' +
        '<div class="bottom_info">' +
        '<div class="bd mobile_hidden" style="margin-right: 1rem;">' +
        '<span class="dark_font"><strong class="dark_font">ID: </strong>' + carros[index].ID + '</span>' +
        '</div>' +
        '<div class="bd width_40">' +
        '<span><strong class="white_font">Modelo: </strong>' + carros[index].Modelo + '</span>' +
        '</div>' +
        '<div class="bd width_40">' +
        '<span><strong class="white_font">Ano: </strong>' + carros[index].Ano + '</span>' +
        '</div>' +
        '<div class="bd mobile_show" style="margin-right: 1rem;">' +
        '<span class="dark_font"><strong class="dark_font">ID: </strong>' + carros[index].ID + '</span>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';
    document.getElementById("modal_body").innerHTML = out;
    alert(ID);
}

//Abre o modal de edição
function abreModalEditar(index){
    preencheCampos(carros[index].Marca, carros[index].Modelo, carros[index].Ano);
    document.getElementById("salvar_carro").onclick = function() { editaCarro(carros[index].ID) };
    document.getElementById("modal_novo_header").innerText = 'Editar: ID '+carros[index].ID;
    document.getElementById("fundo_modal").classList.add("mostra_modal");
    document.getElementById("modal_novo").classList.add("mostra_modal");
}

//Abre o modal para criar um novo carro
function abreModalNovo() {
    limpaCampos();
    document.getElementById("modal_novo_header").innerText = 'Novo Carro:';
    document.getElementById("salvar_carro").onclick = function() { salvaNovoCarro() };
    document.getElementById("fundo_modal").classList.add("mostra_modal");
    document.getElementById("modal_novo").classList.add("mostra_modal");
}

//Fecha o modal de novo
function fechaModalNovo() {
    document.getElementById("fundo_modal").classList.remove("mostra_modal");
    document.getElementById("modal_novo").classList.remove("mostra_modal");
}

//Limpa todos os campos do input
function limpaCampos() {
    document.getElementById('input_marca').value = '';
    document.getElementById('input_modelo').value = '';
    document.getElementById('input_ano').value = '';
}

//Preenche os campos do input
function preencheCampos(marca, modelo, ano){
    document.getElementById('input_marca').value = marca;
    document.getElementById('input_modelo').value = modelo;
    document.getElementById('input_ano').value = ano;
}

//Salva o novo carro na api
function salvaNovoCarro() {
    var marca = document.getElementById('input_marca').value
    var modelo = document.getElementById('input_modelo').value
    var ano = document.getElementById('input_ano').value
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            pegaCarros();
            fechaModalNovo();
            limpaCampos();
        }
    };
    xhttp.open("POST", "/api.php/carros", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("Marca="+marca+"&Modelo="+modelo+"&Ano="+ano);
}

//Atualiza o carro na API
function editaCarro(ID) {
    var marca = document.getElementById('input_marca').value
    var modelo = document.getElementById('input_modelo').value
    var ano = document.getElementById('input_ano').value
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            pegaCarros();
            fechaModalNovo();
            limpaCampos();
        }
    };
    xhttp.open("PUT", "/api.php/carros/"+ID, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("Marca="+marca+"&Modelo="+modelo+"&Ano="+ano);
}
