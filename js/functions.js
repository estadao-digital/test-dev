function edit(id){
	$.ajax({
	  url: 'http://localhost/Adinan/test-dev/carros/1',
	  type: 'GET',
	  success: function(data) {
		var div = document.getElementById("results");
		div.innerHTML = "Carros registrados: <br><br>"+data;
	  }
	});
}

function save(id,marca,modelo,ano){
	//alert(marca.value+ ' ' +modelo.value+ ' '+ ano.value);
	$.ajax({
	  url: 'http://localhost/Adinan/test-dev/carros/'+id+'/'+marca.value+id+'/'+modelo.value+id+'/'+ano.value,
	  type: 'PUT',
	  success: function(data) {
		var div = document.getElementById("results");
		div.innerHTML = "Carros registrados: <br><br>"+data;
	  }
	});
}