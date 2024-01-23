<?php

namespace App\Models\Sysdata;

use Illuminate\Database\Eloquent\Model;
use App\Models\SysData\State;
use App\Models\SysData\City;

class Country extends Model
{
    public $timestamps = false;
    public $connection = 'sysdata';
    protected $table = 'countries';
    protected $guarded = [];

    public function states()
    {
        return $this->hasMany(State::class, 'country_code', 'code');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'country_code', 'code');
    }
}