<?php

namespace App\Modules\Brands\Infra\Pixie\Entities;

use App\Shared\ActiveRecord\ActiveRecord;

final class Marca extends ActiveRecord
{
	protected $table = 'brands';

	protected $idField = 'id';

	protected $logTimestamp = false;
}
