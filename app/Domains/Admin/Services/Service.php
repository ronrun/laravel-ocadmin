<?php

namespace App\Domains\Admin\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\Traits\Model\EloquentTrait;
use App\Domains\Admin\Exceptions\NotFoundException;

use Exception;

class Service
{
    use EloquentTrait;


    // Eloquent
    public function findOrNew($id)
    {
        return $this->newModel()->findOrNew($id);
    }

    
    public function findOrFail($id)
    {
        try {
            $record = $this->newModel()->findOrFail($id);
        } catch (ModelNotFoundException  $e) {
            throw new NotFoundException('Resource not found!!');
        }
        
        return $record;
    }

    
    public function findOrFailOrNew($id = null)
    {
        if($id == null){
            return $this->newModel();
        }else{
            return $this->findOrFail($id);
        }
    }
    

    // EloquentTrait
    public function getRecord($queries)
    {
        return $this->getModelInstance($queries);
    }


    public function getRecords($queries)
    {
        return $this->getModelCollection($queries);
    }


    


    /**
     * Return eloquent's first()
     */
    public function getRecordById($id)
    {
        $queries = [
            'filter_id' => $id,
            'regexp' => false,
        ];

        return $this->getModelInstance($queries);
    }

    /**
     * Return eloquent's first() or throw an exception
     */
    public function getRecordByIdOrFail($id)
    {
        $queries = [
            'filter_id' => $id,
            'regexp' => false,
        ];
        $record = $this->getModelInstance($queries);

        if(empty($record)){
            return false; //should improve
        }

        return $record;
    }


    /**
     * Return eloquent's first() or new an instance.
     */
    public function getRecordOrNew($queries, $debug=0)
    {
        return $this->getModelFirstOrNew($queries, $debug);
    }


    /**
     * If $id provided, that record should exists. Or return fail.
     * If $id is null, then new.
     */
    // public function getRecordByIdOrFailOrNew($id = null)
    // {
    //     if(!empty($id)){
    //         $queries = [
    //             'filter_id' => $id,
    //             'regexp' => false,
    //         ];
    //         $record = $this->getRecordOrFail($queries);
    //     }else{
    //         $record = $this->newModel();
    //     }

    //     return $record;
    // }


    /**
     * If fail, throw an exception
     */
    public function getRecordOrFail($queries)
    {
        $record = $this->getRecord($queries);

        if(empty($record)){
            return false;
        }

        return $record;
    }

}