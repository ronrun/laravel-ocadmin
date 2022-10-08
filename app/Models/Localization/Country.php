<?php

namespace App\Models\Localization;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $timestamps = false;
    
    protected $guarded = [];

    public function zones()
    {
        return $this->hasMany(Zone::class, 'country_id', 'id');
    }
}
