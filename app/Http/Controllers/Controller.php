<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Libraries\TranslationLibrary;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $lang;

    public function __construct()
    {
        if (basename($_SERVER['SCRIPT_NAME']) == 'artisan') {
            return null;
        }
    }
    
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
