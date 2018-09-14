
<footer> 
	
</footer>



<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>


<script type="text/javascript">
	$(document).ready(function(){
		var checkfade = true;
		$('.navbar-toggler').click(function(){
			if(checkfade == true){
			$('#topbar').css("background-color", "#000");
			checkfade = false;
			} else {
				$('#topbar').css("background-color", "rgba(0, 0, 0, 0.75)");
				checkfade = true;
			}
		});

	});
</script>

<script type="text/javascript">
	$(".car_edit").hide();
	var base_url = $(".car_edit form a").attr("href");
	$("#btn_add").click(function(e){
		e.preventDefault();
		var formData = {
            'strMarca'  : $('#form_add select[name=strMarca]').val(),
            'strModelo' : $('#form_add input[name=strModelo]').val(),
            'intAno'    : $('#form_add input[name=intAno]').val()
        };

		$.ajax({
	        type: "POST",
	        url: $("#form_add").attr("action"),
	        data: formData,
	        success: function(json){
	        	if(json.result)
	        		location.reload();
	        	else
	        		alert("erro");
	        }
	    });
	});
	$("#btn_att").click(function(e){
		e.preventDefault();
		var formData = {
			'intId'		: $('#form_att input[name=intId]').val(),
            'strMarca'  : $('#form_att select[name=strMarca]').val(),
            'strModelo' : $('#form_att input[name=strModelo]').val(),
            'intAno'    : $('#form_att input[name=intAno]').val()
        };

		$.ajax({
	        type: "POST",
	        url: $("#form_att").attr("action"),
	        data: formData, 
	        success: function(json){
	        	if(json.result)
	        		location.reload();
	        	else
	        		alert("erro");
	        }
	    });
	});
	$('a:not([role])').click(function(e){
		e.preventDefault();
		$.ajax({
	        type: "GET",
	        url: $(this).attr("href"),
	        success: function(json){
	        	if(json.result){
		        	$(".car_edit").fadeIn("slow", function() {
					    $("input[name=intId]").val(json.list_carro[0].intId);
					    $("input[name=strModelo]").val(json.list_carro[0].strModelo);
					    $("input[name=intAno]").val(json.list_carro[0].intAno);
					    $(".car_edit form a").attr("href", base_url + "carro/delete/" + json.list_carro[0].intId)
					    $("select[name=strMarca] > option").each(function() {
						    if(this.value == json.list_carro[0].strMarca){
								$(this).attr('selected', 'selected');
						    }
						});
				  	});
			  	}
	        }
	    });
	});
	$(".car_edit form a").click(function(e){
		e.preventDefault();
		$.ajax({
	        type: "GET",
	        url: $(this).attr("href"),
	        success: function(json){
	        	if(json.result){
		        	$(".car_edit").fadeOut("slow", function() {
					    $("input[name=intId]").val("");
					    $("select[name=strMarca]").val("");
					    $("input[name=strModelo]").val("");
					    $("input[name=intAno]").val("");
					    $(".car_edit form a").attr("href", "")
					    location.reload();
				  	});
	        	}
	        }
	    });

	});
</script>

</body>
</html>