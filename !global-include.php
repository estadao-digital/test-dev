<?php

//------------//------------//------------//------------//------------//------------//------------//
// Manipulador de Erros

define('ERRORHANLER_TRACE', true);

require('!global-errorHandler.php');

//------------//------------//------------//------------//------------//------------//------------//
// Tempo de Sala

require('lib/RenderTime.class.php');

$tempoSala = new RenderTime;
$tempoSala->start();

//------------//------------//------------//------------//------------//------------//------------//
// Definições

ini_set('display_errors', true);
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
setlocale(LC_MONETARY, 'pt_BR');
define('JSON_ENCODE_FLAGS', JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

//------------//------------//------------//------------//------------//------------//------------//
// Sessão

session_start();

//------------//------------//------------//------------//------------//------------//------------//
// Includes

require('lib/Ajax.class.php');

?>