// Escutar botão salvar do modal para validar se todos os campos foram preenchidos
document.getElementById('salvar').addEventListener("click", validarCamposPost);

// funcão para verificar se todos os campos foram preenchidos
function validarCamposPost()
{
	var modelo = document.getElementById('modelo').value;
	var marca = document.getElementById('marcas').value;
	var ano = document.getElementById('ano').value;

	if(modelo === '' || marca === '' || ano === '' || marca === 'Selecionar')
	{
		$(function () {
		  $('[data-toggle="popover"]').popover()
		})
	} 
	else 
	{
		cadastrar(modelo, marca, ano);
	}
}

//  cadastrar novo carro
function cadastrar(modelo, marca, ano)
{
	$.ajax({
	  url: "carros/",
	  dataType: 'text',
	  method: 'POST',
	  data: 'acao=Cadastrar&modelo='+modelo+'&marca='+marca+'&ano='+ano

	}).done(function(retornoCadastro) {

		if(retornoCadastro === 'POST-OK')
		{
			document.getElementById('modelo').value = '';
			document.getElementById('marcas').value = '';
			document.getElementById('ano').value = '';

			$(function () {
			   $('#cadastroModal').modal('toggle');
			});
			
			VerificaCadastrados(true);
		} 
		else
		{
			retornoPostErro();
		}

	}).fail(function() {

		retornoPostErro();

  	});

}

function retornoPostErro(){

	$(function () {
	   $('#cadastroModal').modal('toggle');
	});
	document.getElementsByClassName('hidden-error')[0].style.display = 'block';
	document.getElementsByClassName('table')[0].style.display = 'none';
	
}
