<?php

namespace App\Domains\Ocadmin\Services\Localization;

class CountryService
{
    private $modelName = "\App\Models\Localization\Country";

	public function __construct()
	{
		$this->model = new $this->modelName;
	}

	public function getCountries()
	{
        $rows = $this->model->all();
        
        return $rows;
	}
}