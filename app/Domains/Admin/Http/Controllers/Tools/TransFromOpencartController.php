<?php

namespace App\Domains\Admin\Http\Controllers\Tools;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\Admin\Traits\MenuTrait;

class TransFromOpencartController extends Controller
{
    use MenuTrait;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getForm()
    {
        $data['menus'] = $this->getMenus();
        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');
        
        return view('ocadmin.tools.trans_from_opencart', $data);
    }


    public function update(Request $request)
    {
        if(!empty($request->post('transText'))){
            $transText = str_replace("\r", '', $request->post('transText'));
            $transText = explode("\n", $transText);

            $new[] = "<?php\n\n return [";
            foreach ($transText as $value) {
                $value = trim($value);
                if(strstr($value, '//')){
                    $new[] = $value;
                }else if(strstr($value, '$_')){
                    // https://www.phpliveregex.com/
                    preg_match('"\\$_\\[\\\'(.*)\\\'\\]\\s+\\=\\s*\\\'(.*)\\\'"', $value, $matches);
                    $new_str = "'".$matches[1]."'";
                    $length = strlen($new_str);
                    $c = 40 - $length;
                    $spaces = '';
                    for ($i=0; $i < $c; $i++) {
                        $spaces .= ' ';
                    }
                    $new[] = $new_str . $spaces . "=> '".$matches[2]."',";
                }
            }
            $transText = implode("\n", $new) . "\n]";
            $data['transText'] = $transText;
        }
        $data['menus'] = $this->getMenus();
        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');
        
        return view('ocadmin.tools.trans_from_opencart', $data);
    }
}
