
//metodo responsavel por buscar os arquivos html e retornar para o content
function AjaxRequest(itemHTML) {
    var ajax;
    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }

    ajax.open("GET", itemHTML);

    ajax.onreadystatechange = function () {
        if (ajax.status == 200) {

            if (ajax.readyState == 3) {
                console.log("Carregando Página...");
            }

            if (ajax.readyState == 4) {
                //verificar se é para listar os carros caso seja, carrega a lista também
                if (itemHTML === "listar-carros.html") {
                    tableCarros();
                    document.getElementById("content").innerHTML = ajax.responseText;
                } else if (itemHTML == "listar-marca.html") {
                    tableMarcas();
                    document.getElementById("content").innerHTML = ajax.responseText;
                } else if (itemHTML == "cadastrar-carro.html") {
                    console.log("passo");
                    popularCheckListMarcas();
                    document.getElementById("content").innerHTML = ajax.responseText;

                }

                else {
                    //console.log(ajax.responseText);
                    document.getElementById("content").innerHTML = ajax.responseText;
                }
            }
        } else {
            alert("Erro ao Carregar a Página.");
        }
    }

    ajax.send();
}

//metodo responsavel por buscar os carros cadastrados no sistema e popular atraves de um método secundario
function tableCarros() {
    var ajaxLista;
    if (window.XMLHttpRequest) {
        ajaxLista = new XMLHttpRequest();
    } else {
        ajaxLista = new ActiveXObject("Microsoft.XMLHTTP");
    }
    ajaxLista.open("GET", "Carro.class.php?action=listar");
    //verifica se a lista esta sendo carregada
    ajaxLista.onreadystatechange = function () {
        if (ajaxLista.status == 200) {

            if (ajaxLista.readyState == 3) {
                console.log("Carregando Lista...");
            }

            if (ajaxLista.readyState == 4) {
                var json = ajaxLista.response;

                console.log(json);

                var dados = JSON.parse(json);

                popularTabelaCarros(dados["carros"]);

            }
        }
    }
    ajaxLista.send();
}

//remover carros a partir de um ID especifico.
function removerItem(id) {
    var ajax;
    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }

    ajax.open("DELETE", "Carro.class.php?action=remover&item=" + id);

    ajax.onreadystatechange = function () {
        if (ajax.readyState == 3) {
            console.log("Carregando Lista...");
        }

        if (ajax.readyState == 4) {
            console.log(ajax.response);
            if (ajax.response > 0) {
                document.getElementById("table-body").innerHTML = "";
                tableCarros();
                document.getElementById("div-msg-success").innerHTML = "Carro removido com sucesso.";
                document.getElementById("div-msg-success").style.display = "block";

            } else {
                document.getElementById("div-msg-danger").innerHTML = "Não foi possível remover este Carro do BD.";
                document.getElementById("div-msg-danger").style.display = "block";

            }
        }

    }
    ajax.send();
}



//metodo secundario responsável por popular a tabela dos carros.
function popularTabelaCarros(dados) {
    var tbody = document.getElementById("table-body");
    if (dados.length == 0) {
        tbody.innerHTML = "<div align='center'><h1>Nada para Mostrar</h1></div>";
    } else {
        for (var i = 0; i <= dados.length; i++) {

            var tr = document.createElement("tr");
            var tdMarca = document.createElement("td");
            var tdModelo = document.createElement("td");
            var tdAno = document.createElement("td");
            var tdAction = document.createElement("td");
            var marca = document.createTextNode(dados[i].marca);
            var ano = document.createTextNode(dados[i].ano);
            var modelo = document.createTextNode(dados[i].modelo);
            var id = document.createTextNode(dados[i].id);
            var buttonEditar = "<button class='btn btn-primary' onclick='buscarCarroID(\"" + dados[i].id + "\",\"1\")'> Editar </button> ";
            var buttonVerItem = " <button class='btn btn-default' onclick='buscarCarroID(\"" + dados[i].id + "\")'> Visualizar </button> ";

            var buttonRemover = "  <button class='btn btn-danger' onclick='removerItem(\"" + dados[i].id + "\")'> Remover </button> ";

            tdAction.innerHTML = buttonEditar + buttonRemover + buttonVerItem;
            tdMarca.appendChild(marca);
            tdModelo.appendChild(modelo);
            tdAno.appendChild(ano);

            tr.appendChild(tdMarca);
            tr.appendChild(tdModelo);
            tr.appendChild(tdAno);
            tr.appendChild(tdAction);
            tbody.append(tr);
        }
    }
}
//cadastra o carro
function cadastrarCarro() {
    var modelo = document.getElementById("modelo").value;
    var ano = document.getElementById("ano").value;
    var marca = document.getElementById("marca").value;
    var ajax;
    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }

    ajax.open("POST", "Carro.class.php?action=cadastrar");
    ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 3) {
            console.log("Carregando Lista...");
        }

        if (ajax.readyState == 4) {
            console.log(ajax.response);
            //retorna para o usuário o resultado.
            if (ajax.response == 2) {

                document.getElementById("div-msg-danger").innerHTML = "Request inválido, por favor preencha os campos corretamente.";
                document.getElementById("div-msg-danger").style.display = "block";
            } else if (ajax.response == 1) {
                document.getElementById("div-msg-success").innerHTML = "Carro cadastrado com sucesso.";
                document.getElementById("div-msg-success").style.display = "block";



            } else {
                document.getElementById("div-msg-danger").innerHTML = "Não foi possível cadastrar este Carro no BD.";
                document.getElementById("div-msg-danger").style.display = "block";
                var modelo = document.getElementById("modelo").value = "";
                var ano = document.getElementById("ano").value = "";
                var marca = document.getElementById("marca").value = "";
            }
        }

    }


    var parametros = "modelo=" + modelo + "&" + "ano=" + ano + "&" + "marca=" + marca;
    ajax.send(parametros);
}


// carrega a página de edição de carro
function editarCarroIndex(json) {
    var ajax;
    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }

    ajax.open("POST", "alterar-carro.html");

    ajax.onreadystatechange = function () {
        if (ajax.readyState == 3) {
            console.log("Carregando Página Alterar Carro...");
        }

        if (ajax.readyState == 4) {
            document.getElementById("content").innerHTML = ajax.responseText;

            popularCheckListMarcas(json.marca);

            document.getElementById("modelo-alterar").value = json.modelo;
            document.getElementById("ano").value = json.ano;
            document.getElementById("id").value = json.id;

        }

    }
    ajax.send();
}
//busca por carro e retorna para a tela carro id ou prepara para alterar os dados do carro.
function buscarCarroID(id, editar) {
    var ajax;
    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }

    ajax.open("GET", "Carro.class.php?action=buscar&item=" + id);

    ajax.onreadystatechange = function () {
        if (ajax.readyState == 3) {
            console.log("Carregando Dados...");
        }

        if (ajax.readyState == 4) {
            var json = JSON.parse(ajax.response);
            if (!editar) {
                alert("carro id");
                carroID(json);
            } else {
                editarCarroIndex(json);
            }


        }

    }
    ajax.send();
}
//metodo responsavel pela view do carro/id
function carroID(json){

    var ajax;
    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }

    ajax.open("GET", "carro-id.html");

    ajax.onreadystatechange = function () {
        if (ajax.readyState == 3) {
            console.log("Carregando Dados...");
        }

        if (ajax.readyState == 4) {
            document.getElementById("content").innerHTML = ajax.responseText;

            alert(json.marca);
            alert(json.modelo);
            alert(json.ano);
            document.getElementById("marca").innerHTML = json.marca;
            document.getElementById("modelo").innerHTML = json.modelo;
            document.getElementById("ano").innerHTML = json.ano;

        }

    }
    ajax.send();
}

function editarCarro(){
    var id = document.getElementById("id").value;
    var modelo = document.getElementById("modelo-alterar").value;
    var ano = document.getElementById("ano").value;
    var marca = document.getElementById("marca").value;
    var ajax;
    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }

    ajax.open("PUT", "Carro.class.php?action=alterar");
    ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 3) {
            console.log("Carregando Lista...");
        }

        if (ajax.readyState == 4) {
            console.log(ajax.response);
            if (ajax.response == 2) {

                document.getElementById("div-msg-danger").innerHTML = "Request inválido, por favor preencha os campos corretamente.";
                document.getElementById("div-msg-danger").style.display = "block";
            } else if (ajax.response == 1) {
                document.getElementById("div-msg-success").innerHTML = "Carro alterado com sucesso.";
                document.getElementById("div-msg-success").style.display = "block";

            } else {
                document.getElementById("div-msg-danger").innerHTML = "Não foi possível alterar este Carro no BD.";
                document.getElementById("div-msg-danger").style.display = "block";

            }
        }

    }


    var parametros = "id="+id+"&"+"modelo=" + modelo + "&" + "ano=" + ano + "&" + "marca=" + marca;
    ajax.send(parametros);
}


///gerenciar marcas

function cadastrarMarca() {
    var marca = document.getElementById("marca").value;
    var ajax;
    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }

    ajax.open("POST", "Marca.class.php?action=cadastrar",true);
    ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 3) {
            console.log("Cadastrando Marca...");
        }

        if (ajax.readyState == 4) {

            console.log(ajax.response);
            if (ajax.response == 2) {

                document.getElementById("div-msg-danger").innerHTML = "Request inválido, por favor preencha os campos corretamente.";
                document.getElementById("div-msg-danger").style.display = "block";
            } else if (ajax.response == 1) {
                marca = "";
                document.getElementById("div-msg-success").innerHTML = "Marca cadastrada com sucesso.";
                document.getElementById("div-msg-success").style.display = "block";

            } else {
                document.getElementById("div-msg-danger").innerHTML = "Não foi possível cadastrar esta Marca no BD.";
                document.getElementById("div-msg-danger").style.display = "block";

            }
        }

    }


    var parametros = "marca=" + marca;
    ajax.send(parametros);
}


//popular os dados da tabela marcas
function popularTabelaMarca(dados) {
    var tbody = document.getElementById("table-body");
    if (dados.length == 0) {
        tbody.innerHTML = "<div align='center'><h1>Nada para Mostrar</h1></div>";
    } else {
        for (var i = 0; i <= dados.length; i++) {
            if(dados[i].marca) {
                var marca = dados[i].marca.replace("\n", "");
                console.log(marca + "testeee");
                var tr = document.createElement("tr");
                var tdMarca = document.createElement("td");
                var marcasTrim = marca.trim();
                var tdAction = document.createElement("td");
                var marcaNode = document.createTextNode(marca);
                var buttonRemover = " <button class='btn btn-danger' onclick='removerMarca(\""+marcasTrim+"\")'>Remover</button>";

                tdAction.innerHTML = buttonRemover;
                tdMarca.appendChild(marcaNode);

                tr.appendChild(tdMarca);
                tr.appendChild(tdAction);
                tbody.append(tr);
            }
        }
    }
}
//popular o checklist do cadastro de carros e alterar carros.
function popularCheckListMarcas(marca) {
    var ajax;
    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }

    ajax.open("GET", "Marca.class.php?action=listar");

    ajax.onreadystatechange = function () {
        if (ajax.status == 200) {

            if (ajax.readyState == 3) {
                console.log("Carregando CheckList...");
            }

            if (ajax.readyState == 4) {
                var dados = JSON.parse(ajax.response);
                var marcas = dados["marcas"];
                if (marcas.length == 0) {

                } else {
                    console.log(marcas);
                    var select = document.getElementById("marca");
                    for (var i = 0; i < marcas.length; i++) {

                        var option = document.createElement("option");
                        option.value = marcas[i].marca;
                        option.text = marcas[i].marca;
                        select.appendChild(option);

                    }
                    if (marca != null) {
                        console.log(document.getElementById("marca").value = marca.replace(/^\s+|\s+$/g,""));
                    }
                }


            }
        }
    }
    ajax.send();
}

function removerMarca(id) {
    var ajax;
    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }

    ajax.open("DELETE", "Marca.class.php?action=remover&item=" + id);

    ajax.onreadystatechange = function () {
        if (ajax.readyState == 3) {
            console.log("Carregando ListcadastrarMarcaa...");
        }

        if (ajax.readyState == 4) {
            console.log(ajax.response);
            if (ajax.response > 0) {
                document.getElementById("table-body").innerHTML = "";
                tableMarcas();
                document.getElementById("div-msg-success").innerHTML = "Marca removida com sucesso.";
                document.getElementById("div-msg-success").style.display = "block";

            } else {
                document.getElementById("div-msg-danger").innerHTML = "Não foi possível remover esta marca do BD.";
                document.getElementById("div-msg-danger").style.display = "block";

            }
        }

    }
    ajax.send();
}
//lista as marcas para popular a tabela com um método secundario
function tableMarcas() {
    var ajax;
    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }

    ajax.open("GET", "Marca.class.php?action=listar");

    ajax.onreadystatechange = function () {
        if (ajax.status == 200) {

            if (ajax.readyState == 3) {
                console.log("Carregando Página...");
            }

            if (ajax.readyState == 4) {
                var json = ajax.response;

                console.log(json);

                var dados = JSON.parse(json);
                popularTabelaMarca(dados["marcas"]);
            }
        }
    }
    ajax.send();
}