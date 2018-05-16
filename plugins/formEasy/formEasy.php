<?php
/*
 * Copyright (C) 2016 vagner
 *
 * This file is part of Kolibri.
 *
 * Kolibri is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Kolibri is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Kolibri. If not, see <http://www.gnu.org/licenses/>.
 */
class formEasy extends formElements {
	private $formName;
	function __construct() {
		page::addJsFile ( '::siteroot::/vendors/jquery-ui/external/jquery/jquery.min.js' );
		$jq = new jquery ();
		// page::addJsFile ( '::siteroot::/vendors/jquery-ui/jquery-ui.js' );
		page::addJsFile ( '::siteroot::/plugins/formEasy/js/formEasy.js' );
		// page::addCssFile ( '::siteroot::/vendors/jquery-ui/jquery-ui.css' );
	}
	function addText($label, $name, $value, $obrigatorio = 0, $placeholder = '', $required = '', $pattern = '') {
		$obrigatorio = $obrigatorio != 0 ? "html-form-obrigatorio" : "";
		$this->addhtml ( '<div class="form-group">' );
		$this->addhtml ( '<label for="' . $name . '">' . $label . '</label>' );
		$this->class ( 'form-control ' . $obrigatorio )->type ( 'text' )->value ( $value )->name ( $name )->id ( $name )->size ( 90 )->maxlength ( 255 )->done ();
		$this->addhtml ( '</div>' );
	}
	function addCPF($label, $name, $value, $obrigatorio = 0) {
		$obrigatorio = $obrigatorio != 0 ? " html-form-obrigatorio" : "";
		$this->addhtml ( '<div class="form-group">' );
		$this->addhtml ( '<label for="' . $name . '">' . $label . '</label>' );
		$this->class ( 'form-control html-form-cpf' . $obrigatorio )->type ( 'text' )->value ( $value )->name ( $name )->id ( $name )->size ( 14 )->placeholder ( '000.000.000-00' )->pattern ( '[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}' )->maxlength ( 14 )->done ();
		$this->addhtml ( '</div>' );
	}
	function addCNPJ($label, $name, $value, $obrigatorio = 0) {
		$obrigatorio = $obrigatorio != 0 ? " html-form-obrigatorio" : "";
		$this->addhtml ( '<div class="form-group">' );
		$this->addhtml ( '<label for="' . $name . '">' . $label . '</label>' );
		$this->class ( 'form-control html-form-cnpj' . $obrigatorio )->type ( 'text' )->value ( $value )->name ( $name )->id ( $name )->placeholder ( '99.999.999/9999-99' )->pattern ( '[0-9]{2}.[0-9]{3}.[0-9]{3}/[0-9]{4}-[0-9]{2}' )->size ( 18 )->maxlength ( 18 )->done ();
		$this->addhtml ( '</div>' );
	}
	function addData($label, $name, $value, $obrigatorio = 0) {
		$obrigatorio = $obrigatorio != 0 ? " html-form-obrigatorio" : "";
		$this->addhtml ( '<div class="form-group">' );
		$this->addhtml ( '<label for="' . $name . '">' . $label . '</label>' );
		$this->class ( 'form-control html-form-data' . $obrigatorio )->type ( 'date' )->value ( $value )->name ( $name )->id ( $name )->size ( 10 )->maxlength ( 10 )->done ();
		$this->addhtml ( '</div>' );
	}
	function addCel($label, $name, $value, $obrigatorio = 0) {
		$obrigatorio = $obrigatorio != 0 ? " html-form-obrigatorio" : "";
		$this->addhtml ( '<div class="form-group">' );
		$this->addhtml ( '<label for="' . $name . '">' . $label . '</label>' );
		$this->class ( 'form-control html-form-cel' . $obrigatorio )->type ( 'text' )->value ( $value )->name ( $name )->id ( $name )->size ( 14 )->maxlength ( 14 )->done ();
		$this->addhtml ( '</div>' );
	}
	function addFone($label, $name, $value, $obrigatorio = 0) {
		$obrigatorio = $obrigatorio != 0 ? " html-form-obrigatorio" : "";
		$this->addhtml ( '<div class="form-group">' );
		$this->addhtml ( '<label for="' . $name . '">' . $label . '</label>' );
		$this->class ( 'form-control html-form-fone' . $obrigatorio )->type ( 'text' )->value ( $value )->name ( $name )->id ( $name )->size ( 13 )->maxlength ( 13 )->done ();
		$this->addhtml ( '</div>' );
	}
	function addCep($label, $name, $value, $obrigatorio = 0) {
		$obrigatorio = $obrigatorio != 0 ? " html-form-obrigatorio" : "";
		$this->addhtml ( '<div class="form-group">' );
		$this->addhtml ( '<label for="' . $name . '">' . $label . '</label>' );
		$this->class ( 'form-control html-form-cep' . $obrigatorio )->type ( 'text' )->value ( $value )->name ( $name )->id ( $name )->size ( 9 )->maxlength ( 9 )->done ();
		$this->addhtml ( '</div>' );
	}
	function addHora($label, $name, $value, $obrigatorio = 0) {
		$obrigatorio = $obrigatorio != 0 ? " html-form-obrigatorio" : "";
		$this->addhtml ( '<div class="form-group">' );
		$this->addhtml ( '<label for="' . $name . '">' . $label . '</label>' );
		$this->class ( 'form-control html-form-hora' . $obrigatorio )->type ( 'time' )->value ( $value )->name ( $name )->id ( $name )->size ( 5 )->maxlength ( 5 )->done ();
		$this->addhtml ( '</div>' );
	}
	function addTextArea($label, $name, $value, $obrigatorio = 0) {
		$obrigatorio = $obrigatorio != 0 ? " html-form-obrigatorio" : "";
		$this->addhtml ( '<div class="form-group">' );
		$this->addhtml ( '<label for="' . $name . '">' . $label . '</label>' );
		$this->class ( 'form-control ' . $obrigatorio )->type ( 'textarea' )->value ( $value )->name ( $name )->id ( 'id' . $name )->done ();
		$this->addhtml ( '</div>' );
	}
	function printform() {
		$out = parent::printform ();
		$js .= '$(document).ready(function(){
					$("#' . $this->formName . '").htmlForm();
                                                                                                                      
		});';
		page::addJsScript ( $js );
		return $out;
	}
	function addSelect($label, $name, $value, $selected, $obrigatorio = 0) {
		$obrigatorio = $obrigatorio != 0 ? "html-form-obrigatorio" : "";
		$this->addhtml ( '<div class="form-group">' );
		$this->class ( 'form-control ' . $obrigatorio )->type ( 'select' )->label ( $label )->name ( $name )->value ( '' )->id ( $name )->done ();
		$this->type ( 'option' )->label ( 'Selecione' )->name ( "Selecione" )->selected ( false )->id ( "Selecione" )->value ( '' )->done ();
		if (is_array ( $value )) {
			foreach ( $value as $item ) {
				if ($selected == $item [0]) {
					$this->type ( 'option' )->label ( $item [1] )->name ( $item [1] )->selected ( true )->id ( $item [1] )->value ( $item [0] )->done ();
				} else {
					$this->type ( 'option' )->label ( $item [1] )->name ( $item [1] )->selected ( false )->id ( $item [1] )->value ( $item [0] )->done ();
				}
			}
		}
		$this->closeSelect ();
		$this->addhtml ( '</div>' );
	}
	function addDatalist($label, $name, $value, $obrigatorio = 0) {
		$obrigatorio = $obrigatorio != 0 ? "html-form-obrigatorio" : "";
		$this->addhtml ( '<div class="form-group">' );
		$this->class ( 'form-control ' . $obrigatorio )->type ( 'text' )->list ( "lst_" . $name )->label ( $label )->name ( $name )->value ( '' )->id ( $name )->done ();
		$this->type ( 'datalist' )->id ( "lst_" . $name )->done ();
		if (is_array ( $value )) {
			foreach ( $value as $item ) {
				
				$this->type ( 'option' )->label ( $item [1] )->name ( $item [1] )->id ( $item [1] )->value ( $item [1] )->done ();
			}
		}
		$this->closeDatalist ();
		$this->addhtml ( '</div>' );
	}
	function addSelectAjaxTarget($label, $name, $value, $selected, $selectTarget, $urlData, $obrigatorio = 0) {
		$js = "
                $(document).ready(function(){
                    $(\"#$name\").change(function(){
                        $.post('$urlData',{
                            $name : $( \"#$name\" ).val()
                            },function( data ) {
                            $( \"#$selectTarget\" ).html( data );
                          });
                       });
             });

             ";
		
		page::addJsScript ( $js );
		$obrigatorio = $obrigatorio != 0 ? "html-form-obrigatorio" : "";
		$this->class ( 'form-control ' . $obrigatorio )->type ( 'select' )->label ( $label )->name ( $name )->value ( '' )->id ( $name )->done ();
		$this->type ( 'option' )->label ( 'Selecione' )->name ( "Selecione" )->selected ( false )->id ( "Selecione" )->value ( '' )->done ();
		if (is_array ( $value )) {
			foreach ( $value as $item ) {
				if ($selected == $item [0]) {
					$this->type ( 'option' )->label ( $item [1] )->name ( $item [1] )->selected ( true )->id ( $item [1] )->value ( $item [0] )->done ();
				} else {
					$this->type ( 'option' )->label ( $item [1] )->name ( $item [1] )->selected ( false )->id ( $item [1] )->value ( $item [0] )->done ();
				}
			}
		}
		$this->closeSelect ();
	}
	function addRadio($label, $name, $value, $selected, $obrigatorio = 0) {
		$this->addhtml ( "<label>$label</label>" );
		foreach ( $value as $item ) {
			$obrigatorio = $obrigatorio != 0 ? " html-form-obrigatorio" : "";
			if ($selected == $item [0]) {
				$this->class ( 'radio-inline ' . $obrigatorio )->type ( 'radio' )->label ( $item [1] )->name ( $name )->selected ( true )->id ( $name )->value ( $item [0] )->done ();
			} else {
				$this->class ( 'radio-inline ' . $obrigatorio )->type ( 'radio' )->label ( $item [1] )->name ( $name )->selected ( false )->id ( $name )->value ( $item [0] )->done ();
			}
		}
		$this->addhtml ( "<br><br>" );
	}
	function addCheckbox($label, $name, $value, $selected, $obrigatorio = 0) {
		$this->addhtml ( "<label>$label</label>" );
		foreach ( $value as $item ) {
			$obrigatorio = $obrigatorio != 0 ? " html-form-obrigatorio" : "";
			if ($selected == $item [0]) {
				$this->class ( 'checkbox-inline ' . $obrigatorio )->type ( 'checkbox' )->label ( $item [1] )->name ( $name )->selected ( true )->id ( $name )->value ( $item [0] )->done ();
			} else {
				$this->class ( 'checkbox-inline ' . $obrigatorio )->type ( 'checkbox' )->label ( $item [1] )->name ( $name )->selected ( false )->id ( $name )->value ( $item [0] )->done ();
			}
		}
		$this->addhtml ( "<br><br>" );
	}
	function addPasswordCad($label, $name, $value, $obrigatorio = 0) {
		$obrigatorio = $obrigatorio != 0 ? " html-form-obrigatorio" : "";
		debug::log ( "password $name" );
		$this->type ( 'hidden' )->value ( "$name" )->class ( 'passwordNameVerify' )->name ( "passwordFieldName" )->id ( "passwordFieldName" )->done ();
		$this->class ( 'form-control  ' . $obrigatorio )->type ( 'password' )->value ( $value )->label ( $label )->name ( $name . "A" )->id ( $name + "A" )->size ( 10 )->maxlength ( 20 )->done ();
		$this->class ( 'form-control  ' . $obrigatorio )->type ( 'password' )->label ( "Confirmar " )->name ( $name . "B" )->id ( $name + "B" )->size ( 10 )->maxlength ( 20 )->done ();
	}
	function addcapcha() {
		page::addJsFile ( "https://www.google.com/recaptcha/api.js" );
		$this->addhtml ( '<div class="g-recaptcha" data-sitekey="' . config::recapchaSiteKey () . '"></div>' );
	}
	function openForm() {
		if (! $this->name) {
			$str = base64_encode ( rand ( 100, 200 ) );
			$this->name ( $str );
			$this->id ( $str );
		}
		$this->formName = $this->name;
		// parent::name($this->name);
		parent::openForm ();
	}
	function formActionButton($urlTarget, $buttonName, $varArrays = '', $target = '_self') {
		$myform = new formEasy ();
		$myform->action ( $urlTarget )->method ( "post" )->target ( $target )->openForm ();
		if (is_array ( $varArrays )) {
			foreach ( $varArrays as $k => $v ) {
				$myform->type ( "hidden" )->name ( $k )->value ( $v )->done ();
			}
		}
		$myform->type ( 'submit' )->class ( 'btn btn-primary' )->value ( $buttonName )->done ();
		$myform->closeForm ();
		return $myform->printform ();
	}
	function formActionIcon($urlTarget, $buttonName = '', $varArrays = '', $glyphicon = 'glyphicon glyphicon-cog', $onclick = '', $target = '_self') {
		$myform = new formEasy ();
		$myform->action ( $urlTarget )->method ( "post" )->target ( $target )->openForm ();
		if (is_array ( $varArrays )) {
			foreach ( $varArrays as $k => $v ) {
				$myform->type ( "hidden" )->name ( $k )->value ( $v )->done ();
			}
		}
		$cod = "<button type='submit' class='btn btn-primary' >
      			<span class='$glyphicon'></span> $buttonName
    		</button>";
		$myform->addhtml ( $cod );
		$myform->closeForm ();
		return $myform->printform ();
	}
}
