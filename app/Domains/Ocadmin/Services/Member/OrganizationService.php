<?php

namespace App\Domains\Ocadmin\Services\Member;

use App\Repositories\Eloquent\Member\OrganizationRepository;

class OrganizationService
{
    private $modelName = "\App\Models\Member\Organization";

	public function __construct(OrganizationRepository $organizationRepository)
	{
		$this->model = new $this->modelName;
		$this->table = $this->model->getTable();
        $this->repository = $organizationRepository;
	}

	public function getOrganizations($data, $_debug = 0)
	{
        $rows = $this->repository->getRows($data,'*', $_debug);
		
        return $rows;
	}
}