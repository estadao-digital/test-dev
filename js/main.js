$(function(){



	$('form').submit(function(){
		alert('ok');

		$.ajax({
			url: "excluir-carro.php",
			type: "post",
			data: $('form').serialize(),
			success: function(d) {
				alert(d);
			}
		});
	});


	$("#criar-carro").click(function(){
		$.ajax({
			url: "criar-carro.php",
			type: "post",
			data: $('form').serialize(),
			success: function() {
				alert('Carro incluído com sucesso');
				location.reload();
			}
		});

	});




});



