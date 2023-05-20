<?php

namespace App\Domains\Admin\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Domains\Admin\Exceptions\NotFoundException;
use App\Traits\EloquentTrait;

use Exception;

class Service
{
    use EloquentTrait;

	public function __construct()
	{
        $this->model = new $this->modelName;
        $this->table = $this->model->getTable();
	}


    // Eloquent
    public function findOrNew($id, $data=null)
    {
        return $this->newModel()->findOrNew($id);
    }

    
    public function findOrFail($id, $data=null)
    {
        try {
            $record = $this->newModel()->findOrFail($id);
        } catch (ModelNotFoundException  $e) {
            throw new NotFoundException('Resource not found!!');
        }
        
        return $record;
    }

    
    public function findOrFailOrNew($id=null, $data=null)
    {
        if($id != null){
            return $this->findOrFail($id);
        }else{
            return $this->newModel();
        }
    }
    

    // EloquentTrait
    public function getRecord($queries, $debug=0)
    {
        return $this->getModelInstance($queries, $debug);
    }


    public function getRecords($queries, $debug=0)
    {
        return $this->getModelCollection($queries, $debug);
    }

}