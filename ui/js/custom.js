$( document ).ready(function() {
    getCarList(this);
    console.log("Lista os carros");
});

$(function() {
	$(document).on("click", "a#car_list", function(){ getCarList(this); });	
	$(document).on("click", "a#create_car_form", function(){ getCreateForm(this); });	
	$(document).on("click", "button#add_car", function(){ addCar(this); });
	$(document).on("click", "a.delete_confirm", function(){ deleteConfirmation(this); });
	$(document).on("click", "button.delete", function(){ deleteCar(this); });
	$(document).on("dblclick", "td.edit", function(){ makeEditable(this); });
	$(document).on("blur", "input#editbox", function(){ removeEditable(this) });
	$(document).on("blur", "select[name='marca']", function(){ removeEditable(this) });
});

function removeEditable(element) { 
	
	$('#indicator').show();
	
	var Car = new Object();
	Car.id = $('.current').attr('car_id');		
	Car.field = $('.current').attr('field');
	Car.newvalue = $(element).val();
	
	var carJson = JSON.stringify(Car);
	
	$.post('Controller.php',
		{
			action: 'update_field_data',			
			car: carJson
		},
		function(data, textStatus) {
			$('td.current').html($(element).val());
			$('.current').removeClass('current');
			$('#indicator').hide();			
		}, 
		"json"		
	);	
}

function makeEditable(element) {
	if($(element).attr("field") == "marca"){
		var oldText = $(element).text();

		$(element).html('<select class="form-control" id="marca editbox " name="marca">'
			+ '<option value="">Seleciona a marca do veiculo</option>'
			+ '<option id="Audi" value="Audi">Audi</option>'
			+ '<option id="BMW" value="BMW">BMW</option>'
			+ '<option id="Chevrolet" value="Chevrolet">Chevrolet</option>'
			+ '<option id="Dodge" value="Dodge">Dodge</option>'
			+ '<option id="Effa" value="Effa">Effa</option>'
			+ '<option id="Ferrari" value="Ferrari">Ferrari</option>'
			+ '<option id="Geely" value="Geely">Geely</option>'
			+ '<option id="Hyundai" value="Hyundai">Hyundai</option>'
			+ '<option id="Iveco" value="Iveco">Iveco</option>'
			+ '<option id="Jaguar" value="Jaguar">Jaguar</option>'
			+ '<option id="Kia" value="Kia">Kia</option>'
			+ '<option id="Lamborghini" value="Lamborghini">Lamborghini</option>'
			+ '<option id="Mercedes" value="Mercedes">Mercedes Benz</option>'
			+ '<option id="Mini" value="Mini">Mini</option>'
			+ '<option id="Porsche" value="Porsche">Porsche</option>'
			+ '<option id="Renault" value="Renault">Renault</option>'
			+ '<option id="Subaru" value="Subaru">Subaru</option>'
			+ '<option id="Toyota" value="Toyota">Toyota</option>'
			+ '<option id="Volvo" value="Volvo">Volvo</option>'
			+ '</select>');
		//$("#" + oldText).attr("selected", "selected");
		$('#'+oldText).prop('selected', true);
		//console.log("#"+oldText);
		//console.log($("#" + oldText).attr("selected", "selected"));

		
		$('#editbox').focus();
		$(element).addClass('current'); 
	} else{
		$(element).html('<input id="editbox" size="'+  $(element).text().length +'" type="text" value="'+ $(element).text() +'">');  
	$('#editbox').focus();
	$(element).addClass('current'); 
	}
	
	
}

function deleteConfirmation(element) {	
	$("#delete_confirm_modal").modal("show");
	$("#delete_confirm_modal input#car_id").val($(element).attr('car_id'));
	
}

function deleteCar(element) {	
	
	var Car = new Object();
	Car.id = $("#delete_confirm_modal input#car_id").val();

	var carJson = JSON.stringify(Car);

	$.post('Controller.php',
		{
			action: 'delete_car',
			car: carJson
		},
		function(data, textStatus) {
			getCarList(element);
			$("#delete_confirm_modal").modal("hide");
		}, 
		"json"		
	);	
}

function getCarList(element) {
	
	$('#indicator').show();
	
	$.post('Controller.php',
		{
			action: 'get_cars'				
		},
		function(data, textStatus) {
			renderCarList(data);
			$('#indicator').hide();
		}, 
		"json"		
	);
}

function renderCarList(jsonData) {
	
	var table = '<table width="100%" cellpadding="5" class="table table-hover table-bordered"><thead><tr><th scope="col">id</th><th scope="col">Marca</th><th scope="col">Modelo</th><th scope="col">Ano</th><th scope="col">Apagar</th></tr></thead><tbody>';

	$.each( jsonData, function( index, car){     
		table += '<tr>';
		table += '<td class="" field="id" car_id="'+car.id+'">'+car.id+'</td>';
		table += '<td class="edit" data-id="marca" field="marca" car_id="'+car.id+'">'+car.marca+'</td>';
		table += '<td class="edit" field="modelo" car_id="'+car.id+'">'+car.modelo+'</td>';
		table += '<td class="edit" field="ano" car_id="'+car.id+'">'+car.ano+'</td>';
		table += '<td><a href="javascript:void(0);" car_id="'+car.id+'" class="delete_confirm btn btn-danger"><i class="icon-remove icon-white"></i></a></td>';
		table += '</tr>';
    });
	
	table += '</tbody></table><small>Para editar clique duas vezes no item desejado</small>';
	
	$('div#content').html(table);
}

function addCar(element) {
	if($('select[name="marca"]').val() === "" || $('input#modelo').val() === "" || $('input#ano').val() === ""){
		alert("Por favor verifique se todos os campos foram preenchdos");
	}else{
		$('#indicator').show();
		var Car = new Object();
		Car.marca  = $('select[name="marca"]').val();
		Car.modelo = $('input#modelo').val();
		Car.ano    = $('input#ano').val();

		
		var carJson = JSON.stringify(Car);
		
		$.post('Controller.php',
			{
				action: 'add_car',
				car: carJson
			},
			function(data, textStatus) {
				getCarList(element);
				$('#indicator').hide();
			}, 
			"json"		
		);

		}	
}

function getCreateForm(element) {
	var form =	'<div class="input-prepend">';
		form += '<h3>Informações do Veiculo</h3>';
		form +=	'<select class="form-control" id="marca" name="marca">';
		form += '<option value="">Seleciona a marca do veiculo</option>';
      	form += '<option value="Audi">Audi</option>';
      	form += '<option value="BMW">BMW</option>';
      	form += '<option value="Chevrolet">Chevrolet</option>';
      	form += '<option value="Dodge">Dodge</option>';
      	form += '<option value="Effa">Effa</option>';
      	form += '<option value="Ferrari">Ferrari</option>';
      	form += '<option value="Geely">Geely</option>';
      	form += '<option value="Hyundai">Hyundai</option>';
      	form += '<option value="Iveco">Iveco</option>';
      	form += '<option value="Jaguar">Jaguar</option>';
      	form += '<option value="Kia">Kia</option>';
      	form += '<option value="Lamborghini">Lamborghini</option>';
      	form += '<option value="Mercedes Benz">Mercedes Benz</option>';
      	form += '<option value="Mini">Mini</option>';
      	form += '<option value="Porsche">Porsche</option>';
      	form += '<option value="Renault">Renault</option>';
      	form += '<option value="Subaru">Subaru</option>';
      	form += '<option value="Toyota">Toyota</option>';
      	form += '<option value="Volvo">Volvo</option>';
    	form += '</select>';
		form +=	'</div><br/><br/>';

		form +=	'<div class="input-prepend">';
		form +=	'<span class="add-on"><i class="fas fa-car-alt"></i> &nbsp; Modelo</span>';
		form +=	'<input type="text" id="modelo" name="modelo" value="" />';
		form +=	'</div><br/><br/>';
				
		form +=	'<div class="input-prepend">';
		form +=	'<span class="add-on"><i class="far fa-calendar-alt"></i> &nbsp Ano</span>';
		form +=	'<input type="text" id="ano" name="ano" value=""  />';
		form +=	'</div><br/><br/>';

		form +=	'<div class="control-group">';
		form +=	'<div class="">';		
		form +=	'<button type="button" id="add_car" class="btn btn-primary"><i class="icon-ok icon-white"></i> Add Carro</button>';
		form +=	'</div>';
		form +=	'</div>';
		
		$('div#content').html(form);
}