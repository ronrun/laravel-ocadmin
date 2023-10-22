<?php

namespace App\Repositories;

use App\Traits\EloquentNewTrait;
use App\Libraries\TranslationLibrary;

class Repository
{
    use EloquentNewTrait;

    protected $lang;

    public function getLang($data)
    {
        if(!isset($this->lang)){
            if(!is_array($data)){
                $arr[] = $data;
                $data = $arr;
            }
            
            $this->lang = (new TranslationLibrary())->getTranslations($data);
        }

        return $this->lang;
    }

}
