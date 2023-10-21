<?php

namespace App\Repositories\Catalog;

use Illuminate\Support\Facades\DB;
use App\Models\Catalog\Product;
use App\Repositories\Repository;

class ProductRepository extends Repository
{
    protected $model_name = 'App\Models\Catalog\Product';
    
    public function getProducts($data = [], $debug = 0): mixed
    {
        return parent::getRows($data, $debug);
    }

    public function saveProduct($post_data, $debug = 0)
    {
        DB::beginTransaction();

        try {
            if(empty($post_data['product_id']) && !empty($post_data['id'])){
                $post_data['product_id'] = $post_data['id'];
            }
            $product = $this->findIdOrFailOrNew($post_data['product_id']);
            $result = $this->saveRow($product, $post_data);

            if(!empty($result['error'])){
                throw new \Exception($result['error']);
            }

            DB::commit();
    
            return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            $result['error'] = 'Error code: ' . $ex->getCode() . ', Message: ' . $ex->getMessage();
            return $result;
        }
    }
}

