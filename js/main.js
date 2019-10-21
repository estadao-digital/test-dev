var BASE_URL = $('base').attr('base');

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
		headers:{"token":'3DFTaNupO5WSV142LxeiXgcZfOmWazto5pqN46rcNrsbCaRQrAt1BtD2xJyrIJkn'},
		success:function(data){
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
		url:BASE_URL+'api/marcas',
        method:'GET',
        dataType: "json",
		headers:{"token":'3DFTaNupO5WSV142LxeiXgcZfOmWazto5pqN46rcNrsbCaRQrAt1BtD2xJyrIJkn'},
		success:function(data){
			html = ""
			for (var i = data.length - 1; i >= 0; i--) {
				html += "<option value='"+data[i].id_marca+"'>"+data[i].marca+"</option>"
			}
			$('#marcas,#marcas').html(html)
			if(carro){
                $('.edit-form input[name=id]').val(carro.id)
                $('.edit-form input[name=modelo]').val(carro.modelo)
                $('.edit-form input[name=ano]').val(carro.ano)
                $('.edit-form select').val(carro.id_marca)
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
		url:"api/carros/"+id,
		method:"PUT",
		data: JSON.stringify(send),
		headers:{"token":'3DFTaNupO5WSV142LxeiXgcZfOmWazto5pqN46rcNrsbCaRQrAt1BtD2xJyrIJkn'},
		success:function(data){
			if(data.status){
                alert("Carro atualizado com sucesso!");
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
    console.log($(this).serialize());
	$.ajax({
		url:"api/carros",
        method:"POST",
        dataType: 'json',
        data: $(this).serialize(),
		headers:{"token":'3DFTaNupO5WSV142LxeiXgcZfOmWazto5pqN46rcNrsbCaRQrAt1BtD2xJyrIJkn'},
		success:function(data){            
			if(data.status == 'true'){

                alert("Carro cadastrado com sucesso!");
                window.location.replace(BASE_URL);

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
		url:BASE_URL+'api/carros/'+id,
		method:"DELETE",
		headers:{"token":'3DFTaNupO5WSV142LxeiXgcZfOmWazto5pqN46rcNrsbCaRQrAt1BtD2xJyrIJkn'},
		success:function(data){
			if(data.status){
                alert("Carro deletado com sucesso!");
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
		loadTableData($(this).attr('href'), {edit:true,delete:false});
    }
    
	if($(this).attr('href') == '#delete') {
		loadTableData($(this).attr('href'), {edit:false,delete:true});
    }
    
	if($(this).attr('href') == "#add"){
		$(".add-form").submit(addCarro);
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
	$('.error .alert').html(error);
	$('.error').removeClass('hidden');
	setTimeout(function(){
		$('.error').addClass('hidden');
	},3000)
}

//atribute error ajax
var ajaxError = function(err){
	errorAlert("Ocorreu um erro no sistema");
}