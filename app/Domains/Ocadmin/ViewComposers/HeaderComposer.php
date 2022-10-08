<?php
 
namespace App\Domains\Ocadmin\ViewComposers;
 
use Illuminate\View\View;
use Lang;

class HeaderComposer
{ 
    /**
     * Create a new sidebar composer.
     *
     * @param  ...
     * @return void
     */
    //public function __construct(UserRepository $users)
    public function __construct()
    {
        
    }
 
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Language
        $lang = (object)[];
        foreach (Lang::get('ocadmin/common/column_left') as $key => $value) {
            $lang->$key = $value;
        }
        $this->lang = $lang;        
        
        $this->authUser = auth()->user();
        $this->simUser = auth()->user();

        $view->with('authUser', $this->authUser);
        $view->with('simUser', $this->simUser);
        $view->with('base', config('config.admin_url'));
    }
}