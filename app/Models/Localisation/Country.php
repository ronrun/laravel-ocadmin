<?php

namespace App\Models\Localisation;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $guarded = [];

    public function zones()
    {
        return $this->hasMany(Zone::class, 'country_id', 'id');
    }
}
