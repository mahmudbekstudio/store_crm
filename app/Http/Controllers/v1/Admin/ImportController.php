<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Imports\DefectImport;
use App\Models\Region;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function defect(Request $request)
    {
        Excel::import(new DefectImport, request()->file('file'));
        //dd(request()->file('file'));
        return responseData(true);
    }
}
