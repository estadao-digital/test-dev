marcas=["Marca A","Marca B","Marca C","Marca D"];
$(document).ready(function() {

	$("button.gravar").click(function() {
		$form = $(this).closest("tr.formulario");
		$carro={
			id : $form.find("input[name=id]").val(),
			marca : $form.find("select[name=marca]").val(),
			modelo : $form.find("input[name=modelo]").val(),
			ano : $form.find("input[name=ano]").val()
		}
		$.ajax("carros", {
			method : "POST",
			data : $carro,
            dataType: 'json',
			success : function() {
				$id = $form.find("input[name=id]").val("");
				$marca = $form.find("select[name=marca]").prop('selected', function() {
					return this.defaultSelected;
				});
				$modelo = $form.find("input[name=modelo]").val("");
				$ano = $form.find("input[name=ano]").val("");
			}
		});
	});

	$("button.editar").click(function() {
		$form = $(this).closest("tr.formulario");
		if (!$form.hasClass("ativo")) {
			$form.addClass("ativo");
		} else {
			$carro={
				id : $form.find("input[name=id]").val(),
				marca : $form.find("select[name=marca]").val(),
				modelo : $form.find("input[name=modelo]").val(),
				ano : $form.find("input[name=ano]").val()
			}
			$.ajax("carros/" + $id, {
				method : "PUT",
				data : $carro,
	            dataType: 'json',
				success : function(data) {
					$carro = $.parseJSON(data);
					$form.find(".id .visualizacao").text($carro["id"]);
					$form.find(".marca .visualizacao").text($carro["marca"]);
					$form.find(".modelo .visualizacao").text($carro["modelo"]);
					$form.find(".ano .visualizacao").text($carro["ano"]);
					$form.find("input[name=id]").val($carro["id"]);
					$form.find("select[name=marca]").prop('selected', function() {
						return $carro["marca"];
					});
					$form.find("input[name=modelo]").val($carro["modelo"]);
					$form.find("input[name=ano]").val($carro["ano"]);
					$form.removeClass("ativo");
				}
			});
		}
	});

	$("button.excluir").click(function() {
		$form = $(this).closest("tr.formulario");
		$id = $form.find("input[name='id']").val();
		$.ajax("carros/" + $id, {
			method : "DELETE",
			success : function() {
				$form.remove();
			}
		});
	});

	$("tr.formulario .editavel").dblclick(function() {
		$form = $(this).closest("tr.formulario");
		if (!$(this).hasClass("ativo")) {
			$(this).addClass("ativo");
		}
	});


	for(var i=0;i<marcas.lenght;i++){
		$("#marca").append($("<option></option>").attr("value",marcas[i]).text(marcas[i])); ;
	}
	
	$.ajax("carros", {
		method : "GET",
		success : function(data) {
			$tbody = $("table#listagem tbody");
			$.parseJSON(data).each(function() {
				$form="<tr class=\"formulario\">";
				$form+="<td class=\"id\" class=\"editavel\"><span class=\"visualizacao\">"+$carro["id"]+"</span><span class=\"edicao\"><input name=\"id\" type=\"text\" value=\""+$carro["id"]+"\" /></span></td>";
				$form+="<td class=\"marca\" class=\"editavel\"><span class=\"visualizacao\">"+$carro["marca"]+"</span><span class=\"edicao\"><select name=\"marca\"><option value=\"\"></option>";
				for(var i=0;i<marcas.lenght;i++){
					$form+="<option value=\""+marcas[i]+"\"";
					if(marcas[i]==$carro["marca"]){
						$form+=" selected=\"selected\"";
					}
					$form+=" >"+marcas[i]+"<option>";
				}
				$form+="</select></span></td>";
				$form+="<td class=\"modelo\" class=\"editavel\"><span class=\"visualizacao\">"+$carro["modelo"]+"</span><span class=\"edicao\"><input name=\"modelo\" type=\"text\" value=\""+$carro["modelo"]+"\" /></span></td>";
				$form+="<td class=\"ano\" class=\"editavel\"><span class=\"visualizacao\">"+$carro["ano"]+"</span><span class=\"edicao\"><input name=\"ano\" type=\"text\" value=\""+$carro["ano"]+"\" /></span></td>";
				$form+="<td><button class=\"gravar\" type=\"button\">Salvar</button></td><td></td></tr>";
				$tbody.append($form);
			});
		}
	});
});
