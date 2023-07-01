<?php

namespace App\Domains\Admin\Services\Post;

use Illuminate\Support\Facades\DB;
use App\Domains\Admin\Services\Service;

class PostService extends Service
{
    public $model_name = "\App\Models\Post\Post";
    public $model;
    public $table;
    public $lang;


    public function getPosts($data)
    {        
        return $this->getRows($data);
    }


    public function save($data)
    {
        DB::beginTransaction();

        try {
            $post = $this->findOrFailOrNew(id:$data['post_id']);
            $this->saveModelInstance($post, $data);

            if(!empty($data['post_translations'])){
                $this->saveTranslationData($post, $data['post_translations']);
            }

            DB::commit();

            $result['data']['record_id'] = $post->id;
    
            return $result;

        } catch (\Exception $ex) {
            DB::rollback();
            $result['error'] = 'Error code: ' . $ex->getCode() . ', Message: ' . $ex->getMessage();
            echo '<pre>Exception ', print_r($result['error'], 1), "</pre>"; exit;
            return $result;
        }
    }

}
