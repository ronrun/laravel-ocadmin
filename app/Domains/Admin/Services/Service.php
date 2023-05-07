<?php

namespace App\Domains\Admin\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\Model\EloquentTrait;
use Exception;

class Service
{
    use EloquentTrait;

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
    public function getRecordOrNew($queries)
    {
        return $this->getModelFirstOrNew($queries);
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
    

    public function getRecord($queries)
    {
        return $this->getModelInstance($queries);
    }


    public function getRecords($queries)
    {
        return $this->getModelCollection($queries);
    }

}