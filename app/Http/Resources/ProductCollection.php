<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        //return parent::toArray($request);
        parent::toArray($request);
        return $this->resource;
    }
}
