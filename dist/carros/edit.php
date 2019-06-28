<?php
	require_once '../Carro.class.php';
	$getid = isset($_POST['getid']) ? $_POST['getid']: '';
	$getmarca = isset($_POST['getmarca']) ? $_POST['getmarca']: '';
	$getmodelo = isset($_POST['getmodelo']) ? $_POST['getmodelo']: '';
	$getano = isset($_POST['getano']) ? $_POST['getano']: '';

	// 00 - SELECT MARCA
	echo '
	<span class="id-campo">#'.$getid.'</span>';

	// 01 - SELECT MARCA
	echo '
	<span>
	<select name="editmarca" id="editmarca" class="edit-campo" data-orig="'.$getmarca.'" value="'.$getmarca.'">
	<option value="">Selecione a Marca</option>';
	
	foreach ($dataMJSON -> marcasJSON as $marca){

		if ( $getmarca == $marca->Marca ) {
			echo '
			<option value="'.$marca->Marca.'" marca-id="'.$marca->Marca.'" selected>'.$marca->Marca.'</option>
			';
		} else {
			echo '
			<option value="'.$marca->Marca.'" marca-id="'.$marca->Marca.'">'.$marca->Marca.'</option>
			';
		}
	}
	echo '</select></span>';

	// 02 - MODELO
	echo '
	<span>
	<input type="text" name="editmodelo" id="editmodelo" class="edit-campo" data-orig="'.$getmodelo.'" value="'.$getmodelo.'">
	</span>';

	// 03 - ANO
	echo '
	<span>
	<input type="text" name="editano" id="editano" class="edit-campo" data-orig="'.$getano.'" value="'.$getano.'">
	</span>';

	// 03 - ACTION
	echo '
	<span>
	<div class="btn-action btn-ok" action="ok"></div>
	<div class="btn-action btn-cancel" action="cancel"></div>
	</span>';
?><script>
	function editaCarro(id, marca, modelo, ano){
		var pageID = 'carros/'+id;

		// Confirmar Editar
		var editaPergunta = window.confirm(`Parece que todos os campos foram preenchidos corretamente!\nVocê quer mesmo prosseguir com essa alteração?\n\nID: ${id}\nMarca: ${marca}\nModelo: ${modelo}\nAno: ${ano}`);
		
		// Editar
		if ( editaPergunta == true ) {
			$.ajax({
				method: "POST",
				url: pageID,
				data: { 
					action: 'edit',
					marca: marca,
					modelo: modelo,
					ano: ano
				}
			}).done(function( msg ) {
				
				if (msg == 'editado'){
					// Carrega Carros
					$('#spa').load('carros/index.php');
				}
			});
		} else {
			return false;
		}
	}



	$('.btn-cancel').on('click', function(){
		var confirmaCancel = window.confirm('Você quer mesmo cancelar essa edição?\nTodos os campos alterados serão perdidos permanentemente!');
		if ( confirmaCancel == true ){
			$('#spa').fadeOut(100);
			$('#spa').load('carros/index.php');
			$('#spa').fadeIn(100);
		}
	});

	// Modelo
	$('#editmarca, #editmodelo').bind('change', function(){
		if ( $(this).val().length == 0 && $(this).val() == '' ) {
			alert('Hey! Não me parece uma boa ideia deixar este campo vazio agora!\nNão será possível finalizar esta alteração sem essa informação.\n\nMas se você ainda estiver em dúvida, tudo bem, pode tomar um café primeiro enquanto pensa melhor sobre essa informação, mas lembre-se de preencher este campo antes de pressionar aquele botão verdinho bem ali ao lado! ;)');
			return false;
		}
	});

	// Ano
	$('#editano').bind('change', function(){
		var anoOriginal = $(this).attr('data-orig');

		// Dìgitos
		if ( $(this).val().length != 4 && $(this).val().length != 0 ) {
			alert('Ditige o ano com 4 números!');
			$(this).val('');
		} else {

			// Anos
			var dt = new Date();
			var anoAtual = dt.getFullYear();
			var anoLimite = anoAtual+1;

			// Ano Vazio
			if ( $(this).val() == '' && $(this).val().length == 0 ){
				// Sem Info
				alert('Hey! Eu sei que muita gente não dá muita importância para o ano em que o carro foi fabricado, mas para nós, essa informação é muito importante!\n\nTalvez você não queira preencher agora, ou talvez tenha apagado sem querer, tudo bem, eu posso esperar você preencher novamente, mas você promete que não vai esquecer?');
					return false;

			} else {
				// Ano Max
				if ( $(this).val() > anoLimite ){
					alert(`O ano máximo permitido é ${anoLimite}!\n\nVocê sabia que em geral os carros são fabricados no máximo com o ano modelo referente ao ano subsequente?`);
					$(this).val(anoOriginal);
					return false;
				}

				// Ano Min
				if ( $(this).val() < 1885 ){
					alert(`O ano mínimo permitido é 1885!\n\nVocê sabia que o primeiro carro foi inventado em 1885?\nEu também não, eu vi no Google!`);
					$(this).val(anoOriginal);
					return false;
				}
			}
		}			
	});

	$('.btn-ok').on('click', function(){

		// Os campos estão preenchidos!?
		var campoPreenchido = 0;

		for ($i = 0; $i < $('.edit-campo').length; $i++){
			if ( $('.edit-campo').eq($i).val() != '' ){
				campoPreenchido++;
			}
		}

		if ( campoPreenchido == 0 ){
			alert('Hey! Lembra que eu te falei sobre deixar os campos sem informação?\nVocê está me testando? Ou foi sem querer?\n\nTudo bem, vamos fazer assim, quando estiver com tudo preenchido, você pode clicar novamente neste botãozinho verdinho bem aqui!');
				return false;
		} else if ( campoPreenchido == 1 ){
			alert('Hey! Alguns campos não foram preenchido!\nLembra que eu te falei que era importante preencher todos os campos?\n\nTudo bem, você parece ser legal, eu vou esperar você preencher, aí depois é só clicar novamente no botãozinho verdinho e ver a mágica acontecer!');
				return false;
		} else if ( campoPreenchido == 2 ){
			alert('Hey! Algum campo não foi preenchido!\nLembra que eu te falei que era importante preencher todos os campos?\n\nTudo bem, como foi um campo só, eu vou esperar você preencher, aí depois é só clicar novamente no botãozinho verdinho e ver a mágica acontecer!');
				return false;
		} else if ( campoPreenchido == 3 ) {

			// Campos Iguais ou Diferentes?!
			var iguais = 0;
			for ($c=0; $c < $('.edit-campo').length; $c++){
				if ( $('.edit-campo').eq($c).attr('data-orig') == $('.edit-campo').eq($c).val() ){
					iguais++;
				}
			}

			if ( iguais == 3 ){
				var confirmaIguais = window.confirm('Hey! Nenhum campo foi alterado!\nVocê ainda quer alterar este carro ou prefere cancelar?');
				if ( confirmaIguais == true ){
					return false;
				} else {
					$('#spa').fadeOut(100);
					$('#spa').load('carros/index.php');
					$('#spa').fadeIn(100);
					return false;
				}
			} else {

				var editCarroID = $('.id-campo').text().replace('#','');
				var editCarroMarca = $('.edit-campo').eq(0).val();
				var editCarroModelo = $('.edit-campo').eq(1).val();
				var editCarroAno = $('.edit-campo').eq(2).val();

				editaCarro(editCarroID, editCarroMarca, editCarroModelo, editCarroAno);
			}			
		}
	});
</script>