<?php

namespace App\Domains\Admin\Services\User;

use Illuminate\Support\Facades\Hash;
use App\Repositories\User\PermissionRepository;
use App\Repositories\User\PermissionMetaRepository;
use App\Services\Service;
use App\Helpers\Classes\DataHelper;


class PermissionService extends Service
{
    protected $repository;
    protected $modelName = "\App\Models\Permission\Permission";

    public function __construct(private PermissionRepository $PermissionRepository, private PermissionMetaRepository $PermissionMetaRepository)
    {
        $this->repository = $PermissionRepository;
    }

    public function findIdOrFailOrNew($permission_id)
    {
        $result = $this->repository->findIdOrFailOrNew($permission_id);

        if(empty($result['error']) && !empty($result['data'])){
            $permission = $result['data'];
        }else if(!empty($result['error'])){
            return response(json_encode(['error' => $result['error']]))->header('Content-Type','application/json');
        }

        $permission->code = $permission->name;

        return ['data' => $permission];
    }

    public function getPermissions($data, $debug = 0)
    {
        return $this->repository->getPermissions($data, $debug);
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
            
            //save translation meta
            $result = null;
            if(!empty($post_data['translations'])){
                $result = $this->PermissionMetaRepository->saveMetaTranslations($permission, $post_data['translations']);
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