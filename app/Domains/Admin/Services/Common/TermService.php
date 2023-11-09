<?php

namespace App\Domains\Admin\Services\Common;

use App\Services\Service;
use App\Repositories\Common\TermRepository;

class TermService extends Service
{
    public function __construct(TermRepository $repository)
    {
        $this->repository = $repository;
    }
}
