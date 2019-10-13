<?php

namespace App\Http\Controllers\v1\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Admin main template
     *
     * @var string
     */
    protected $view = 'admin/main';

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->view);
    }
}
