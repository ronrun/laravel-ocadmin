<?php

namespace App\Domains\Admin\Services\User;

use App\Services\Service;
use App\Repositories\User\PermissionRepository;

class PermissionService extends Service
{
    public function __construct(PermissionRepository $repository)
    {
        $this->repository = $repository;
    }
}