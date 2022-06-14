<?php

namespace App\Domains\Admin\Services;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tiptop\TTGEM;

class UserService
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        // $this->modelName = "\App\Models\User";
        // $this->model = new $this->modelName;
        // $this->table = $this->model->getTable();

    }

}