<?php

/*
* USADO NA IMPORTACAO (ESCREVE_NAS_TABELAS) !!
* USADO NA IMPORTACAO (ESCREVE_NAS_TABELAS) !!
*/

/******************* GLOBAIS *******************/

// EXTRACAO

function extrai_numeros($string){
	$numeros = preg_replace('/[^0-9]/','',trim($string));
	return $numeros;
}

function extrai_espacoes_adicionais($string) {
	return preg_replace('!\s+!', ' ', $string);
}

// FORMATACOES

function formata_data($data) {
	$data = trim($data);
	if($data == '') return '0000-00-00';
	if(strlen($data) == 6) $data .= '01';
	$data = str_replace("/",'-',$data);
	return date('Y-m-d', strtotime($data));
}
function trimupper($string) {
	return strtoupper(trim($string));
}
function tirarAcentos($string){
		return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}

/******************* ESPECIFICAS *******************/

// FORMATACOES

function formata_valor($valor) {
	$valor = trim($valor);
	$valor =  preg_replace('/[^0-9.,]/','',$valor);
	$valor =  str_replace(',','',str_replace('.','',$valor));
	$valor = number_format($valor/100, 2, '.', '');
	if(strpos($valor,"-") || $valor =='' || intval($valor) == 0 ) $valor = "00.00";
	return $valor;
}

function formata_cpf($cpf) {
	$cpf = trim($cpf);
	$cpf = preg_replace('/[^0-9]/','',$cpf);
	if($cpf =="") $cpf = '0';
	while(strlen($cpf)<11) {
		 $cpf = "0".$cpf;
	}
	return $cpf;
}

function formata_sexo($sexo) {
	$sexo = trim($sexo);
	$sexo = strtoupper($sexo);
	if(strpos($sexo, 'MASC') !== false || $sexo == 'M') return 'M';
	if(strpos($sexo, 'FEM')  !== false || $sexo == 'F') return 'F';
	return '';
}

function formata_fone($fone) {
	$fone = intval(extrai_numeros($fone));
	$tamanho = strlen($fone);
	if($tamanho < 10 || $tamanho > 11) return '';
	return $fone;
}

// VALIDACOES

function valida_email($email) {
	$email = trim($email);
  return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '';
}

// CHECAGEM

function exists($field) { return (isset($field) && $field != ''); }

//convert data_hora pt
function data_pt_hora($value){
	$data_hora = date("d/m/Y H:m:s", strtotime($value));
	return $data_hora;
}

function decimal_dolar($value)
{
	$converted_value =  trim(str_replace("R$","", $value));
	$converted_value =  str_replace(",",".", $converted_value);
	return $converted_value;
}
function decimal_real($value)
{
	$converted_value =  str_replace("R$","", $value);
	$converted_value =  str_replace(".",",", $converted_value);
	return $converted_value;
}
function data_pt($value)
{
	$data = date('d/m/Y', strtotime($value));
	return $data;
}


function DiferencaEntreData($data_inicial,$data_final)
{
	$data_inicial = str_replace("/",'-',$data_inicial);
	$data_final 	= str_replace("/",'-',$data_final);
	$diferenca 		= strtotime($data_final) - strtotime($data_inicial);
	$dias 				= floor($diferenca / (60 * 60 * 24));
  return $dias;
}



function idade($value)
{
	if($value == 0 || $value == null || !isset($value)) return 'N/A';
	list($ano,$dia, $mes) = explode('-', $value);
	$hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
	$nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
	$idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
	return $idade;
}

function array2csv(array &$array, $file_name,$path) {
	 if (count($array) == 0) return null;
	 ob_start();
	 $file_name = "$file_name.csv";
	 $localfile   = fopen("$path/$file_name",'w');
	 fputcsv($localfile,   array_keys(reset($array)),',');

	 foreach ($array as $row) {
	  fputcsv($localfile,   $row,',');
	 }
	 if(fclose($localfile)){
		 ob_get_clean();
		 return true;
	 }
}

function DiasSemana($data){
	$diasemana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');
	$data = date($data);
	$diasemana_numero = date('w', strtotime($data));
	echo $diasemana[$diasemana_numero];
}

function Mascara($mask,$str){
    $str = str_replace(" ","",$str);
    for($i=0;$i<strlen($str);$i++){
        $mask[strpos($mask,"#")] = $str[$i];
    }
    return $mask;
}

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
function convertPuttoarray(){
	// Fetch content and determine boundary
	$raw_data = file_get_contents('php://input');
	$boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));

	// Fetch each part
	$parts = array_slice(explode($boundary, $raw_data), 1);
	$data = array();

	foreach ($parts as $part) {
			// If this is the last part, break
			if ($part == "--\r\n") break;

			// Separate content from headers
			$part = ltrim($part, "\r\n");
			list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);

			// Parse the headers list
			$raw_headers = explode("\r\n", $raw_headers);
			$headers = array();
			foreach ($raw_headers as $header) {
					list($name, $value) = explode(':', $header);
					$headers[strtolower($name)] = ltrim($value, ' ');
			}

			// Parse the Content-Disposition to get the field name, etc.
			if (isset($headers['content-disposition'])) {
					$filename = null;
					preg_match(
							'/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/',
							$headers['content-disposition'],
							$matches
					);
					list(, $type, $name) = $matches;
					isset($matches[4]) and $filename = $matches[4];

					// handle your fields here
					switch ($name) {
							// this is a file upload
							case 'userfile':
									 file_put_contents($filename, $body);
									 break;

							// default for all other files is to populate $data
							default:
									 $data[$name] = substr($body, 0, strlen($body) - 2);
									 break;
					}
			}

	}
	return $data;
}




?>
