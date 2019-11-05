<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ShipmentProgressImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ShipmentProgressSheetImport(1),
            new ShipmentProgressSheetImport(2)
        ];
    }
}
