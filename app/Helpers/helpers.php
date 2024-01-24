<?php

if(!function_exists('isAdminPanel')){
    function isAdminPanel($request){
        $locales = array_keys(config('laravellocalization.supportedLocales'));
        foreach($locales as $key => $value){
            $locales[$key] = str_replace('_', '-', $value);
        }

        $firstSegment = $request->segment(1);
        $secondSegment = $request->segment(2);

        //後台
        if( $firstSegment == config('app.admin_dir') ||
            (in_array($firstSegment, $locales) && $secondSegment == config('app.admin_dir'))
        ){
            return true;
        }

        return false;
    }
}
