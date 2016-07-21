(function ($) {
	"use strict";

	// Dom Ready Function
	$(document).on('ready', function () {
		// add your functions
		$( "body" ).on( "click", "#add_carro", function() {
			var datastring = $("#addCarro").serialize();
			$.ajax({
			    type: "POST",
			    url: "api.php",
			    data: datastring,
			    success: function(data) {
			        if(data == "OK"){
			        	$("body").load("index.php");
			        }
			    }
			});
		});
		$( "body" ).on( "click", "#edit_carro_ok", function() {
		
			var id = $(this).data("carro");
			var enviar = "#editCarro"+id;
			var carro = $("#carro"+id).val();
			var marca = $("#marca"+id).val();
			var ano = $("#ano"+id).val();
			
			$.ajax({
			    type: "POST",
			    url: "api.php",
			    data: "ano="+ano+"&marca="+marca+"&carro="+carro+"&_METHOD=PUT&id="+id,
			    success: function(data) {
			        if(data == "OK"){
			        	$("body").load("index.php");
			        }
			    }
			});
		});
		$("body").on("click",".delete_carro",function(){
			var id = $(this).data("id");
			$.ajax({
			    type: "POST",
			    url: "api.php",
			    data: "&_METHOD=DELETE&id="+id,
			    success: function(data) {
			        if(data == "OK"){
			        	$("body").load("index.php");
			        }
			    }
			});
		});
		
	});


	

})(jQuery);