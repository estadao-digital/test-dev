var marcas = [];
var httpRequest;

//função responsável por executar o ajax
function makeRequest(method, url, formData, onSuccess) {
    httpRequest = new XMLHttpRequest();
    var data = createFormData(formData);

    if (!httpRequest) {
        alert('Giving up :( Cannot create an XMLHTTP instance');
        return false;
    }

    httpRequest.onreadystatechange = alertContents(onSuccess);
    httpRequest.open(method, url);
    httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    httpRequest.send(data);
}

function createFormData(data) {
    var formData = new FormData();
    formData = ''
    for(var i in data) {
        //formData.append(i, data[i]);
        formData += i+'='+data[i]+'&';
    }
    return formData;
}

function alertContents(onSuccess) {
    return function () {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                onSuccess(httpRequest.responseText);
            } else {
                alert('Erro ao utilizar ajax.');
            }
        }
    };

}

window.onload = function() {

    document.getElementById("button-insert").onclick = function() {
        makeRequest('post', '/carros', {
            marca: document.getElementById('marca-insert').value,
            modelo: document.getElementById('modelo-insert').value,
            ano: document.getElementById('ano-insert').value
        }, function(retorno) {
            $('#modal-insert').modal('hide');
            alert('Carro incluido com sucesso');
        });
    };

    document.getElementById("button-update").onclick = function() {
        var id = document.getElementById('id-update').value;
        makeRequest('PUT', '/carros/'+id, {
            marca: document.getElementById('marca-update').value,
            modelo: document.getElementById('modelo-update').value,
            ano: document.getElementById('ano-update').value
        }, function(retorno) {
            $('#modal-update').modal('hide');
            alert('Carro editado com sucesso');
        });
    };

    //atualiza a lista de marcas para depois carregar carros
    makeRequest('get', '/marcas', {}, function(retornoMarcas) {
        marcas = JSON.parse(retornoMarcas);
        carregaCarros();
    });

    // gera a lista

    function carregaCarros() {
        makeRequest('get', '/carros', { }, function(retorno) {
            var dados = JSON.parse(retorno);
            var html = '';
            for(var i in dados) {
                var carro = dados[i];
                var editar = "javascript:editar("+carro.id+", '"+carro.marca+"', '"+carro.modelo+"', '"+carro.ano+"');";
                var excluir = "javascript:excluir("+carro.id+");";
                html += "<tr>" +
                    "   <td>"+carro.id+"</td>" +
                    "   <td>"+marcas[carro.marca]+"</td>" +
                    "   <td>"+carro.modelo+"</td>" +
                    "   <td>"+carro.ano+"</td>" +
                    "   <td><a href=\""+editar+"\">editar</a></td>" +
                    "   <td><a href='"+excluir+"'>excluir</a></td>" +
                    "</tr>"
            }
            document.querySelector("#table-carros tbody").innerHTML = html;
        });
    }
};

function editar(id, marca, modelo, ano) {
    document.getElementById('id-update').value = id;
    document.getElementById('marca-update').value = marca;
    document.getElementById('modelo-update').value = modelo;
    document.getElementById('ano-update').value = ano;
    $('#modal-update').modal();
}

function excluir(id) {
    makeRequest('delete', '/carros/'+id, { }, function(retorno) {
        alert('Carro excluido com sucesso');
    });
}
