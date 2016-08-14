// Escutar botão atualizar do modal para editar um carro com um id específico
document.getElementById('editar').addEventListener("click", validarCamposPut);

// funcão para verificar se todos os campos foram preenchidos
function validarCamposPut()
{
	var modeloID = document.getElementById('modeloID').value;
	var marcaID = document.getElementById('marcaID').value;
	var anoID = document.getElementById('anoID').value;
	var idID = sessionStorage.getItem('id');
	sessionStorage.clear();

	if(modeloID === '' || marcaID === '' || anoID === '' || marcaID === 'Selecionar')
	{
		$(function () {
		  $('[data-toggle="popoverID"]').popover();
		})
	} 
	else 
	{
		editarCampos(modeloID, marcaID, anoID, idID);
	}
}

function editarCampos(modeloID, marcaID, anoID, idID)
{
	$.ajax({
	  url: "carros/",
	  dataType: 'text',
	  method: 'PUT',
	  data: 'acao=Editar&modelo='+modeloID+'&marca='+marcaID+'&ano='+anoID+'&id='+idID

	}).done(function(retornoAtualizar) {

		if(retornoAtualizar === 'PUT-OK')
		{
			document.getElementById('modeloID').value = '';
			document.getElementById('marcaID').value = '';
			document.getElementById('anoID').value = '';

			$(function () {
			   $('#editarModal').modal('toggle');
			});
			VerificaCadastrados(true);
		}
		else 
		{
			retornoPutDeleteErro();
		}

	}).fail(function() {

		retornoPutDeleteErro();

  	});

}

function excluirCarroID(id){

	$.ajax({
	  url: "carros/",
	  dataType: 'text',
	  method: 'DELETE',
	  data: 'acao=Deletar&id='+id

	}).done(function(retornoDeletar) {

		if(retornoDeletar === 'DELETE-OK')
		{
			VerificaCadastrados(true);
		}
		else 
		{
			retornoPutDeleteErro();
		}

	}).fail(function() {

		retornoPutDeleteErro();

  	});

}

function retornoPutDeleteErro()
{
	$(function () {
	   $('#editarModal').modal('toggle');
	});
	document.getElementsByClassName('hidden-error')[0].style.display = 'block';
	document.getElementsByClassName('table')[0].style.display = 'none';
}
