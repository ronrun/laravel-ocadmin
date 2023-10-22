<?php

namespace App\Domains\Admin\Services\Common;

use App\Repositories\Common\TermRepository;
use App\Services\Service;

class TermService extends Service
{
    public function __construct(TermRepository $repository)
    {
        $this->repository = $repository;
    }
}
