carregarCarros();

// Get all carros
function carregarCarros(){ 
    var url  = "http://localhost:8081/carros";
    var xhr  = new XMLHttpRequest()
    xhr.open('GET', url, true)
    xhr.onload = function () {
        var carros = JSON.parse(xhr.responseText);
        if (xhr.readyState == 4 && xhr.status == "200") {
            document.querySelector(".list").innerHTML = '';
            var lista = document.querySelector(".list");

            for (var i = 0; i < carros.length; i++) {
                lista.innerHTML += "<tr><td>" + carros[i]['id'] + "</td><td>" + carros[i]['marca'] + "</td><td>" + carros[i]['modelo'] + "</td><td>" + carros[i]['ano'] + "</td><td><button class='btn atualizar bg-default' onclick='visualizarCarro(" + carros[i]['id'] + ")'><i class='fa fa-eye'></i></button> <button class='btn atualizar bg-warning' onclick='editarCarro(" + carros[i]['id'] + ")'><i class='fa fa-edit'></i></button> <button class='btn delete bg-danger' onclick='deletarCarro(" + carros[i]['id'] + ")'><i class='fa fa-trash'></i></button></td></th>";
            }
        } else {
            console.error(carros);
        }
    }
    xhr.send(null);
}

function novoMarcaCarro(evt){  
    document.querySelector(".novo-marca").setAttribute('value',  evt);
}

function novoModeloCarro(evt){  
    document.querySelector(".novo-modelo").setAttribute('value',  evt);
}

function novoAnoCarro(evt){  
    document.querySelector(".novo-ano").setAttribute('value',  evt);
}

function deletarCarro(evt){    
    var url = "http://localhost:8081/carros";
    var xhr = new XMLHttpRequest();
    xhr.open("DELETE", url+'/'+evt, true);
    xhr.onload = function () {
        var carros = JSON.parse(xhr.responseText);
        if (xhr.readyState == 4 && xhr.status == "200") {
            carregarCarros();
        } else {
            console.error(carros);
        }
    }
    xhr.send(null);
}

function editarCarro(evt){    
    var url  = "http://localhost:8081/carros";
    var xhr  = new XMLHttpRequest()
    xhr.open('GET', url+'/'+evt, true)
    xhr.onload = function () {
        var carros = JSON.parse(xhr.responseText);
        if (xhr.readyState == 4 && xhr.status == "200") {
            document.querySelector(".tabela").style.display = 'none';
            document.querySelector(".editar").style.display  = 'block';
            document.querySelector(".visualizar").style.display = 'none';
            document.querySelector(".novo").style.display = 'none';
            // console.table(carros);
            // document.querySelector(".editar-id").value = carros['id'];
            // document.querySelector(".editar-marca").value = carros['marca'];
            // document.querySelector(".editar-modelo").value = carros['modelo'];
            // document.querySelector(".editar-ano").value = carros['ano'];

            document.querySelector(".editar-id").setAttribute('value',  carros['id']);
            document.querySelector(".editar-marca").setAttribute('value',  carros['marca']);
            document.querySelector(".editar-modelo").setAttribute('value',  carros['modelo']);
            document.querySelector(".editar-ano").setAttribute('value',  carros['ano']);
   
        } else {
            console.error(carros);
        }
        return carros;
    }
    xhr.send(null);
}

function visualizarCarro(evt){ 
    document.querySelector(".tabela").style.display = 'none';
    document.querySelector(".editar").style.display  = 'none';
    document.querySelector(".visualizar").style.display = 'block';
    document.querySelector(".novo").style.display = 'none';

    var url  = "http://localhost:8081/carros";
    var xhr  = new XMLHttpRequest()
    xhr.open('GET', url+'/'+evt, true)
    xhr.onload = function () {
        var carros = JSON.parse(xhr.responseText);
        if (xhr.readyState == 4 && xhr.status == "200") {
            console.table(carros);
            document.querySelector(".visualizar-id").setAttribute('value',  carros['id']);
            document.querySelector(".visualizar-marca").setAttribute('value',  carros['marca']);
            document.querySelector(".visualizar-modelo").setAttribute('value',  carros['modelo']);
            document.querySelector(".visualizar-ano").setAttribute('value',  carros['ano']);
        } else {
            console.error(carros);
        }
        return carros;
    }
    xhr.send(null);
}

function novoCarro(){
    document.querySelector(".tabela").style.display = 'none';
    document.querySelector(".editar").style.display  = 'none';
    document.querySelector(".visualizar").style.display = 'none';
    document.querySelector(".novo").style.display = 'block';
}

function homeCarro(){
    document.querySelector(".tabela").style.display = 'block';
    document.querySelector(".editar").style.display  = 'none';
    document.querySelector(".visualizar").style.display = 'none';
    document.querySelector(".novo").style.display = 'none';
    carregarCarros();
}

function salvarCarro(){
    var url = "http://localhost:8081/carros";

    var data = {};
    data.marca = document.querySelector(".novo-marca").value;
    data.modelo  = document.querySelector(".novo-modelo").value;
    data.ano = document.querySelector(".novo-ano").value;

    var json = JSON.stringify(data);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader('Content-type','application/json; charset=utf-8');
    xhr.onload = function () {
        var carros = JSON.parse(xhr.responseText);
        if (xhr.readyState == 4 && xhr.status == "201") {
            console.table(carros);
            document.querySelector(".novo-marca").setAttribute('value',  '');
            document.querySelector(".novo-modelo").setAttribute('value',  '');
            document.querySelector(".novo-ano").setAttribute('value',  '');
        } else {
            console.error(carros);
        }
    }
    xhr.send(json);
}

function atualizarCarro(){ 
    var url = "http://localhost:8081/carros";
    var id = document.querySelector(".editar-id").value;
    var data = {};
    data.marca = document.querySelector(".editar-marca").value;
    data.modelo  = document.querySelector(".editar-modelo").value;
    data.ano = document.querySelector(".editar-ano").value;

    var json = JSON.stringify(data);
  
    var xhr = new XMLHttpRequest(); 
    xhr.open("PUT", url+'/'+id, true);
    xhr.setRequestHeader('Content-type','application/json; charset=utf-8');
    
    xhr.onload = function () {
    	var carros = JSON.parse(xhr.responseText);
    	if (xhr.readyState == 4 && xhr.status == "200") {
    		// console.table(carros);
    	} else {
    		console.error(carros);
    	}
    }

    xhr.send(json);
}