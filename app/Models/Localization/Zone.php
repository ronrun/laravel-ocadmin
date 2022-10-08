<?php

namespace App\Models\Localization;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    public $timestamps = false;
    
    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
