<?php

namespace App\Repositories\Catalog;

use Illuminate\Support\Facades\DB;
use App\Models\Catalog\Product;
use App\Traits\EloquentNewTrait;

class ProductRepository
{
    use EloquentNewTrait;

    protected $model_name = 'App\Models\Catalog\Product';
    
    public function getProducts($data = [], $debug = 0)
    {
        $rows = $this->getRows($data, $debug);
        $rows = $this->setTranslationToRows($rows,['name']);

        return $rows;
    }

    public function saveProduct($data, $debug)
    {
        DB::beginTransaction();

        try {
            $row = $this->findIdOrFailOrNew($data['product_id']);
            $this->save($row, $data);

            if(!empty($data['translations'])){
                $this->saveTranslationMeta($row, $data['translations']);
            }

            DB::commit();

            $result['data']['record_id'] = $row->id;
    
            return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            $result['error'] = 'Error code: ' . $ex->getCode() . ', Message: ' . $ex->getMessage();
            return $result;
        }
    }
}

