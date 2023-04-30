<?php

namespace App\Domains\Admin\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\Model\EloquentTrait;
use Exception;

class Service
{
    use EloquentTrait;

    public function getRecords($queries)
    {
        $users = $this->getModelCollection($queries);
        return $users;
    }


    public function getFirstOrNew($queries)
    {
        $users = $this->getModelFirstOrNew($queries);
        return $users;
    }

}