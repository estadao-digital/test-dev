<?php
	require_once '../Carro.class.php';
?><article class="lista-carros container"><ul class="lista-cabecalho"><li> <span>ID</span> <span>MARCA</span> <span>MODELO</span> <span>ANO</span> <span>AÇÕES</span></li></ul><ul class="lista-conteudo"> <?php foreach ($dataJSON -> carrosJSON as $carro) : ?><li class="lncarro" carro-id="<?php echo $carro->ID; ?>"> <span>#<?php echo $carro->ID; ?></span> <span><?php echo $carro->Marca; ?></span> <span><?php echo $carro->Modelo; ?></span> <span><?php echo $carro->Ano; ?></span><span><div class="btn-action btn-edit" action="edit"></div><div class="btn-action btn-del" action="del"></div></span></li> <?php endforeach; ?></ul></article><div class="btn-cadastrar container"> <span class="abrir">CADASTRAR NOVO CARRO</span></div><article class="cadastrar-carros container"><p>PREENCHA OS DADOS DO CARRO:</p><form action="" method="POST" autocomplete="off"><div class="mostra-marca"> <img src="img/marcas/api-carros-marcas-nenhuma.jpg" alt="Nenhum Logo"></div><div class="mostra-campos"> <label for="cadmarca">MARCA:</label> <select name="cadmarca" id="cadmarca" class="cad-campo"><option value="">Selecione a Marca</option> <?php foreach ($dataMJSON -> marcasJSON as $marca) : ?><option value="<?php echo $marca->Marca; ?>" marca-id="<?php echo $marca->ID; ?>"><?php echo $marca->Marca; ?></option> <?php endforeach; ?></select> <label for="cadmodelo">MODELO:</label> <input type="text" name="cadmodelo" id="cadmodelo" class="cad-campo"> <label for="cadano">ANO:</label> <input type="number" min="1885" max="2020" maxlength="4" name="cadano" id="cadano" class="cad-campo"><div class="btn-form"> <span class="btn-cad">CADASTRAR</span> <span class="btn-clean">LIMPAR CAMPOS</span></div></div></form></article><script>
	function cadastraCarro(marca, modelo, ano){
		var pageID = 'carros/0';

		// Confirmar cadastrar
		var cadastraPergunta = window.confirm(`Você quer mesmo cadastrar este carro?\n\nMarca: ${marca}\nModelo: ${modelo}\nAno: ${ano}`);

		// Cadastrar
		if ( cadastraPergunta == true ){
			$.ajax({
				method: "POST",
				url: pageID,
				data: { 
					action: 'cad',
					marca: marca,
					modelo: modelo,
					ano: ano
				}
			}).done(function( msg ) {
				
				if (msg == 'cadastrado'){
					// Carrega Carros
					$('#spa').fadeOut(200);
					$('#spa').load('carros/index.php');
					$('#spa').fadeIn(200);
				}
			});
		}

	}
	function apagaCarro(id, marca, modelo, ano){
		var pageID = 'carros/'+id;

		// Confirmar apagar
		var apagaPergunta = window.confirm(`Você quer mesmo apagar este carro?\n\nID: ${id}\nMarca: ${marca}\nModelo: ${modelo}\nAno: ${ano}`);

		// Apagar
		if ( apagaPergunta == true ){
			$.ajax({
				method: "POST",
				url: pageID,
				data: { action: 'del' }
			}).done(function( msg ) {
				
				if (msg == 'apagado'){
					// Carrega Carros
					$('#spa').load('carros/index.php');
				}
			});
		} else {
			return false;
		}
	}

	// Click Action
	$('.btn-action').on('click', function(){
		var carroID = $(this).parents('li').find('span').eq(0).text().replace('#','');
		var carroMarca = $(this).parents('li').find('span').eq(1).text();
		var carroModelo = $(this).parents('li').find('span').eq(2).text();
		var carroAno = $(this).parents('li').find('span').eq(3).text();
		var actionBTN = $(this).attr('action');
		
		switch (actionBTN){
			case 'edit':

				$(this).parents('li').toggleClass('lncarro lncarro-edit');
				$('.lncarro').addClass('list-blur');
				$('.lncarro-edit').html('');
				$('.lncarro-edit').load('carros/edit.php', {
					getid: carroID,
					getmarca: carroMarca,
					getmodelo: carroModelo,
					getano: carroAno
				});
			    break;

			case 'del':
				apagaCarro(carroID, carroMarca, carroModelo, carroAno);
				break;
		}
	});

	// Click Editar Info

	// Click Cadastrar Novo Carro
	$('.btn-cadastrar').on('click', function(){

		// Mudar Botão & Abrir/Fechar Cadastro
		var mudaBotao = $(this).find('span');
		mudaBotao.toggleClass('abrir fechar');

		if ( mudaBotao.hasClass('abrir') ){
			mudaBotao.html('CADASTRAR NOVO CARRO');
			$('.cadastrar-carros').fadeOut(200);
		} else {
			mudaBotao.html('FECHAR CADASTRO');
			$('.cadastrar-carros').fadeIn(200);
		}
	});

	// Seleciona Marca
	$('#cadmarca').on('change', function(){
		var marcaEscolhida = $(this).val();
		var marcaEdit = marcaEscolhida.toLowerCase();
		var marcaUrl = `img/marcas/api-carros-marcas-${marcaEdit}.jpg`;
		var altEdit = `Logo da ${marcaEscolhida}`;

		if ( marcaEscolhida == '' ){
			$('.mostra-marca').find('img').attr('src', 'img/marcas/api-carros-marcas-nenhuma.jpg');
			$('.mostra-marca').find('img').attr('alt', 'Nenhum Logo');
		} else {
			$('.mostra-marca').find('img').attr('src', marcaUrl);
			$('.mostra-marca').find('img').attr('alt', altEdit);
		}
	});

	// Ano
	$('#cadano').bind('change', function(){
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
				alert('Hey! Eu sei que muita gente não dá muita importância para o ano em que o carro foi fabricado, mas aqui ela é importante!\n\nTalvez você não queira preencher agora, tudo bem, eu posso esperar, mas você promete que não vai esquecer?');
				return false;

			} else {

				// Ano Max
				if ( $(this).val() > anoLimite ){
					alert(`O ano máximo permitido é ${anoLimite}!\n\nVocê sabia que em geral os carros são fabricados no máximo com o ano modelo referente ao ano subsequente?`);
					$(this).val('');
					return false;
				}

				// Ano Min
				if ( $(this).val() < 1885 ){
					alert(`O ano mínimo permitido é 1885!\n\nVocê sabia que o primeiro carro foi inventado em 1885?\nEu também não, eu vi no Google!`);
					$(this).val('');
					return false;
				}
			}
		}			
	});

	// Limpar Campos de Cadastro
	$('.btn-clean').on('click', function(){

		var campoPreenchido = 0;
		for ($i = 0; $i < $('.cad-campo').length; $i++){
			if ( $('.cad-campo').eq($i).val() != '' ){
				campoPreenchido++;
			}
		}

		if ( campoPreenchido != 0 ) {
			var limpaConfirma = window.confirm('Você deseja mesmo limpar os campos?');
			if ( limpaConfirma == true ) {
				$('.cad-campo').val('');

				$('.mostra-marca').find('img').attr('src', 'img/marcas/api-carros-marcas-nenhuma.jpg');
				$('.mostra-marca').find('img').attr('alt', 'Nenhum Logo');
			}
		} else {
			alert('Nenhum campo foi preenchido ainda!');
		}
	});

	// Cadastrar Definitivamente
	$('.btn-cad').on('click', function(){
		var campoPreenchido = 0;
		for ($i = 0; $i < $('.cad-campo').length; $i++){
			if ( $('.cad-campo').eq($i).val() != '' ){
				campoPreenchido++;
			}
		}

		if ( campoPreenchido == 0 ) {
			alert('Nenhum campo foi preenchido ainda!');
			return false;
		} else if ( campoPreenchido > 0 && campoPreenchido < 3 ) {
			alert('Nem todos os campos foram preenchidos ainda!');
			return false;
		} else if ( campoPreenchido == 3 ) {

			var carroMarca = $('#cadmarca').val();
			var carroModelo = $('#cadmodelo').val();
			var carroAno = $('#cadano').val();

			cadastraCarro(carroMarca, carroModelo, carroAno);

		}
	});

</script>