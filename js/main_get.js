// Exibir página logo após o carregamento do DOM
document.addEventListener("DOMContentLoaded", VerificaCadastrados(false));

//  consultar todos carros
function VerificaCadastrados(limpar)
{
	if(limpar === true)
	{
		document.getElementsByClassName('tbodys')[0].innerHTML = ''
		document.getElementById('marcas').innerHTML = '';
		document.getElementById('marcaID').innerHTML = '';
	}

	$.ajax({
	  url: "carros/",
	  dataType: 'json',
	  method: 'GET',

	}).done(function(retornoJSON) {

		if(retornoJSON.RETORNO){
			var count_carros = 0;
		}
		else if(retornoJSON.carros)
		{
			var count_carros = retornoJSON.carros.length;
		}

		if(retornoJSON.marcas)
		{
			var count_marcas = retornoJSON.marcas.length;

			// inserir opção do select 'Selecionar'
			var select_marcas = document.getElementById('marcas');
			var options = document.createElement("option");
			var marcas_options = document.createTextNode("Selecionar");
			options.appendChild(marcas_options);
			select_marcas.appendChild(options);

			for(var i = 0; i < count_marcas; i++)
			{
				// inserir dinamicamente options do select das marcas do modal para cadastro
				var select_marcas = document.getElementById('marcas');
				var options = document.createElement("option");
				var marcas_options = document.createTextNode(retornoJSON.marcas[i]);
				options.appendChild(marcas_options);
				select_marcas.appendChild(options);

				// inserir dinamicamente options do select das marcas do modal para editar
				var select_marcaID = document.getElementById('marcaID');
				var options = document.createElement("option");
				var marcas_options_ID = document.createTextNode(retornoJSON.marcas[i]);
				options.appendChild(marcas_options_ID);
				select_marcaID.appendChild(options);
			}
		}

		if(count_carros  > 0)
		{
			// inserir dinamicamente informações dos carros retornados do ajax
			var trs = document.getElementsByClassName('tbodys')[0];

			for(var i = 0; i < count_carros; i++)
			{
				var tr = document.createElement("tr");

				// td id
				var td = document.createElement("td");
				var retorno_id = document.createTextNode(retornoJSON.carros[i].id);
				td.appendChild(retorno_id);
				tr.appendChild(td);

				// td Marca
				var td = document.createElement("td");
				var retorno_marca = document.createTextNode(retornoJSON.carros[i].Marca);
				td.appendChild(retorno_marca);
				tr.appendChild(td);

				// td Modelo
				var td = document.createElement("td");
				var retorno_modelo = document.createTextNode(retornoJSON.carros[i].Modelo);
				td.appendChild(retorno_modelo);
				tr.appendChild(td);

				// td Ano
				var td = document.createElement("td");
				var retorno_ano = document.createTextNode(retornoJSON.carros[i].Ano);
				td.appendChild(retorno_ano);
				tr.appendChild(td);

				// td icon edit
				var td = document.createElement("td");
				var a = document.createElement("a");
				a.setAttribute("onclick", 'consultarID('+retornoJSON.carros[i].id+')');
				var span = document.createElement("span");
				span.setAttribute("class", "glyphicon glyphicon-edit");
				span.setAttribute("aria-hidden", "true");
				a.appendChild(span);
				td.appendChild(a);
				tr.appendChild(td);

				// td icon delete
				var td = document.createElement("td");
				var a = document.createElement("a");
				a.setAttribute("onclick", 'excluirCarroID('+retornoJSON.carros[i].id+')');
				var span = document.createElement("span");
				span.setAttribute("class", "glyphicon glyphicon-remove");
				span.setAttribute("aria-hidden", "true");
				a.appendChild(span);
				td.appendChild(a);
				tr.appendChild(td);

				trs.appendChild(tr);

			}

			document.getElementsByClassName('hidden-table')[0].style.display = 'none';
			document.getElementsByClassName('table')[0].style.display = '';
		}
		else
		{
			document.getElementsByClassName('hidden-table')[0].style.display = 'block';
			document.getElementsByClassName('table')[0].style.display = 'none';
		}

		document.getElementsByTagName('body')[0].style.display = 'block';

	}).fail(function() {

		document.getElementsByClassName('table')[0].style.display = 'none';
		document.getElementsByTagName('body')[0].style.display = 'block';
		document.getElementsByClassName('hidden-error')[0].style.display = 'block';

  	});

}

// Retornar carro de um id expecífico
function consultarID(id)
{
	$.ajax({
	  url: "carros/"+id,
	  dataType: 'json',
	  method: 'GET',

	}).done(function(retornoConsultaID) {

		document.getElementById("modeloID").value = retornoConsultaID.Modelo;
		document.getElementById("marcaID").value = retornoConsultaID.Marca;
		document.getElementById("anoID").value = retornoConsultaID.Ano;
		sessionStorage.setItem('id', retornoConsultaID.id);

		$('#editarModal').modal('show');

	}).fail(function() {

		document.getElementsByClassName('hidden-error')[0].style.display = 'block';
		document.getElementsByClassName('table')[0].style.display = 'none';

  	});

}
