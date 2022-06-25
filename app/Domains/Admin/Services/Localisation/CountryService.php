<?php

namespace App\Domains\Admin\Services\Localisation;

use Illuminate\Http\Request;
use App\Domains\Admin\Services\Service;

class CountryService extends Service
{
	public function __construct(Request $request)
	{
		$this->modelName = "\App\Models\Country";
		$this->model = new $this->modelName;
		$this->table = $this->model->getTable();
		$this->request = $request;
	}
}