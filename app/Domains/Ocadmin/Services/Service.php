<?php

namespace App\Domains\Ocadmin\Services;

class Service
{
    public function generatorRows($query) {
        foreach ($query->cursor() as $rows) {
            yield $rows;
        }
    }

}