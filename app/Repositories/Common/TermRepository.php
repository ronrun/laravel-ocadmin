<?php

namespace App\Repositories\Common;

use App\Repositories\Repository;
use App\Models\Common\Term;
use App\Models\Common\TermMetas;
use App\Models\Common\Taxonomy;

class TermRepository extends Repository
{
    public $model_name = "\App\Models\Common\Term";

    public function getOptionValues($option_id)
    {
       // $this->initialize();
        echo '<pre>', print_r(33, 1), "</pre>"; exit;

    }
}

