<?php

namespace App\Domains\Admin\Services\Catalog;

use Illuminate\Support\Facades\DB;
use App\Domains\Admin\Services\Service;

class ProductService extends Service
{
    public $modelName = "\App\Models\Catalog\Product";
    public $model;
    public $table;
    public $lang;


    public function getProducts($data)
    {        
        return $this->getRecords($data);
    }


    public function save($data)
    {
        DB::beginTransaction();

        try {
            $product = $this->findOrFailOrNew(id:$data['product_id']);
            $this->saveModelInstance($product, $data);

            if(!empty($data['product_translations'])){
                $this->saveTranslationData($product, $data['product_translations']);
            }

            DB::commit();

            $result['data']['record_id'] = $product->id;
    
            return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            $result['error'] = 'Error code: ' . $ex->getCode() . ', Message: ' . $ex->getMessage();
            return $result;
        }
    }

}
