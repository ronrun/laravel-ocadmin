<?php

namespace App\Models\Member;

use App\Models\User\User;

class Member extends User
{
    
    protected $appends = ['create_date'];

    // public function getCreateDateAttribute()
    // {
    //     $created_at = $this->attributes['created_at'];

    //     return \Carbon\Carbon::parse($created_at)->format('Y-m-d');
    // }



}
