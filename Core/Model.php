<?php
/**
 * @author Werberson <werberson@werberson.com>
 * @package Core
 */
namespace Core;

class Model 
{
	/**
	 * Variavél que recebe a conexão
	 *
	 * @var [type]
	 */
	protected $db;

	public function __construct() {
		global $db;
		$this->db = $db;
	}

}