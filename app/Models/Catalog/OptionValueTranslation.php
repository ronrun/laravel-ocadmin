<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;

class OptionValueTranslation extends Model
{
    public $timestamps = false;
    protected $table = 'term_translations';
    protected $guarded = [];
    public $foreign_key = 'term_id';
}
