
	base_url = window.location.origin+'/prova/';   
	console.log(base_url);
	novoAtivo = false;
	
	function editarItem(item){
		if(novoAtivo == true){
			$('table.clean tr:last').remove();
			$('button[onclick="montarNovoTr()"]').removeClass('hide-left');
		}
		el = $('tr[data-item="'+item+'"]');
		if($('tr.active').length <= 0){
			$(el).addClass('active');
			// Transformando o botão.
			buttonHtml = $(el).find('button[onclick="editarItem('+item+')"]').html();
			
			$(el).find('button[onclick="editarItem('+item+')"]').attr('title','Salvar.').attr('onclick','salvarItem('+item+')').removeClass('button-blue').addClass('button-green').html('<i class="fa fa-check" aria-hidden="true"></i>');
			$(el).children('td:last').append('<button type="button" onclick="excluirItem('+item+')" class="button button-3d button-red button-mini circle" title="Excluir"><i class="fa fa-trash-o" aria-hidden="true"></i></button>');
			
			// Criando os inputs para edição.
			dataModelo = $(el).children('td[data-edit="modelo"]').text();	
			$(el).children('td[data-edit="modelo"]').html('<input type="text" value="'+dataModelo+'" name="modelo" id="modelo">');
			
			dataAno = $(el).children('td[data-edit="ano"]').text();	
			$(el).children('td[data-edit="ano"]').html('<input type="text" value="'+dataAno+'" name="ano" id="ano">');
			
			dataMarca = $(el).children('td[data-edit="marca"]').attr('data-select');
			
			$.ajax({
				url: base_url+'carros/ajax-lista-marcas',
				success: function(data){
				$(el).children('td[data-edit="marca"]').html('<select name="marca" id="marca"></select>');
					marcas = JSON.parse(data);
					for(i=0;i<marcas.length;i++){
						if(marcas[i]['id'] == dataMarca){
							$('select#marca').attr('value',dataMarca);
							$('select#marca').append('<option value="'+marcas[i]['id']+'" selected>'+marcas[i]['nome']+'</option>');
						}
						else{
							$('select#marca').append('<option value="'+marcas[i]['id']+'">'+marcas[i]['nome']+'</option>');
						}
					}			
				}
			});
		}
	}
	function excluirItem(item){
		$.ajax({
			url: base_url+'carros/ajax-excluir-item',
			type: 'POST',
			data:{item:item},
			success: function(result){
				$('table.clean tbody').html(result);
			}
		});
	}
	function salvarItem(item){
		modelo = $('input#modelo').val();
		ano = $('input#ano').val();
		marca = $('select#marca').val();	

		if(modelo.length == 0 || ano.length == 0 || marca == 0){
			
			$('table.clean').parent().append('<div class="alert-box"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Todos campos devem ser preenchidos.</div>');
			setTimeout(function(){
				$('.alert-box').slideUp(200, function(){
					$('.alert-box').remove();
				});
			},5000);
			return false;
		}
		
		$.ajax({
			url: base_url+'carros/ajax-salvar',
			type: 'POST',
			data: { item:{
						id: item,
						modelo: modelo,
						ano: ano,
						marca: marca
					}
				},
			success: function(result){
				$('tr.active input').each(function(){
					var el = $(this);
					var dataText = $(el).val();
					$(el).parent().html(dataText);					
				});
				marcaText = $('tr.active select#marca option[value="'+marca+'"]').html();
				$('tr.active select#marca').parent().html(marcaText);
				$('tr.active').find('button[onclick="salvarItem('+item+')"]').attr('title','Editar.').attr('onclick','editarItem('+item+')').removeClass('button-green').addClass('button-blue').html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>');
				$('button[onclick="excluirItem('+item+')"]').remove();
				$('tr.active').removeClass('active');	
				
			}
				
		});
		
	}
	function montarNovoTr(){
		if($('tr.active').length > 0){
			item = $('tr.active').attr('data-item');
			if(salvarItem(item) == false){
				return false;
			}
		}
		novoAtivo = true;
		$('table.clean').append('<tr><td></td><td><input type="text" id="modelo"></td><td><input type="text" id="ano"></td><td data-edit="marca" data-select="0"><select name="marca" id="marca"><option value="" selected>Selecione...</option></select></td><td><button type="button" onclick="criarItem(this)" class="button button-3d button-green button-mini circle" title="Criar"><i class="fa fa-plus" aria-hidden="true"></i></button></td></tr>');
		$.ajax({
			url: base_url+'carros/ajax-lista-marcas',
			success: function(data){
				marcas = JSON.parse(data);
				for(i=0;i<marcas.length;i++){
					$('select#marca').append('<option value="'+marcas[i]['id']+'">'+marcas[i]['nome']+'</option>');					
				}
				$('button[onclick="montarNovoTr()"]').addClass('hide-left');
			}
		});
	}
	function criarItem(el){
		trEl = $(el).parent().parent();
		modelo = $('input#modelo').val();
		ano = $('input#ano').val();
		marca = $('select#marca').val();
		
		if(modelo.length == 0 || ano.length == 0 || marca == 0){
			
			$('table.clean').parent().append('<div class="alert-box"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Todos campos devem ser preenchidos.</div>');
			setTimeout(function(){
				$('.alert-box').slideUp(200, function(){
					$('.alert-box').remove();
				});
			},5000);
			return false;
		}
		
		$.ajax({
			url: base_url+'carros/ajax-criar-item',
			type: 'POST',
			data: { item:{
						modelo: modelo,
						ano: ano,
						marca: marca
					}
				},
			success: function(result){
				$('table.clean tbody').html(result);
				$('button[onclick="montarNovoTr()"]').removeClass('hide-left');
				novoAtivo = false;
			}				
		});
		
	}