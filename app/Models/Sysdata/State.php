<?php

// State, province

namespace App\Models\Sysdata;

//use Illuminate\Database\Eloquent\Model;
use App\Models\SysData\Country;
use App\Models\SysData\Division;
use App\Models\SysData\City;

class State extends Division
{
    public $timestamps = false;
    public $connection = 'sysdata';
    protected $table = 'divisions';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
 
        static::addGlobalScope(function ($query) {
            $query->where('level', 1);
        });
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'parent_id', 'id');
    }
}