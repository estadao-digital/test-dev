
$.ajaxSetup({
	dataType: 'json',
	type: 'GET',
	timeout: 20*1000 // 20 segundos
});

// Console polyfill

if(typeof console === undefined) {
  this.console = {
    log: function() {},
    info: function() {},
    error: function() {},
    warn: function() {}
  };
}

// jQuery hide() and show() supporting HTML5 hidden attribute

var originalHide = jQuery.fn.hide;
jQuery.fn.hide = function(duration, callback){
	if(!duration){
		originalHide.apply(this, arguments);
		this.attr('hidden', 'hidden');
	}
	else {
		var that = this;
		originalHide.apply(this, [duration, function(){
			that.attr('hidden', 'hidden');
			if(callback){
				callback.call(that);
			}
		}]);
	}
	return this;
};

var originalShow = jQuery.fn.show;
jQuery.fn.show = function(duration, callback){
	if(!duration){
		originalShow.apply(this, arguments);
		this.removeAttr('hidden');
	}
	else {
		var that = this;
		originalShow.apply(this, [duration, function(){
			that.removeAttr('hidden');
			if(callback){
				callback.call(that);
			}
		}]);
	}
	return this;
};

$.fn.hasAttr = function(name) {
   return this.attr(name) !== undefined;
};

$.fn.alterarLocationHash = function(novoHash) {

	if(this[0].hash != novoHash) this[0].hash = novoHash;
	else $(window).trigger('hashchange');

}

// Array.find polyfill

if(!Array.prototype.find) {
  Array.prototype.find = function(predicate) {
    if(this === null) {
      throw new TypeError('Array.prototype.find called on null or undefined');
    }
    if(typeof predicate !== 'function') {
      throw new TypeError('predicate must be a function');
    }
    var list = Object(this);
    var length = list.length >>> 0;
    var thisArg = arguments[1];
    var value;

    for (var i = 0; i < length; i++) {
      value = list[i];
      if (predicate.call(thisArg, value, i, list)) {
        return value;
      }
    }
    return undefined;
  };
}

var carros = {

	obj: {},

	Preparar: function() {

		this.lista.Preparar();
		this.formulario.Preparar();
		this.excluir.Preparar();
		this.lista.Iniciar();

	}, // carros.Preparar

	Iniciar: function()  {

		// Define os eventos pela alteração location.hash

		$(window).on('hashchange', this, function(event) {

			console.log('hashchange', location.hash);

			var id, acao, editar, excluir;

			if(location.hash == '#incluir') {

				acao = 'formulario';
				id = 0;

			}else if(editar = (new RegExp('#editar/([0-9]+)')).exec(location.hash)) {

				acao = 'formulario';
				id = editar[1];

			}else if(excluir = (new RegExp('#excluir/([0-9]+)')).exec(location.hash)) {

				acao = 'excluir';
				id = excluir[1];

			}else{

				console.error('Ação '+location.hash+' não esperada');
				return false;
			}

			// Abre o modal correspondente à ação e/ou dispara o evento de exibição

			console.log('acao', acao, 'id', id);

			if(event.data[acao].obj.modal.hasClass('show')) {

				event.data[acao].obj.modal.trigger('shown.bs.modal', id);

			}else{

				event.data[acao].obj.modal.modal('show', id);

			}

		}).trigger('hashchange');

	}, // carros.iniciar

	enumeracao: {

		enumerador: {},

		carregado: false,

		Iniciar: function(alwaysFuncion, failFunction) {

			$.ajax(location.pathname+'api/carros/enumeracao', {
				context: this
			})
			.done(function(resposta) {

				if(resposta && resposta.status && resposta.status == 'sucesso') {

					this.enumerador = resposta.registro;
					this.carregado = true;

				}else if(resposta && resposta.status && resposta.status == 'error') {

					(failFunction||function(){}).call(this, null, resposta.mensagem);

				}else{

					(failFunction||function(){}).call(this, null, 'Resposta não esperada');

				}

			})
			.fail(failFunction||function(){})
			.always(alwaysFuncion||function(){});

		}, // carros.enumeracao.Iniciar

		obterPeloId: function(enumerador, id) {

			if(this.enumerador[enumerador] === undefined) throw new TypeError('Enumerador '+enumerador+' não existe');
			return this.enumerador[enumerador].find(function(i) { return i.id == id; })

		}, // carros.enumeracao.Falhou

		obterEnumerador: function(enumerador) {

			if(this.enumerador[enumerador] === undefined) throw new TypeError('Enumerador '+enumerador+' não existe');
			return this.enumerador[enumerador];

		}

	}, // carros.enumeracao

	lista: {

		obj: {}, // carros.lista.obj

		registros: [], // carros.lista.registros

		Preparar: function() {

			this.obj.carregando = $('#carrosCarregando');
			this.obj.mensagemErro = $('#carrosMensagemErro');
			this.obj.lista = $('#carrosLista');
			this.obj.listaRegistrosArea = this.obj.lista.find('tbody');
			this.obj.listaRegistrosArea.data('totalRegistros', 0);
			this.obj.listaRegistroMascara = this.obj.listaRegistrosArea.find('tr:eq(0)').detach();
			this.obj.listaRegistrosVazio = this.obj.listaRegistrosArea.find('tr:eq(0)').detach();
			this.obj.incluirBtn = $('#carroIncluirBtn');
			this.obj.atualizarBtn = $('#carroAtualizarBtn');

			// Ao clicar no botão incluir carro, trocar hash no endereço para #incluir

			this.obj.incluirBtn.on('click', function() {

				$(location).alterarLocationHash('#incluir');

			});

			this.obj.atualizarBtn.on('click', this, function(event) {

				event.data.Consultar();

			});

		}, // carros.lista.Preparar

		Iniciar: function() {

			this.Consultar();

		}, // carros.lista.Iniciar

		Consultar: function() {

			this.obj.carregando.show();
			this.obj.mensagemErro.hide();
			this.obj.lista.hide();

			$.ajax(location.pathname+'api/carros', {
				context: this
			})
			.done(this.Respondeu)
			.fail(this.Falhou);

		}, // carros.lista.Consultar

		Respondeu: function(resposta) {

			if(resposta && resposta.status && resposta.status == 'sucesso') {

				this.registros = resposta.registros;
				this.Atualizar();

			}else if(resposta && resposta.status && resposta.status == 'erro') {

				this.Falhou(null, resposta.mensagem);

			}else{

				this.Falhou(null, 'Resposta não esperada');

			}

		}, // carros.lista.Respondeu

		Falhou: function(xhr, mensagem) {

			this.obj.carregando.hide();
			this.obj.lista.hide();
			this.obj.mensagemErro.show().find('div > div').text(mensagem);

		}, // carros.lista.Falhou

		Atualizar: function() {

			this.obj.carregando.hide();
			this.obj.mensagemErro.hide();
			this.obj.listaRegistrosArea.empty();

			var i, registro, linhas = [], linha, colunas;

			this.obj.listaRegistrosArea.data('totalRegistros', this.registros.length);

			if(this.registros.length == 0) {

				linha = this.obj.listaRegistrosVazio.clone();
				this.obj.listaRegistrosArea.append(linha);
				this.obj.lista.show();
				return true;

			}

			for(i = 0; i < this.registros.length; i++) {

				registro = this.registros[i];

				linha = this.obj.listaRegistroMascara.clone();
				linha.data('recid', registro.id);
				colunas = linha.find('td');
				colunas.eq(0).text(registro.id);
				colunas.eq(1).text(registro.marca);
				colunas.eq(2).text(registro.modelo);
				colunas.eq(3).text(registro.ano);
				colunas.eq(4).find('button.btn-secondary:eq(0)').on('click', registro.id, function(event) {
					$(location).alterarLocationHash('#editar/'+event.data);
				})
				colunas.eq(4).find('a.dropdown-item').on('click', registro.id, function(event) {
					$(location).alterarLocationHash($(this).attr('href')+'/'+event.data);
					return false;
				});

				linhas.push(linha);

			}

			this.obj.listaRegistrosArea.append(linhas);
			this.obj.lista.show();

		},

		registro: { // Atualização instantânea da lista, para não consumir outra chamada à api de listagem

			Incluir: function(registro) {

				linha = carros.lista.obj.listaRegistroMascara.clone();
				linha.data('recid', registro.id).addClass('table-success').hide();
				colunas = linha.find('td');
				colunas.eq(0).text(registro.id);
				colunas.eq(1).text(registro.marca);
				colunas.eq(2).text(registro.modelo);
				colunas.eq(3).text(registro.ano);
				colunas.eq(4).find('button.btn-secondary:eq(0)').on('click', registro.id, function(event) {
					$(location).alterarLocationHash('#editar/'+event.data);
				})
				colunas.eq(4).find('a.dropdown-item').on('click', registro.id, function(event) {
					$(location).alterarLocationHash($(this).attr('href')+'/'+event.data);
					return false;
				});

				if(carros.lista.obj.listaRegistrosArea.data('totalRegistros') == 0) {
					carros.lista.obj.listaRegistrosArea.empty();
					carros.lista.obj.listaRegistrosArea.data('totalRegistros', 1);
				}

				carros.lista.obj.listaRegistrosArea.prepend(linha);

				linha.removeAttr('hidden').fadeIn('slow');

			}, // carros.lista.registro.Excluir

			Atualizar: function(registro) {

				var linha = carros.lista.obj.listaRegistrosArea
				.find('tr')
				.filter(function() {
					return $(this).data('recid') == ''+registro.id
				});

				var colunas = linha.find('td');
				colunas.eq(1).text(registro.marca);
				colunas.eq(2).text(registro.modelo);
				colunas.eq(3).text(registro.ano);

			}, // carros.lista.registro.Atualizar

			Excluir: function(id) {

				//carros.lista.registros.find()

				carros.lista.obj.listaRegistrosArea
				.find('tr')
				.filter(function() {
					return $(this).data('recid') == ''+id
				})
				.addClass('table-danger')
				.fadeOut('slow', function() {

					$(this).remove();

					// Colocar mensagem de vazio caso todas as linhas tenham sido apacadas

					if(carros.lista.obj.listaRegistrosArea.find('tr').length == 0) {
						carros.lista.obj.listaRegistrosArea
						.data('totalRegistros', 0)
						.append(carros.lista.obj.listaRegistrosVazio.clone());
					}

				});

			} // carros.lista.registro.Excluir

		} // carros.lista.registro

	}, // carros.lista

	formulario: {

		id: null, // carros.formulario.id

		obj: {}, // carros.formulario.obj

		flag: {
			preencheuCamposEnumerados: false
		}, // carros.formulario.flag

		registro: null, // carros.formulario.registro

		Preparar: function() {

			this.obj.modal = $('#formularioModal');
			this.obj.modalTitulo = this.obj.modal.find('h5.modal-title');
			this.obj.modalCorpo = this.obj.modal.find('div.modal-body');
			this.obj.modalRodapeh = this.obj.modal.find('div.modal-footer');
			this.obj.carregando = this.obj.modalCorpo.find('div.carregando');
			this.obj.mensagemErro = this.obj.modalCorpo.find('div.mensagemErro');
			this.obj.alertaDanger = this.obj.modalCorpo.find('div.alert-danger');
			this.obj.form = this.obj.modalCorpo.find('form');
			this.obj.salvarBtn = this.obj.modalRodapeh.find('button.btn-primary');

			this.obj.modal.on('shown.bs.modal', this, this.aoAbrir);
			this.obj.modal.on('hidden.bs.modal', this, this.aoFechar);
			this.obj.salvarBtn.on('click', this, this.Salvar);

		}, // carros.formulario.Preparar

		aoAbrir: function(event) {

			event.data.id = parseInt(event.relatedTarget)||0;

			if(carros.enumeracao.carregado == false) {

				var e = event;
				carros.enumeracao.Iniciar(
					function() {
						carros.formulario.preencherCamposEnumerados();
						carros.formulario.aoAbrir(e);
					},
					this.Falhou
				);

			}else{

				if(event.data.id > 0) {
					event.data.Consultar();
				}else{
					event.data.Preencher();
				}

			}

		}, // carros.formulario.aoAbrir

		aoFechar: function(event) {

			$(location).alterarLocationHash('#listar');
			event.data.Reiniciar();

		}, // carros.formulario.aoFechar

		Consultar: function() {

			$.ajax(location.pathname+'api/carros'+(this.id ? '/'+this.id : ''), {
				context: this,
				type: 'GET'
			})
			.done(function(resposta) {

				if(resposta && resposta.status && resposta.status == 'sucesso') {

					this.registro = resposta.registro;
					this.Preencher();

				}else if(resposta && resposta.status && resposta.status == 'erro') {

					this.Falhou(null, resposta.mensagem);

				}else{

					this.Falhou(null, 'Resposta não esperada');

				}

			})
			.fail(this.Falhou);

		}, // carros.formulario.Consultar

		Preencher: function() {

			var campos = this.obj.form.find(':input');

			if(this.id) {

				this.obj.modalTitulo.text('Editando carro '+this.id);
				this.obj.salvarBtn.text('Alterar');

				var i, name, campo;

				for(var i = 0; i < campos.length; i++) {

					campo = campos.eq(i);
					name = campo.attr('name');
					if(this.registro[name] !== undefined) {
						campo.val(this.registro[name]);
					}else{
						console.error('Não existe um registro correspondente ao campo '+name);
					}

				}

				campos.filter('[name=id]').attr('readonly','readonly').addClass('form-control-plaintext');

			}else{

				this.obj.modalTitulo.text('Incluir novo carro');
				this.obj.salvarBtn.text('Incluir');

				setTimeout(function() {
					carros.formulario.obj.form.find('input[name=id]').focus();
				}, 500);

			}

			this.obj.carregando.hide();
			this.obj.modalRodapeh.show();
			this.obj.form.show();

		}, // carros.formulario.Preencher

		Validar: function() {

			var valido = true;

			this.obj.form.find(':input[required]').each(function() {

				var obj = $(this);
				var valor = obj.val();
				if(!valor) {
					obj.addClass('is-invalid').next().show();
					valido = false;
				}else{
					obj.removeClass('is-invalid').next().hide();
				}

			});

			return valido;

		}, // carros.formulario.Validar

		Salvar: function(event) {

			event.data.obj.alertaDanger.hide();

			if(event.data.Validar() == false) return false;

			var params = {
				context: event.data,
				type: event.data.id ? 'POST' : 'PUT',
				data: event.data.obj.form.find(':input').serializeObject()
			}

			$.ajax(location.pathname+'api/carros'+(event.data.id ? '/'+event.data.id : ''), params)
			.done(event.data.Respondeu)
			.fail(event.data.Falhou);

		}, // carros.formulario.Salvar

		Respondeu: function(resposta) {

			if(resposta && resposta.status && resposta.status == 'sucesso') {

				var atualizarLista = this.obj.form.find(':input').serializeObject();
				atualizarLista.marca = this.obj.form.find('select[name=marca] option:selected').text();
				atualizarLista.operacao = this.id ? 'Atualizar' : 'Incluir';

				this.obj.modal.one('hidden.bs.modal', atualizarLista, function(event) {

					carros.lista.registro[event.data.operacao](event.data);

				});

				this.obj.modal.modal('hide');

			}else if(resposta && resposta.status && resposta.status == 'erro') {

				this.obj.alertaDanger.show().fadeIn().find('span:eq(0)').text(resposta.mensagem);

			}else{

				this.obj.alertaDanger.show().fadeIn().find('span:eq(0)').text('Resposta não esperada');

			}

		}, // carros.formulario.Respondeu

		Falhou: function(xhr, mensagem) {

			this.obj.carregando.hide();
			this.obj.form.hide();
			this.obj.alertaDanger.hide();
			this.obj.mensagemErro.show().find('div > div').text(mensagem);
			this.obj.modalRodapeh.hide();
			throw new Error(mensagem);

		}, // carros.formulario.Falhou

		preencherCamposEnumerados: function() {

			try {

				var marcas = carros.enumeracao.obterEnumerador('marcas');
				var i, options = [];

				options.push($('<option/>').val('').text('Selecione ...'));
				for(i = 0; i < marcas.length; i++) {
					options.push($('<option/>').val(marcas[i].id).text(marcas[i].text));
				}
				this.obj.form.find(':input[name=marca]').append(options);

				this.flag.preencheuCamposEnumerados = true;

			}catch(e) {

				this.Falhou(null, e.message);

			}

		}, // carros.formulario.preencherCamposEnumerados

		Reiniciar: function() {

			this.obj.carregando.show();
			this.obj.mensagemErro.hide();
			this.obj.alertaDanger.hide();
			this.obj.form.hide();
			this.obj.modalRodapeh.hide();
			this.obj.form.find(':input[name=id]').removeAttr('readonly').removeClass('form-control-plaintext');
			this.obj.form[0].reset();
			this.obj.form.find(':input').each(function() {

				$(this).removeClass('is-invalid').next().hide();

			});

		} // carros.formulario.Reiniciar

	}, // carros.formulario

	excluir: {

		id: null, // carros.formulario.id

		obj: {}, // carros.formulario.obj

		Preparar: function() {

			this.obj.modal = $('#excluirModal');
			this.obj.modalTitulo = this.obj.modal.find('h5.modal-title');
			this.obj.modalCorpo = this.obj.modal.find('div.modal-body');
			this.obj.modalRodapeh = this.obj.modal.find('div.modal-footer');
			this.obj.carregando = this.obj.modalCorpo.find('div.carregando');
			this.obj.alertaDanger = this.obj.modalCorpo.find('div.alert-danger');
			this.obj.form = this.obj.modalCorpo.find('form');
			this.obj.salvarBtn = this.obj.modalRodapeh.find('button.btn-danger');

			this.obj.modal.on('show.bs.modal', this, this.aoAbrir);
			this.obj.modal.on('hidden.bs.modal', this, this.aoFechar);
			this.obj.salvarBtn.on('click', this, this.Salvar);

		}, // carros.excluir.Preparar

		aoAbrir: function(event) {

			event.data.id = parseInt(event.relatedTarget)
			if(isNaN(event.data.id)) throw new Error('Necessário informar o id a ser excluído');
			event.data.Preencher();

		}, // carros.excluir.aoAbrir

		aoFechar: function(event) {

			$(location).alterarLocationHash('#listar');

		}, // carros.excluir.aoFechar

		Preencher: function() {

			this.obj.modalCorpo.find('span').text(this.id);

		}, // carros.excluir.Preencher

		Salvar: function(event) {

			event.data.obj.alertaDanger.hide();

			$.ajax(location.pathname+'api/carros/'+event.data.id, {
				context: event.data,
				type: 'DELETE'
			})
			.done(event.data.Respondeu)
			.fail(event.data.Falhou);

		}, // carros.excluir.Salvar

		Respondeu: function(resposta) {

			if(resposta && resposta.status && resposta.status == 'sucesso') {

				this.obj.modal.one('hidden.bs.modal', this.id, function(event) {

					carros.lista.registro.Excluir(event.data);

				});

				this.obj.modal.modal('hide');

			}else if(resposta && resposta.status && resposta.status == 'erro') {

				this.Falhou(null, resposta.mensagem);

			}else{

				this.Falhou(null, 'Resposta não esperada');

			}

		}, // carros.excluir.Respondeu

		Falhou: function(xhr, mensagem) {

			this.obj.alertaDanger.show().fadeIn().find('span:eq(0)').text(mensagem);

		} // carros.excluir.Falhou

	} // carros.excluir

} // carros

$(document).ready(function() {

	carros.Preparar();
	carros.Iniciar();

});
