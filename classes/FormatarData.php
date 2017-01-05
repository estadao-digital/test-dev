<?php

// Help para datas
class FormatarData {

	// Ajuda com formatação da data 
	public static function formatar($data = '') {
		$date = implode('-', array_reverse(explode('/', $data)));

		// Caso cliente não selecione a data, força a data de hoje.
		if( !trim($date) ){
			$current_data = date('Y-m-d');
			$date = $current_data;
		}

		return $date;
	}

}