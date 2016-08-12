$(function(){
	$("#btnVerListaCarros").click(function(){
		$("#areaDadosHome").hide();
		$("#painelListadeCarros").show();
		listarTodos();
	});
	$("#btnHome").click(function(){
		$("#areaDadosHome").show();
		$("#painelListadeCarros").hide();
	});
	$("#btnNovoCarro,#mnuNovoCarro").click(function(){
		$("#carro_id").val("");
		$("#carro_marca").val("");
		$("#carro_modelo").val("");
		$("#carro_ano").val("");
		$("#modalDetalheCarro").modal();
	});
	$("#mnuListaCarros").click(function(){
		listarTodos();
	});
});

function listarTodos(){
    $.ajax({
		url: '/carros/rest/carros/',
		type: 'GET',                  
		dataType: 'json',
		beforeSend: function() {},
		complete: function() {},
		success: function (result) {
			var i;
			html="";
			for(i = 0; i < result.length; i++) {
				var carro = result[i];
				html+= "<div class='row' id='CARRO_"+carro.id+"'>";
				html+= "<div class='col-sm-3' id='MARCA_"+carro.id+"'>"+carro.marca+"</div>";
				html+= "<div class='col-sm-3' id='MODELO_"+carro.id+"'>"+carro.modelo+"</div>";
				html+= "<div class='col-sm-3' id='ANO_"+carro.id+"'>"+carro.ano+"</div>";
				html+= "<div class='col-sm-3'>";
				html+= 		"<button type='button' class='btn btn-warning' idcarro='"+carro.id+"'>editar</button>";
				html+= 		"<button type='button' class='btn btn-danger'  idcarro='"+carro.id+"'>remover</button>";					
				html+= "</div>";
				html+= "</div>";
			}
			$("#rowsDadosListaCarros").html(html);	
			$(".btn.btn-danger").click(function(){
				var idcarro = $(this).attr("idcarro");
				if(confirm("Registro do Carro de Id:"+idcarro+" sera Removido. Confirma?" )){
					removerCarro(idcarro);
				}
			});
			$(".btn.btn-warning").click(function(){
				var idcarro = $(this).attr("idcarro");
				editarCarro(idcarro);
			});
			$("#btnSubmitDetalheCarro").click(function(){
				if($("#carro_id").val()==""){
					inserirCarro();
				}else{
					atualizarCarro();	
				}
			});
			$("div.row").click(function(){
				$("div.row").each(function() {
					$(this).css("border","solid #ccc 1px");
				});
				$(this).css("border","solid blue 3px");
			});	
		},
		error: function (request,error) {
			alert(error);
		}
	}); 
}

function inserirCarro(){
	if(	$("#carro_marca").val()==""||
		$("#carro_modelo").val()==""||
		$("#carro_ano").val()=="" ){
			alert("faltam dados. Verifique.");
			return false;
		}
	var params = "marca="+$("#carro_marca").val()+
				 "&modelo="+$("#carro_modelo").val()+
				 "&ano="+$("#carro_ano").val();
	var novalinha=0;			 
    $.ajax({
		url: '/carros/rest/carros/',
		type: 'POST',
		dataType: 'json',		
		data:params,
		success: function (result) {
			if(result.inserido>0){
				$("#modalDetalheCarro").modal('toggle');
				html = "<div class='row' id='CARRO_"+result.inserido+"'>";
				html+= "<div class='col-sm-3' id='MARCA_"+result.inserido+"'>"+$("#carro_marca").val()+"</div>";
				html+= "<div class='col-sm-3' id='MODELO_"+result.inserido+"'>"+$("#carro_modelo").val()+"</div>";
				html+= "<div class='col-sm-3' id='ANO_"+result.inserido+"'>"+$("#carro_ano").val()+"</div>";
				html+= "<div class='col-sm-3'>";
				html+= 		"<button type='button' class='btn btn-warning' idcarro='"+result.inserido+"'>editar</button>";
				html+= 		"<button type='button' class='btn btn-danger'  idcarro='"+result.inserido+"'>remover</button>";					
				html+= "</div>";
				html+= "</div>";
				$("#rowsDadosListaCarros").append(html);
				novalinha = result.inserido;
				$(".btn.btn-danger").click(function(){
					var idcarro = $(this).attr("idcarro");
					if(confirm("Registro do Carro de Id:"+idcarro+" sera Removido. Confirma?" )){
						removerCarro(idcarro);
					}
				});
				$(".btn.btn-warning").click(function(){
					var idcarro = $(this).attr("idcarro");
					editarCarro(idcarro);
				});
			}
		},
		complete: function(){
			$("div.row").each(function() {
				$(this).css("border","solid #ccc 1px");
			});
	
			$("div.row").click(function(){
				$("div.row").each(function() {
					$(this).css("border","solid #ccc 1px");
				});
				$(this).css("border","solid blue 3px");
			});	
			
			$("#CARRO_"+novalinha).css("border","solid blue 3px");

		},
		error: function (request,error) {
			alert(error);
		}
	}); 
}
function atualizarCarro(){
	if(	$("#carro_marca").val()==""||
		$("#carro_modelo").val()==""||
		$("#carro_ano").val()=="" ){
			alert("faltam dados. Verifique.");
			return false;
		}
	var params = "id="+$("#carro_id").val()+
				 "&marca="+$("#carro_marca").val()+
				 "&modelo="+$("#carro_modelo").val()+
				 "&ano="+$("#carro_ano").val();
    $.ajax({
		url: '/carros/rest/carros/',
		type: 'PUT',
		dataType: 'json',		
		data:params,
		success: function (result) {
			var idrow = $("#carro_id").val();
			$("#modalDetalheCarro").modal('toggle');
			$("#MARCA_"+idrow).html(result.marca);
			$("#MODELO_"+idrow).html(result.modelo);
			$("#ANO_"+idrow).html(result.ano);
		},
		complete: function (result) {
			var idrow = $("#carro_id").val();
			$("#CARRO_"+idrow).css("border","solid blue 3px");
		},
		error: function (request,error) {
			alert(error);
		}
	}); 
}

function removerCarro(idcarro){
	var params = "id="+idcarro;
    $.ajax({
		url: '/carros/rest/carros/',
		type: 'DELETE',                  
		dataType: 'json',
		data:params,
		beforeSend: function() {},
		complete: function() {},
		success: function (result) {
			if (result.removido){
				$("#CARRO_"+idcarro).remove();
			}	
		},
		error: function (request,error) {
			alert(error);
		}
	}); 
}
function editarCarro(idcarro){
	var params = "id="+idcarro;
    $.ajax({
		url: '/carros/rest/carros/',
		type: 'GET',                  
		dataType: 'json',
		data:params,
		beforeSend: function() {},
		complete: function() {},
		success: function (result) {
			$("#modalDetalheCarro").modal();
			$("#carro_id").val(result.id);
			$("#carro_marca").val(result.marca);
			$("#carro_modelo").val(result.modelo);
			$("#carro_ano").val(result.ano);
		},
		error: function (request,error) {
			alert(error);
		}
	}); 
}
