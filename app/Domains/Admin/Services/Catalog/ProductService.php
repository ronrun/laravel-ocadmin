<?php

namespace App\Domains\Admin\Services\Catalog;

use App\Traits\EloquentNewTrait;
use App\Repositories\Catalog\ProductRepository;

class ProductService
{
    use EloquentNewTrait;

    public $model_name = "\App\Models\Catalog\Product";
    public $model;
    public $table;
    public $lang;

    public function __construct(private ProductRepository $ProductRepository)
    {}


    public function getProducts($data, $debug=0)
    {
        return $this->ProductRepository->getProducts($data, $debug);
    }


    public function saveProduct($data, $debug = 0)
    {
        return $this->ProductRepository->saveProduct($data, $debug);
    }

}
