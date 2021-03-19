


/**************************
		 MÁSCARAS (MASKS)
***************************/

function validaCPF(strCPF) { // boolean
 strCPF = strCPF.toString().replace(/\D/g, "");
	let sum, remainder;
	sum = 0;
 if (strCPF == "00000000000") return false;
 for (i=1; i<=9; i++) sum = sum + parseInt(strCPF.substring(i-1, i)) * (11 - i);
 remainder = (sum * 10) % 11;
	if ((remainder == 10) || (remainder == 11))  remainder = 0;
	if (remainder != parseInt(strCPF.substring(9, 10)) ) return false;
 sum = 0;
	for (i = 1; i <= 10; i++) sum = sum + parseInt(strCPF.substring(i-1, i)) * (12 - i);
	remainder = (sum * 10) % 11;
	if ((remainder == 10) || (remainder == 11))  remainder = 0;
	if (remainder != parseInt(strCPF.substring(10, 11) )) return false;
	return true;
}

function titleCase(str) {
   var splitStr = str.toLowerCase().split(' ');
   for (var i = 0; i < splitStr.length; i++) {
       splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);
   }
   return splitStr.join(' ');
}

// $("input.numeric").keydown(function(event) {
// 	if (event.which < 48 || event.which > 57) event.preventDefault(); // Allow only 0-9
// });

 // QUANTIDADE

 if(!$("input.numeric").val()) $("input.numeric").val(0);

 $("input.numeric").keydown(function(e) {
		 let el = $(this);
		 let value = el.val();

		 switch(e.which) {
				 case UP:
					 el.val(parseInt(value)+1);
					 break;

				 case DOWN:
					 let valorSubtraido = parseInt(value)-1
					 if(valorSubtraido < 0) el.val(0);
					 else el.val(valorSubtraido);
					 break;

				 default: return;
		 }
		 e.preventDefault();
 });


 	// NUMBER AND DOT

	$('input.numberdot').keypress(function (evt) {
		var theEvent = evt || window.event;
		var key = theEvent.keyCode || theEvent.which;
		key = String.fromCharCode(key);
		if (key.length == 0) return;
		var regex = /^[0-9.\b]+$/;
		if (!regex.test(key)) {
		    theEvent.returnValue = false;
		    if (theEvent.preventDefault) theEvent.preventDefault();
		}
	 });

	 // ALFANUMERICO

	 $('input.alphanumeric').keypress(function (e) {
			let regex = new RegExp("^[A-Za-z0-9? ]+$");
			let str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
			if(regex.test(str)) return true;
			e.preventDefault();
			return false;
		});


 // PALAVRA ALFANUMERICA

 $('input.alphanumericword').keypress(function (e) {
		let regex = new RegExp("^[a-zA-Z0-9\s]+$");
		let str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		if(regex.test(str)) return true;
		e.preventDefault();
		return false;
	});

 // ALFABETICO

 $('input.alphabetic').keypress(function (e) {
		let regex = new RegExp(/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/);
		let str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		if(regex.test(str)) return true;
		e.preventDefault();
		return false;
	});

	$('input.alphabetic').focusout(function(event){
		$(this).val(titleCase($(this).val()));
	});

 // UPPERCASE ON KEYUP

 $('input.upper').keyup(function(event){
	 $(this).val($(this).val().toUpperCase());
 });

 $("input.phone").mask("(00) 0000-00009");
 $("input.phone_fix").mask("(00) 0000-0000");
 $("input.rg").mask("00.000.000-0");

 $("input.cpf").each(function(){
		$(this).mask("999.999.999-99");
	});


var options = {
    onKeyPress: function (cpf, ev, el, op) {
        var masks = ['000.000.000-000', '00.000.000/0000-00'];
        $('.cpfcnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
    }
}

$('.cpfcnpj').length > 11 ? $('.cpfcnpj').mask('00.000.000/0000-00', options) : $('.cpfcnpj').mask('000.000.000-00#', options);

$('.cpf').mask('000.000.000-00', {reverse: true});
$('.dinheiro').mask('#.##0,00', {reverse: true});
$('input.cnpj').mask('00.000.000/0000-00', {reverse: true});
$('input.cep').mask('00000-000');
$('input.date').mask('00/00/0000');
$("input.ddd").mask("99");
$('input.telefone').mask('(00) 0000-0000');
$('input.celular').mask('(00) 00000-0000');
$('input.time').mask('00:00:00');
$('input.date_time').mask('00/00/0000 00:00:00');
$('input.money').mask('000.000.000.000.000,00', {reverse: true});
$('input.money2').mask("#.##0,00", {reverse: true});
$('input.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', { translation: { 'Z': { pattern: /[0-9]/, optional: true } } });
$('input.ip_address').mask('099.099.099.099');
$('input.percent').mask('##0,00%', {reverse: true});
$('input.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
