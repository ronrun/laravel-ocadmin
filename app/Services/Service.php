<?php

namespace App\Services;

class Service
{
    protected $repository;

    public function __call($method, $parameters)
    {
        if(!empty($this->repository)){
            if (!method_exists($this, $method) && method_exists($this->repository, $method)) {
                return call_user_func_array([$this->repository, $method], $parameters);
            }
        }

        throw new \BadMethodCallException("Method [$method] does not exist.");
    }
}
