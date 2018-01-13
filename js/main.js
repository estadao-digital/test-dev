function onLoadTabela(){
	sendVazio("GET");
}

/*
//usado no botão listar que foi removido. (serve para exibir o JSON sem ID)
$("#listAll").on("click", function(){
	
	sendVazio("GET");

});
*/
$("#findCar").on ("click", function(){
	id = $("input[name=carId]").val();
	if ( !id ) {
		$("#alert-error p").empty();
		$("#alert-error p").append("ID inválido");
		$("#alert-error").fadeIn();
		return;
	}
	data = send("GET",  id);	
	if ( data.msg ) {
		$("#alert-error p").empty();
		$("#alert-error p").append(data.msg);
		$("#alert-error").fadeIn();
	} else {
		fill([data]);
	}
});

$("#addCar").on("click", function(){
	carroMarca = $("option:selected").val();
	carroModelo = $("input[name=carroModelo]").val();
	carroAno = $("input[name=carroAno]").val();
	
	if ( carroModelo.length <= 0 || carroAno.length <= 0 ) {
		$("#alert-error p").empty();
		$("#alert-error p").append("Dados incorretos");
		$("#alert-error").fadeIn();
		return;
	}
	data = {
		"carroMarca": carroMarca,
		"carroModelo": carroModelo,
		"carroAno": carroAno,
	}
	send("POST",null, data);//envia os dados para o JSON
	sendVazio("GET");//recupera os dados para o AJAX sem erros.
});


function removeCar(id) {
	pending_deletion_id = id;
	$("#confirm").modal("show");
}

$("#confirmDeletion").on("click", function(){
	data = send("delete", pending_deletion_id);
	$(("#car-"+pending_deletion_id)).remove();
	$("#confirm").modal("hide");
	$("#alert-success p").empty();
	$("#alert-success p").append(data.msg);
	$("#alert-success").fadeIn();
});


function updateCar(id) {
	carroMarca = $(("option:selected")).val();
	carroModelo = $(("input[name=carroModelo-"+id+"]")).val();
	carroAno = $(("input[name=carroAno-"+id+"]")).val();
	console.log(carroMarca);
	if ( !carroMarca || carroModelo.length <= 0 || carroAno.length <= 0 ) {
		$("#alert-error p").empty();
		$("#alert-error p").append("Dados incorretos");
		$("#alert-error").fadeIn();
		return;
	}
	data = {
		"carroMarca": carroMarca,
		"carroModelo": carroModelo,
		"carroAno": carroAno,
	}
	result = send("PUT", id, data)
	$("#alert-success p").empty();
	$("#alert-success p").append(result.msg);
	$("#alert-success").fadeIn();
}

function fill(data) {		
	$("#listings").empty();
	content = "";
	for ( i in data ) {
		
		content += "<div class='input-group' id='car-"+data[i].id+"' >\
						<span class='input-group-btn'>\
							<input type='text' class='form-control' name='id-"+data[i].id+"' value='"+data[i].id+"' readonly >\
						</span>\
						<span class='input-group-btn'>\
						<select class='form-control'>\
						<option name='carroMarca-"+data[i].id+"' value='"+data[i].carroMarca+"' selected>"+data[i].carroMarca+"</option>\
						<option name='carroMarca-924036' value='Fiat'>Fiat</option>\
						<option name='carroMarca-924077' value='Hyundai'>Hyundai</option>\
						<option name='carroMarca-514830' value='Wolksvagen'>Wolksvagen</option>\
						<option name='carroMarca-798429' value='Toyota'>Toyota</option>\
						<option name='carroMarca-254646' value='Ford'>Ford</option>\
						<option name='carroMarca-707132' value='Nissan'>Nissan</option>\
						</select>\
						</span>\
						<span class='input-group-btn'>\
							<input type='text' class='form-control' name='carroModelo-"+data[i].id+"' value='"+data[i].carroModelo+"' >\
						</span>\
						<span class='input-group-btn'>\
							<input type='text' class='form-control' name='carroAno-"+data[i].id+"' value='"+data[i].carroAno+"' >\
						</span>\
						<span class='input-group-btn' >\
							<div class='btn-group' role='group' >\
								<a href='javascript:updateCar("+data[i].id+");' class='btn btn-default' title='Remover' ><span class='glyphicon glyphicon-floppy-disk' \></span></a>\
								<a href='javascript:removeCar("+data[i].id+");' class='btn btn-default' title='Remover' ><span class='glyphicon glyphicon-remove' \></span></a>\
							</div>\
						</span>\
					</div>";
	}
	$("#listings").append( content );
}

function send(method, id, data) {
	
	call = "./api.php";
	if ( id ) {
		call += "?id="+id;
	}
	result = null;
	$.ajax({
		type: method,
		url: call,
		data: JSON.stringify(data),
		dataType: "JSON",
		contentType : "application/json",
		processData: false,
		async: false,
		complete: function(data) {
			result = JSON.parse(data.responseText);
		}
	});
	return result;
	
}

function sendVazio(method){
	
	var lista = $("#listings");
	var html = "";
	
	$.getJSON("db.json", function(data){		
		var idOption = new Array();
		var valOption = new Array();
		var dataLength = new Number();
		
		for(i in data){
			var selecao = $("#selecaoMarcas");			
			var selecoes = data[i].carroMarca.split(",");
			var novaOpcao = document.createElement("option");
			novaOpcao.value = selecoes[0];
			novaOpcao.innerHTML = novaOpcao.value;
			
			//no select não consegui fazer options dinamicos com uma segunda repetição então a fiz manualmente
			//aqui obtenho os dados do JSON para passar ao HTML
			html += "<div class='input-group' id='car-"+data[i].id+"' >\
						<span class='input-group-btn'>\
							<input type='text' class='form-control' name='id-"+data[i].id+"' value='"+data[i].id+"' readonly >\
						</span>\
						<span class='input-group-btn'>\
						<select class='form-control' id='selecaoMarcas'>\
						<option name='carroMarca-"+data[i].id+"' value='"+data[i].carroMarca+"' selected>"+data[i].carroMarca+"</option>\
						<option name='carroMarca-924036' value='Fiat'>Fiat</option>\
						<option name='carroMarca-924077' value='Hyundai'>Hyundai</option>\
						<option name='carroMarca-514830' value='Wolksvagen'>Wolksvagen</option>\
						<option name='carroMarca-798429' value='Toyota'>Toyota</option>\
						<option name='carroMarca-254646' value='Ford'>Ford</option>\
						<option name='carroMarca-707132' value='Nissan'>Nissan</option>";

						//essa sessão queria deixar dinamica, mas não consegui pois o javascript não identificou metodos como .add e .option
						//selecao.add(novaOpcao);

			html +=	"</select>\
						</span>\
						<span class='input-group-btn'>\
						<input type='text' class='form-control' name='carroModelo-"+data[i].id+"' value='"+data[i].carroModelo+"' >\
						</span>\
						<span class='input-group-btn'>\
						<input type='text' class='form-control' name='carroAno-"+data[i].id+"' value='"+data[i].carroAno+"' >\
						</span>\
						<span class='input-group-btn' >\
						<div class='btn-group' role='group' >\
							<a href='javascript:updateCar("+data[i].id+");' class='btn btn-default' title='Remover' ><span class='glyphicon glyphicon-floppy-disk' \></span></a>\
							<a href='javascript:removeCar("+data[i].id+");' class='btn btn-default' title='Remover' ><span class='glyphicon glyphicon-remove' \></span></a>\
						</div>\
						</span>\
						</div>";
						
		};
		
		lista.html(html);
	});

}