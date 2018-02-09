'use strict'
let componentCarro = "";
//window.history.pushState("", "Title", "/test-dev/new-url");
function ajax(url, metodo, frm = null, call){
	const xhr = new XMLHttpRequest()
	const onLoad = (data) => {
	  if (xhr.readyState == 4 && xhr.status == "200") {
			const response = xhr.responseText
			if(call){
				call(response)
			}
	  } 
	}
	xhr.open(metodo, url, true)
  xhr.onreadystatechange = onLoad
	const frmSend = new FormData(frm) || frm	
  xhr.send(frmSend)
}
//cria um novo carro enviando com metodo post
const frmSalva = document.getElementById('frm-carro')
frmSalva.onsubmit = (data) => {	
	window.history.pushState("", "Title", "/test-dev/carros");
	ajax('carros', 'POST', frmSalva, function(data){
		//console.log(data)
		const dataJson = JSON.parse(data)
		templateCarros(dataJson);
		$("#select-"+dataJson.id).val(dataJson.modelo)
		frmSalva.reset();
	})
	return false;	
}

function templateCarros(data){
	const template = componentCarro.replace(/{marca}/g, data.marca)
			.replace(/{modelo}/g, data.modelo)
				.replace(/{ano}/g, data.ano)
					.replace(/{id}/g, data.id)
		$("#carros-tbody").append(template)
}

function templateCarro(data){
	if(!data){return false;}
	const template = componentCarro.replace(/{marca}/g, data.marca)
			.replace(/{modelo}/g, data.modelo)
				.replace(/{ano}/g, data.ano)
					.replace(/{id}/g, data.id)
		$("#carros-tbody").html(template)
}
//carrega o component de carros html
ajax('carros-component.html', "POST", null, function(data){
	componentCarro = `${data}`;
})

//busca os carros existentes
function allCars(){
	//window.history.pushState("", "Title", "/test-dev/carros");
ajax('carros', "GET", null, function(data){
	const dataJson = JSON.parse(data);
	dataJson.forEach(carro => {
		templateCarros(carro);
		$("#select-"+carro.id).val(carro.modelo)
	})
})
}
allCars()

//executa uma consulta com base no ID passado
document.getElementById("consulta-id").onkeyup = changed => {
	if(changed.key !== "Enter") return false
	if(!changed.target.value.length){
		$("#carros-tbody").html("")
		allCars()
	}
	ajax('carros?id='+changed.target.value, "GET", null, function(data){
		if(!data.length)return false
		const dataJson = JSON.parse(data);
			templateCarro(dataJson);
			$("#select-"+dataJson.id).val(dataJson.modelo)		
	})
}

document.getElementById("consulta-id-ok").onclick = clicked => {
	ajax('carros?id='+document.getElementById("consulta-id").value, "GET", null, function(data){
		const dataJson = JSON.parse(data);
		if(!dataJson[0]){return false}
			templateCarro(dataJson[0]);
			$("#select-"+dataJson[0].id).val(dataJson[0].modelo)		
	})
}