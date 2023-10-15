<?php

namespace App\Repositories\Catalog;

use Illuminate\Support\Facades\DB;
use App\Helpers\EloquentHelper;
use App\Models\Catalog\Product;
use App\Repositories\Repository;

class ProductRepository extends Repository
{
    protected $model = 'App\Models\Catalog\Product';
    
    public function getProducts($data = [], $debug = 0)
    {
        $data['model'] = new Product;

        $rows = EloquentHelper::getRows($data, $debug);

        if(!empty($data['with']) && in_array('translations', $data['with'])){
            $rows = EloquentHelper::resetTranslations($rows);
        }

        return $rows;
    }

    public function getProduct($data = [], $debug = 0)
    {
        $data['model'] = new Product;

        $row = EloquentHelper::getRow($data, $debug);

        if(!empty($data['with']) && in_array('translations', $data['with'])){
            $row = EloquentHelper::resetRowTranslation($row);
        }

        return $row;
    }

    public function save($row, $data, $debug)
    {
        DB::beginTransaction();



        try {
            $row = EloquentHelper::findOrFailOrNew($row->id, $row);
            EloquentHelper::save($row, $data);

            if(!empty($data['translations'])){
                $this->saveTranslationData($product, $data['product_translations']);
            }

            // DB::commit();

            // $result['data']['record_id'] = $product->id;
    
            // return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            $result['error'] = 'Error code: ' . $ex->getCode() . ', Message: ' . $ex->getMessage();
            return $result;
        }
    }
}

