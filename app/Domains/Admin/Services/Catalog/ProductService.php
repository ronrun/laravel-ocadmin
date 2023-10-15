<?php

namespace App\Domains\Admin\Services\Catalog;

use Illuminate\Support\Facades\DB;
use App\Helpers\EloquentHelper;
use App\Repositories\Catalog\ProductRepository;


class ProductService
{

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


    public function save($row, $data, $debug)
    {
        return $this->ProductRepository->save($row, $data, $debug);
    }

}
