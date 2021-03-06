<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Imports\DefectImport;
use App\Imports\ProgressRateImport;
use App\Imports\ShipmentProgressImport;
use App\Imports\StockImport;
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

    public function progressRate(Request $request)
    {
        $data = $request->only(['sheetNo']);
        Excel::import(new ProgressRateImport($data['sheetNo']), request()->file('file'));
        //dd(request()->file('file'));
        return responseData(true);
    }

    public function stock(Request $request)
    {
        $data = $request->only(['sheetNo']);
        Excel::import(new StockImport($data['sheetNo']), request()->file('file'));
        return responseData(true);
    }

    public function shipmentProgress(Request $request)
    {
        $data = $request->only(['sheetNo']);
        Excel::import(new ShipmentProgressImport($data['sheetNo']), request()->file('file'));
        return responseData(true);
    }
}
