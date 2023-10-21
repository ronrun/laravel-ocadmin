<?php

namespace App\Domains\Admin\Services\Catalog;

use App\Repositories\Catalog\ProductRepository;
//use App\Http\Resources\ProductCollection;
use App\Services\Service;

class ProductService extends Service
{
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }
}
