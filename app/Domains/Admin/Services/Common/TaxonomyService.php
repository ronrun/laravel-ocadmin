<?php

namespace App\Domains\Admin\Services\Common;

use App\Repositories\Common\TaxonomyRepository;
use App\Services\Service;

class TaxonomyService extends Service
{
    public function __construct(TaxonomyRepository $repository)
    {
        $this->repository = $repository;
    }
}
