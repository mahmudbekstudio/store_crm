<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StockImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            null,
            new StockSheetImport(1),
            new StockSheetImport(2),
            new StockSheetImport(3),
            new StockSheetImport(4),
            new StockSheetImport(5),
            new StockSheetImport(6),
            new StockSheetImport(7),
            /*new StockSheetImport(8),
            new StockSheetImport(9),
            new StockSheetImport(10)*/
        ];
    }
}
