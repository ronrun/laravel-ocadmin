<?php

namespace App\Domains\Admin\Services\User;

use Illuminate\Support\Facades\Hash;
use App\Repositories\User\RoleRepository;
use App\Repositories\User\RoleMetaRepository;
use App\Services\Service;
use App\Helpers\Classes\DataHelper;


class RoleService extends Service
{
    protected $repository;
    protected $modelName = "\App\Models\Role\Role";

    public function __construct(private RoleRepository $RoleRepository, private RoleMetaRepository $RoleMetaRepository)
    {
        $this->repository = $RoleRepository;
    }

    public function findIdOrFailOrNew($role_id)
    {
        $result = $this->repository->findIdOrFailOrNew($role_id);

        if(empty($result['error']) && !empty($result['data'])){
            $role = $result['data'];
        }else if(!empty($result['error'])){
            return response(json_encode(['error' => $result['error']]))->header('Content-Type','application/json');
        }

        $role->code = $role->name;

        return ['data' => $role];
    }

    public function getRoles($data, $debug = 0)
    {
        return $this->repository->getRoles($data, $debug);
    }

    public function addRoles($data, $debug = 0)
    {

    }

    // public function deleteRoleById($id)
    // {
    //     try {

    //         $result = $this->repository->deleteId($id);

    //         if(!empty($result['error'])){
    //             throw new \Exception($result['error']); 
    //         }

    //         $result['success'] = true;

    //         return $result;

    //     } catch (\Exception $ex) {
    //         return ['error' => $ex->getMessage()];
    //     }
    // }

    public function destroyRoles($data)
    {
        
    }

    public function save($post_data)
    {
        try {
            //save role
            $result = $this->repository->save($post_data['role_id'], $post_data);

            if(!empty($result['error'])){
                throw new \Exception($result['error']); 
            }
            
            $role = $result['data'];
            
            //save translation meta
            $result = null;
            if(!empty($post_data['translations'])){
                $result = $this->RoleMetaRepository->saveMetaTranslations($role, $post_data['translations']);
            }
            
            return ['data' => ['role_id' => $role->id]];

        } catch (\Exception $ex) {
            $msg = $ex->getMessage();
            $json['error'] = $msg;
            return $json;
        }
    }

    public function removeAdmin($role_id)
    {
        //$this->RoleMetaRepository->removeAdmin($role_id);
    }
}