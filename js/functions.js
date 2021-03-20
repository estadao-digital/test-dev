// FUNÇÕES DE TRATAMENTO DE ARRAY E OBJETOS

function wait(ms){
   var start = new Date().getTime();
   var end = start;
   while(end < start + ms) {
     end = new Date().getTime();
  }
}

function formataValor(string) {
  return formatter.format(string).replace('R$','').replace('.','').trim();
}

function onlyUnique(value, index, self) {
  return self.indexOf(value) === index;
}

function jsonArrayToArray(arrayOfJsons) {
  arrayOfJsons = JSON.parse(arrayOfJsons);
  let array = [];
  for (let json of arrayOfJsons) {
    array.push(JSON.parse(json));
  }
  return array;
}

function appendObjTo(thatArray, newObj) {
  const frozenObj = Object.freeze(newObj);
  return Object.freeze(thatArray.concat(frozenObj));
}

function jsonToArrayObject(array) {
  newArray = [];
  for (var i = 0; i < array.length; i++) {
    newArray.push(array[i]);
  }
  return newArray;
}

const findByField = (field) => (value, array) =>
  array.find(obj => obj[field] === value)

// VALIDACAO (CLASSE CSS)

function isMarkedClass(booleanValid) {
	var marked_class = "";
	if(booleanValid == 1 || booleanValid == "1" || booleanValid == true) marked_class = "mdi mdi-checkbox-marked-circle";
 	if(booleanValid == 0 || booleanValid == "0" || booleanValid == false) marked_class = "mdi mdi-checkbox-marked-circle-outline";
	return marked_class;
}

// FORMATACAO

var formatter = new Intl.NumberFormat('pt-BR', {
	style: 'currency',
	currency: 'BRL',
	minimumFractionDigits: 2
});

Number.prototype.toHHMMSS = function () {
  var seconds = Math.floor(this),
  hours = Math.floor(seconds / 3600);
  seconds -= hours*3600;
  var minutes = Math.floor(seconds / 60);
  seconds -= minutes*60;

  if (hours   < 10) {hours   = "0"+hours;}
  if (minutes < 10) {minutes = "0"+minutes;}
  if (seconds < 10) {seconds = "0"+seconds;}
  return hours+':'+minutes+':'+seconds;
}

const sleep = (milliseconds) => { return new Promise(resolve => setTimeout(resolve, milliseconds)) }

function firstAndLastWord(string) {
  let words = string.split(' ');
  if(words.length == 1) return words[0];
  return `${words[0]} ${words[words.length-1]}`;
}

function getDayOfTheWeek() {
  let weeks = ["Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado"];
  let today = new Date();
  return weeks[today.getDay()];
}

function getCurrentMonth() {
  let months = ['Janeiro', 'Fevereiro', 'Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
  let today = new Date();
  return months[today.getMonth()];
}

// SWEET ALERT

function faltou(campo){
  sweetAlert("Cadastro",`Faltou informar ${campo}!`, "warning");
}



function validaCpf(cpf){
    let exp = /\.|\-/g;

     cpf = cpf.replace(exp,'').toString();
    if(cpf.length == 11 ){
      let v = [];
      //Calcula o primeiro dígito de verificação.
      v[0] = 1 * cpf[0] + 2 * cpf[1] + 3 * cpf[2];
      v[0] += 4 * cpf[3] + 5 * cpf[4] + 6 * cpf[5];
      v[0] += 7 * cpf[6] + 8 * cpf[7] + 9 * cpf[8];
      v[0] = v[0] % 11;
      v[0] = v[0] % 10;
      //Calcula o segundo dígito de verificação.
      v[1] = 1 * cpf[1] + 2 * cpf[2] + 3 * cpf[3];
      v[1] += 4 * cpf[4] + 5 * cpf[5] + 6 * cpf[6];
      v[1] += 7 * cpf[7] + 8 * cpf[8] + 9 * v[0];
      v[1] = v[1] % 11;
      v[1] = v[1] % 10;
        //Retorna Verdadeiro se os dígitos de verificação são os esperados.

      if ((v[0] != cpf[9]) || (v[1] != cpf[10])) return false
      else if (cpf[0] == cpf[1] && cpf[1] == cpf[2] && cpf[2] == cpf[3] && cpf[3] == cpf[4] && cpf[4] == cpf[5] && cpf[5] == cpf[6] && cpf[6] == cpf[7] && cpf[7] == cpf[8] && cpf[8] == cpf[9] && cpf[9] == cpf[10]){
        return false
      }
    	else return true
    }
    else return false

}

function validaCnpj(cnpj) {
  cnpj = cnpj.replace(/[^\d]+/g, '');
  if (cnpj == '') return false;
  if (cnpj.length != 14)
      return false;
  if (cnpj == "00000000000000" ||
      cnpj == "11111111111111" ||
      cnpj == "22222222222222" ||
      cnpj == "33333333333333" ||
      cnpj == "44444444444444" ||
      cnpj == "55555555555555" ||
      cnpj == "66666666666666" ||
      cnpj == "77777777777777" ||
      cnpj == "88888888888888" ||
      cnpj == "99999999999999")
      return false;
  tamanho = cnpj.length - 2
  numeros = cnpj.substring(0, tamanho);
  digitos = cnpj.substring(tamanho);
  soma = 0;
  pos = tamanho - 7;
  for (i = tamanho; i >= 1; i--) {
    soma += numeros.charAt(tamanho - i) * pos--;
    if (pos < 2)
        pos = 9;
  }
  resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
  if (resultado != digitos.charAt(0)) return false;
  tamanho = tamanho + 1;
  numeros = cnpj.substring(0, tamanho);
  soma = 0;
  pos = tamanho - 7;
  for (i = tamanho; i >= 1; i--) {
    soma += numeros.charAt(tamanho - i) * pos--;
    if (pos < 2)
        pos = 9;
  }
  resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
  if (resultado != digitos.charAt(1))
      return false;
  return true;
}



  function extraiNumeros(string){
    string =  string.replace(/([^\d])+/gim, '')
    return string
  }
