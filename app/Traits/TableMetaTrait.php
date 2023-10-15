<?php

namespace App\Traits;
use Illuminate\Database\Query\Builder;

trait TableMetaTrait
{
    // public function translation($locale = null, $metaModelName = null)
    // {
    //     if(empty($locale)){
    //         $locale = app()->getLocale();
    //     }

    //     if(empty($metaModelName)){
    //         $metaModelName = get_class($this) . 'Meta';
    //         $metaModel = new $metaModelName();
    //     }
    //     $master_key = $metaModel->master_key ?? $this->getForeignKey();

    //     return $this->hasMany($metaModel::class, $master_key, 'id')->where('locale', $locale);
    // }

    public function translation()
    {
        $locale = app()->getLocale();
        return $this->metas()->where('locale', $locale);
    }

    public function translations()
    {
        // //return $this->metas()->whereNotNull('locale');
        // $xx = $this->metas()->whereNotNull('locale');
        // $rows = $xx->get();

        // foreach ($rows as $row) {
        //     $locale = $row->locale;
        //     $column = $row->meta_key;
        //     $value = $row->meta_value;
        //     $arr[$locale][] = [
        //         $column => $value,
        //     ];
        // }
        // //echo '<pre>', print_r($arr, 1), "</pre>"; exit;
        // $this->translations = $arr;
        // // echo '<pre>', print_r($yy, 1), "</pre>"; exit;
        return $this->metas()->whereNotNull('locale');
    }

}