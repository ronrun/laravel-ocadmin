<?php

namespace App\Repositories;

use App\Traits\EloquentTrait;

class Repository
{
    use EloquentTrait;

    public $model;
    public $table;
    public $zh_hant_hans_transform;
    
    public function __construct(){
        if (method_exists($this, 'initialize')) {
            $this->initialize(); //in EloquentTrait
        }
    }
    
}
