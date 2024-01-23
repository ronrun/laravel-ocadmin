<?php

namespace App\Domains\Admin\Services\User;

use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserMetaRepository;
use App\Services\Service;

class UserService extends Service
{
    protected $repository;
    protected $modelName = "\App\Models\User\User";

    public function __construct(private UserRepository $UserRepository, private UserMetaRepository $UserMetaRepository)
    {
        $this->repository = $UserRepository;
    }

    public function getUsers($data, $debug = 0)
    {
        $rows = $this->repository->getUsers($data, $debug);

        foreach($rows as $row){

        }

        return $rows;
    }

    public function addUsers($data, $debug = 0)
    {

    }

    public function deleteUserById($id)
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

    public function destroyUsers($data)
    {
        
    }

    public function save($post_data)
    {
        try {
            //save user
            $result = $this->repository->save($post_data['user_id'], $post_data);

            if(!empty($result['error'])){
                throw new \Exception($result['error']); 
            }
            
            $user = $result['data'];

            //save user meta
            //$result = $this->UserMetaRepository->save($user, $post_data);
            $result = $this->UserMetaRepository->save($user, $post_data);

            if(!empty($result['error'])){
                throw new \Exception($result['error']); 
            }
            
            return ['data' => ['user_id' => $user->id]];

        } catch (\Exception $ex) {
            $msg = $ex->getMessage();
            $json['error'] = $msg;
            return $json;
        }
    }

    public function removeAdmin($user_id)
    {
        //$this->UserMetaRepository->removeAdmin($user_id);
    }
}