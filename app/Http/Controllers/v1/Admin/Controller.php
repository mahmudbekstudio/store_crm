<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller as MainController;

class Controller extends MainController
{
    public function response($data)
    {
        return response()->json($data);
    }
}