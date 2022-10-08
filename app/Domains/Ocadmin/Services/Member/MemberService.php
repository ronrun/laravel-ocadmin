<?php

namespace App\Domains\Ocadmin\Services\Member;

use App\Repositories\Eloquent\Member\MemberRepository;

class MemberService
{

	public function __construct(MemberRepository $memberRepository)
	{
        $this->repository = $memberRepository;
	}

	public function getMembers($queries, $_debug = 0)
	{
        $members = $this->repository->getRows($queries,'*', $_debug);
		
		if(!empty($members)){
            foreach ($members as $row) {
                $row->edit_url = route('lang.admin.member.members.form', array_merge([$row->id], $queries));
            }
        }

        return $members;
	}

    public function firstOrNew($id)
    {
        //$members = $this->repository->getNewModel()->firstOrNew(['id' => ]);

    }

    public function findIdOrNew($id)
    {
        $member = $this->repository->getNewModel()->firstOrNew(['id' => $id]);
        
        return $member;
    }

    public function findFirst($column, $operator, $value)
    {
        $row = $this->repository->getNewModel()->where($column, $operator, $value)->first();

        return $row;
    }

    public function addMember($data)
    {
        $row = $this->repository->getNewModel();

        $row->first_name 	= $data['first_name'];
        $row->last_name		= $data['last_name'];
        $row->name		    = $data['first_name'] . ' ' . $data['last_name'];
        $row->email 		= $data['email'];
        $row->mobile        = $data['mobile'];

        if(!empty($data['password'])){
            $row->password = bcrypt($data['password']);
        }

        if($row->save()){
            return $row->id;
        }
    }

    public function editMember($id, $data)
    {
        $row = $this->repository->getNewModel()->find($id);

        $row->first_name 	= $data['first_name'];
        $row->last_name		= $data['last_name'];
        $row->name		    = $data['first_name'] . ' ' . $data['last_name'];
        $row->email 		= $data['email'];
        $row->mobile        = $data['mobile'];

        if(!empty($data['password'])){
            $row->password = bcrypt($data['password']);
        }

        $row->save();
    }
}