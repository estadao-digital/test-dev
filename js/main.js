$('#listAll').on('click', function(){
	fill( send('get', null, null) );
});

$('#findCar').on ('click', function(){
	id = $('input[name=carId]').val();
	if ( !id ) {
		$('#alert-error p').empty();
		$('#alert-error p').append("ID inválido");
		$('#alert-error').fadeIn();
		return;
	}
	data = send('GET',  id);
	if ( data.msg ) {
		$('#alert-error p').empty();
		$('#alert-error p').append(data.msg);
		$('#alert-error').fadeIn();
	} else {
		fill([data]);
	}
});

$('#addCar').on('click', function(){
	brand = $('input[name=brand]').val();
	model = $('input[name=model]').val();
	year = $('input[name=year]').val();
	if ( brand.length <= 0 || model.length <= 0 || year.length <= 0 ) {
		$('#alert-error p').empty();
		$('#alert-error p').append("Dados incorretos");
		$('#alert-error').fadeIn();
		return;
	}
	data = {
		'brand': brand,
		'model': model,
		'year': year,
	}
	fill([send('POST', null, data)]);
});


function removeCar(id) {
	pending_deletion_id = id;
	$('#confirm').modal('show');
}
$('#confirmDeletion').on('click', function(){
	data = send('delete', pending_deletion_id);
	$(('#car-'+pending_deletion_id)).remove();
	$('#confirm').modal('hide');
	$('#alert-success p').empty();
	$('#alert-success p').append(data.msg);
	$('#alert-success').fadeIn();
});


function updateCar(id) {
	brand = $(('input[name=brand-'+id+']')).val();
	model = $(('input[name=model-'+id+']')).val();
	year = $(('input[name=year-'+id+']')).val();
	if ( brand.length <= 0 || model.length <= 0 || year.length <= 0 ) {
		$('#alert-error p').empty();
		$('#alert-error p').append("Dados incorretos");
		$('#alert-error').fadeIn();
		return;
	}
	data = {
		'brand': brand,
		'model': model,
		'year': year,
	}
	result = send('PUT', id, data)
	$('#alert-success p').empty();
	$('#alert-success p').append(result.msg);
	$('#alert-success').fadeIn();
}

function fill(data) {
	$('#listings').empty();
	content = '';
	for ( i in data ) {
		content += '<div class="input-group" id="car-'+data[i].id+'" >\
						<span class="input-group-btn">\
							<input type="text" class="form-control" name="id-'+data[i].id+'" value="'+data[i].id+'" readonly >\
						</span>\
						<span class="input-group-btn">\
							<input type="text" class="form-control" name="brand-'+data[i].id+'" value="'+data[i].brand+'"  >\
						</span>\
						<span class="input-group-btn">\
							<input type="text" class="form-control" name="model-'+data[i].id+'" value="'+data[i].model+'" >\
						</span>\
						<span class="input-group-btn">\
							<input type="text" class="form-control" name="year-'+data[i].id+'" value="'+data[i].year+'" >\
						</span>\
						<span class="input-group-btn" >\
							<div class="btn-group" role="group" >\
								<a href="javascript:updateCar('+data[i].id+');" class="btn btn-default" title="Remover" ><span class="glyphicon glyphicon-floppy-disk" \></span></a>\
								<a href="javascript:removeCar('+data[i].id+');" class="btn btn-default" title="Remover" ><span class="glyphicon glyphicon-remove" \></span></a>\
							</div>\
						</span>\
					</div>';
	}
	$('#listings').append( content );
}

function send(method, id, data) {
	call = './api.php';
	if ( id ) {
		call += '?id='+id;
	}
	result = null;
	$.ajax({
		type: method,
		url: call,
		data: JSON.stringify(data),
		dataType: 'JSON',
		contentType : 'application/json',
		processData: false,
		async: false,
		complete: function(data) {
			result = JSON.parse(data.responseText);
		}
	});
	return result;
}