<?php

namespace App\Domains\Admin\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    public function render($request)
    {
        return response()->view('ocadmin.errors.404', [
            'message' => $this->getMessage()
        ], 500);
    }
}
