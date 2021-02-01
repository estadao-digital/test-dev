<?php

declare(strict_types=1);

namespace App;

class Response
{
	public function json(array $data, $status = 200)
	{
		if (empty($data)) {
			return;
		}
		
		http_response_code($status);

		echo json_encode($data, JSON_UNESCAPED_SLASHES);
	}
}
