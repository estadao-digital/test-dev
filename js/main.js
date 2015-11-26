function incluirCarro(){

	$.ajax({
        url: "inclui.php",
        method: "GET"
    })
    .done(function(ret){
        $("div.principal").html(ret);
    })
    .fail(function(ret){
        alert("Erro ao carregar os dados para inserção!");
    });

}


function salvaCarro(){

	id = $("#id_carro").val();
	marca = $("#marca-carro").val();
	model = $("#modelo-carro").val();
	ano = $("#ano-carro").val();

	if(id == "" || marca == "" || model == "" || ano == ""){

		alert("Digite todos os campos para cadastrar um novo carro!");

	}else{

		$.ajax({
	        url: "salvarCarro.php",
	        method: "POST",
	        data: {
	        	id: id,
	        	marca: marca,
	        	model: model,
	        	ano: ano
	        }
	    })
	    .done(function(ret){
	        cancela();
	    })
	    .fail(function(ret){
	        alert("Erro ao carregar os dados para inserção!");
	    });

	}

}


function cancela(){

	$.ajax({
        url: "index.php",
        method: "GET"
    })
    .done(function(ret){
        $("div.principal").html(ret);
    })
    .fail(function(ret){
        alert("Erro ao carregar os dados para inserção!");
    });

}


function deletarCarro(id){

	$.ajax({
        url: "deletaCarro.php",
        method: "POST",
        data:{
        	id: id
        }
    })
    .done(function(ret){
        cancela();
    })
    .fail(function(ret){
        alert("Erro ao carregar os dados para inserção!");
    });

}
