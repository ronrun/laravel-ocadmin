<?php

namespace App\Domains\Ocadmin\Services\User;

use App\Repositories\Eloquent\User\UserRepository;

class UserService
{
	public function __construct(UserRepository $userRepository)
	{
        $this->repository = $userRepository;
	}
    
    public function getUsers($filters)
    {
        $filters['filter_is_admin'] = '=1';
        $user = $this->repository->getRow($filters,'*');
        echo "<pre>", print_r(999, 1), "</pre>"; exit;

    }
}