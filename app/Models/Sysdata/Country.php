<?php

namespace App\Models\Sysdata;

use Illuminate\Database\Eloquent\Model;
use App\Models\SysData\Division1;
use App\Models\SysData\Division2;

class Country extends Model
{
    public $timestamps = false;
    public $connection = 'sysdata';
    protected $table = 'countries';
    protected $guarded = [];

    public function division1s()
    {
        return $this->hasMany(Division1::class, 'country_code', 'code');
    }

    public function division2s()
    {
        return $this->hasMany(Division2::class, 'country_code', 'code');
    }
}