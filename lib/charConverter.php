<?php

/*
 *  Copyright (C) 2016 vagner    
 * 
 *    This file is part of Kolibri.
 *
 *    Kolibri is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    Kolibri is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with Kolibri.  If not, see <http://www.gnu.org/licenses/>. 
 */

function charConverter($buffer){

	// Fun��o usada no buffer para reparo de caracteres

	$buffer = str_replace("Á", "&Aacute;", $buffer);
	$buffer = str_replace("á", "&aacute;", $buffer);
	$buffer = str_replace("Â", "&Acirc;", $buffer);
	$buffer = str_replace("â", "&acirc;", $buffer);
	$buffer = str_replace("À", "&Agrave;", $buffer);
	$buffer = str_replace("à", "&agrave;", $buffer);
	$buffer = str_replace("Ã", "&Atilde;", $buffer);
	$buffer = str_replace("ã", "&atilde;", $buffer);
	$buffer = str_replace("É", "&Eacute;", $buffer);
	$buffer = str_replace("é", "&eacute;", $buffer);
	$buffer = str_replace("Ê", "&Ecirc;", $buffer);
	$buffer = str_replace("ê", "&ecirc;", $buffer);
	$buffer = str_replace("È", "&Egrave;", $buffer);
	$buffer = str_replace("è", "&egrave;", $buffer);
	$buffer = str_replace("Í", "&Iacute;", $buffer);
	$buffer = str_replace("í", "&iacute;", $buffer);
	$buffer = str_replace("Î", "&Icirc;", $buffer);
	$buffer = str_replace("î", "&icirc;", $buffer);
	$buffer = str_replace("Ì", "&Igrave;", $buffer);
	$buffer = str_replace("ì", "&igrave;", $buffer);
	$buffer = str_replace("Ó", "&Oacute;", $buffer);
	$buffer = str_replace("ó", "&oacute;", $buffer);
	$buffer = str_replace("Ô", "&Ocirc;", $buffer);
	$buffer = str_replace("ô", "&ocirc;", $buffer);
	$buffer = str_replace("Ò", "&Ograve;", $buffer);
	$buffer = str_replace("ò", "&ograve;", $buffer);
	$buffer = str_replace("Õ", "&Otilde;", $buffer);
	$buffer = str_replace("õ", "&otilde;", $buffer);
	$buffer = str_replace("Ú", "&Uacute;", $buffer);
	$buffer = str_replace("ú", "&uacute;", $buffer);
	$buffer = str_replace("Û", "&Ucirc;", $buffer);
	$buffer = str_replace("û", "&ucirc;", $buffer);
	$buffer = str_replace("Ù", "&Ugrave;", $buffer);
	$buffer = str_replace("ù", "&ugrave;", $buffer);
	$buffer = str_replace("ç", "&ccedil;", $buffer);
	$buffer = str_replace("Ç", "&Ccedil;", $buffer);
	$buffer = str_replace("º", "&ordm;", $buffer);
	$buffer = str_replace("�", "&Aacute;", $buffer);
	$buffer = str_replace("�", "&aacute;", $buffer);
	$buffer = str_replace("�", "&Acirc;", $buffer);
	$buffer = str_replace("�", "&acirc;", $buffer);
	$buffer = str_replace("�", "&Agrave;", $buffer);
	$buffer = str_replace("�", "&agrave;", $buffer);
	$buffer = str_replace("�", "&Atilde;", $buffer);
	$buffer = str_replace("�", "&atilde;", $buffer);
	$buffer = str_replace("�", "&Eacute;", $buffer);
	$buffer = str_replace("�", "&eacute;", $buffer);
	$buffer = str_replace("�", "&Ecirc;", $buffer);
	$buffer = str_replace("�", "&ecirc;", $buffer);
	$buffer = str_replace("�", "&Egrave;", $buffer);
	$buffer = str_replace("�", "&egrave;", $buffer);
	$buffer = str_replace("�", "&Iacute;", $buffer);
	$buffer = str_replace("�", "&iacute;", $buffer);
	$buffer = str_replace("�", "&Icirc;", $buffer);
	$buffer = str_replace("�", "&icirc;", $buffer);
	$buffer = str_replace("�", "&Igrave;", $buffer);
	$buffer = str_replace("�", "&igrave;", $buffer);
	$buffer = str_replace("�", "&Oacute;", $buffer);
	$buffer = str_replace("�", "&oacute;", $buffer);
	$buffer = str_replace("�", "&Ocirc;", $buffer);
	$buffer = str_replace("�", "&ocirc;", $buffer);
	$buffer = str_replace("�", "&Ograve;", $buffer);
	$buffer = str_replace("�", "&ograve;", $buffer);
	$buffer = str_replace("�", "&Otilde;", $buffer);
	$buffer = str_replace("�", "&otilde;", $buffer);
	$buffer = str_replace("�", "&Uacute;", $buffer);
	$buffer = str_replace("�", "&uacute;", $buffer);
	$buffer = str_replace("�", "&Ucirc;", $buffer);
	$buffer = str_replace("�", "&ucirc;", $buffer);
	$buffer = str_replace("�", "&Ugrave;", $buffer);
	$buffer = str_replace("�", "&ugrave;", $buffer);
	$buffer = str_replace("�", "&ccedil;", $buffer);
	$buffer = str_replace("�", "&Ccedil;", $buffer);
	$buffer = str_replace("�", "&ordm;", $buffer);



	    return $buffer;

}

?>
