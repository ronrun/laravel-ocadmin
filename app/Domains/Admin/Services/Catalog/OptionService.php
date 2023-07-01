<?php

namespace App\Domains\Admin\Services\Catalog;

use Illuminate\Support\Facades\DB;
use App\Domains\Admin\Services\Service;
use App\Models\Common\Term;

class OptionService extends Service
{
    public $model_name = "\App\Models\Common\Term";
    public $model;
    public $table;
    public $lang;

    public function getOptions($data)
    {
        $data['WhereRawSqls'][] = "taxonomy_code='product_option'";    

        return $records = $this->getRows($data);
    }
    

    public function getOptionValues($option_id)
    {
        Term::where('id', $option_id)->first();
        
        
        $option = (new \App\Repositories\Common\TermRepository)->getOptionValues($option_id);
        echo '<pre>option ', print_r(999, 1), "</pre>"; exit;

    }
}
