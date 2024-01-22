<?php

namespace App\Domains\Admin\Services\User;

use Illuminate\Support\Facades\Hash;
use App\Repositories\User\PermissionRepository;
use App\Repositories\User\PermissionMetaRepository;
use App\Services\Service;

class PermissionService extends Service
{
    protected $repository;
    protected $modelName = "\App\Models\Permission\Permission";

    public function __construct(private PermissionRepository $PermissionRepository, private PermissionMetaRepository $PermissionMetaRepository)
    {
        $this->repository = $PermissionRepository;
    }

    public function getPermissions($data, $debug = 0)
    {
        $rows = $this->repository->getPermissions($data, $debug);

        foreach($rows as $row){

        }

        return $rows;
    }

    public function addPermissions($data, $debug = 0)
    {

    }

    public function deletePermissionById($id)
    {
        try {

            $result = $this->repository->deleteId($id);

            if(!empty($result['error'])){
                throw new \Exception($result['error']); 
            }

            $result['success'] = true;

            return $result;

        } catch (\Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function destroyPermissions($data)
    {
        
    }

    public function save($post_data)
    {
        try {
            //save permission
            $result = $this->repository->save($post_data['permission_id'], $post_data);

            if(!empty($result['error'])){
                throw new \Exception($result['error']); 
            }
            
            $permission = $result['data'];

            //save permission meta
            $result = $this->PermissionMetaRepository->save($permission, $post_data);

            if(!empty($result['error'])){
                throw new \Exception($result['error']); 
            }
            
            return ['data' => ['permission_id' => $permission->id]];

        } catch (\Exception $ex) {
            $msg = $ex->getMessage();
            $json['error'] = $msg;
            return $json;
        }
    }

    public function removeAdmin($permission_id)
    {
        //$this->PermissionMetaRepository->removeAdmin($permission_id);
    }
}