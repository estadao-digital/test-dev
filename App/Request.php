<?php

declare(strict_types=1);

namespace App;

class Request
{
	public array $get 	= [];
	public array $post 	= [];
	public array $files = [];

	public function __construct()
	{
		$this->get		= $this->clean($_GET);
		$this->post 	= $this->clean($_POST);
		$this->files	= $this->clean($_FILES);
	}

	/**
	 * sanitize the globals
	 * 
	 * @param	mixed $data
	 * @return	mixed
	 */
	private function clean($data)
	{
		if (false === is_array($data)) {
			return is_string($data) ? htmlspecialchars($data, ENT_COMPAT, 'UTF-8') : $data;
		}
		
		foreach ($data as $key => $value) {
			unset($data[$key]);

			$data[$this->clean($key)] = $this->clean($value);
		}

		return $data;
	}
}
