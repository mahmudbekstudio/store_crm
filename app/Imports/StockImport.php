<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StockImport implements WithMultipleSheets
{
    private $sheetNo;
    public function __construct($sheetNo)
    {
        $this->sheetNo = $sheetNo;
    }

    public function sheets(): array
    {
        return [
            new StockSheetImport($this->sheetNo)
        ];
    }
}
