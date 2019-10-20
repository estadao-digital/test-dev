var BASE_URL = "http://localhost:8080/final/api";//base url api

$(document).ready(function(){
	var uriHash = window.location.hash//get hash url #example
	loadSection(uriHash)

	$('a.nav-link').click(changeTable)

	loadTableData(uriHash)

	getMarcas()

})

//load itens table
var loadTableData = function(table,action = {edit:false, delete: false}){
	$.ajax({
		url:BASE_URL+'api/carros',
		method:'GET',
		headers:{"TOKEN":window.localStorage.getItem('token')},
		success:function(data){
			console.log(data);
			if(data.status && data.data.length > 0){
				var carros = data.data;
				var html = "";
				for (var i = carros.length - 1; i >= 0; i--) {
					html += "<tr><td>"+carros[i].marca+"</td><td>"+carros[i].modelo+"</td><td>"+carros[i].ano+"</td>"
					if(action.edit){
						html += "<td><button type='button' class='btn btn-primary' data-carro='"+JSON.stringify(carros[i])+"'>Editar</button></td>"
					}
					if(action.delete){
						html += "<td><button type='button' class='btn btn-danger' data-id='"+carros[i].id+"'>Deletar</button></td>"
					}
					html += "</tr>"
				}
				$(table+" table tbody").html(html)
				if(action.edit || action.delete){
					$(table+" button").click(actionButton)
				}
			}
		},
		error:ajaxError
	})
}

//action button edit and delete
var actionButton = function(event){
	var carro = $(this).data('carro')
	var id = $(this).data('id')
	if(carro){
		getMarcas(carro)
		$('.modal-edit').modal()
		$('.edit-form').submit(sendEdit)
	}
	if(id){
		deleteCarro(id)
	}

}

//get marcas of select
var getMarcas = function(carro = false){
	$.ajax({
		url:BASE_URL+'/marcas',
		method:'GET',
		headers:{"TOKEN":window.localStorage.getItem('token')},
		success:function(data){
			if(data.redirect){window.location.href = "/login.php"}
			html = ""
			for (var i = data.length - 1; i >= 0; i--) {
				html += "<option value='"+data[i].marca+"'>"+data[i].marca+"</option>"
			}
			$('#marcas,#marcas').html(html)
			if(carro){
			$('.edit-form input[name=id]').val(carro.id)
			$('.edit-form input[name=modelo]').val(carro.modelo)
			$('.edit-form input[name=ano]').val(carro.ano)
			$('#marcas').val(carro.marca)
			}
		},
		error:ajaxError
	})
}

//send data edit carro
var sendEdit = function(event){
	event.preventDefault()
	var id = $('input[name=id]',this).val()
	var send = {
		modelo:$('input[name=modelo]',this).val(),
		marca:$('select[name=marca]',this).val(),
		ano:$('input[name=ano]',this).val()
	}
	$.ajax({
		url:"/api/carros/"+id,
		method:"PUT",
		data: JSON.stringify(send),
		headers:{"TOKEN":window.localStorage.getItem('token')},
		success:function(data){
			if(data.redirect){window.location.href = "/login.php"}
			if(data.status){
				loadSection('#list')
				loadTableData('#list')
				$('.edit-form input[name=id]').val("")
				$('.edit-form input[name=modelo]').val("")
				$('.edit-form input[name=ano]').val("")
				$('.modal-edit').modal('hide')
			}else{
				errorAlert(data.error)
			}
		},
		error:ajaxError
	})
	return false
}

//add item carro
var addCarro = function(event){
	event.preventDefault()
	that = this
	$.ajax({
		url:"/api/carros",
		method:"POST",
		data: $(this).serialize(),
		headers:{"TOKEN":window.localStorage.getItem('token')},
		success:function(data){
			if(data.redirect){window.location.href = "/login.php"}
			if(data.status){
				loadSection('#list')
				loadTableData('#list')
				$('input[name=modelo]',that).val("")
				$('select[name=marca]',that).val("")
				$('input[name=ano]',that).val("")
			}else{
				errorAlert(data.error)
			}			
		},
		error:ajaxError
	})
	return false
}

//delete item carro
var deleteCarro = function(id){
	$.ajax({
		url:BASE_URL+'/carros/'+id,
		method:"DELETE",
		headers:{"TOKEN":window.localStorage.getItem('token')},
		success:function(data){
			if(data.redirect){window.location.href = "/login.php"}
			if(data.status){
				loadSection('#list')
				loadTableData('#list')
			}else{
				errorAlert(data.error)
			}
		},
		error:ajaxError
	})
}

//change table menu
var changeTable = function(event){
	if($(this).attr('href') == '#edit') {
		loadTableData($(this).attr('href'), {edit:true,delete:false})
	}
	if($(this).attr('href') == '#delete') {
		loadTableData($(this).attr('href'), {edit:false,delete:true})
	}
	if($(this).attr('href') == "#add"){
		$(".add-form").submit(addCarro)
	}

	loadSection($(this).attr('href'));
	$('.active').removeClass('active')
	$(this).addClass('active');
	$('.navbar-collapse').collapse('hide');
	event.preventDefault();
}

//show section selected
var loadSection = function(hash){
	if(!hash) hash = '#list'
	if(hash == "#list"){
		$('.active').removeClass('active')
		$("a.nav-link[href='#list']").addClass('active');
	}

	$('#list').addClass('hidden');
	$('#add').addClass('hidden');
	$('#edit').addClass('hidden');
	$('#delete').addClass('hidden');
	
	$(hash).removeClass('hidden');

}

//function show error
var errorAlert = function(error){
	$('.error .alert').html(error)
	$('.error').removeClass('hidden')
	setTimeout(function(){
		$('.error').addClass('hidden')
	},3000)
}

//atribute error ajax
var ajaxError = function(err){
	errorAlert("Ocorreu um erro no sistema")
	console.log(err)
}