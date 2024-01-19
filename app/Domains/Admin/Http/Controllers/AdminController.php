<?php

namespace App\Domains\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\TranslationLibrary;

class AdminController extends Controller
{
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