<?php

namespace App\Imports;

use App\Models\ProgressRate;
use App\Models\Stock;
use App\Repositories\DistrictRepository;
use App\Repositories\GoodsRepository;
use App\Repositories\ProgressRateRepository;
use App\Repositories\RegionRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\StockRepository;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class StockSheetImport implements ToCollection
{
    private $whNo;
    public function __construct($whNo)
    {
        $this->whNo = $whNo;
    }

    public function collection(Collection $rows)
    {
        Stock::where('wh_no', '=', $this->whNo)->delete();
        $rowsCount = count($rows);
        $goodsRepository = app(GoodsRepository::class);
        $stockRepository = app(StockRepository::class);
        $inTotalIndex = 0;
        $outTotalIndex = 0;
        $totalStr = 'Total';

        for($j = 3; $j < count($rows[5]); $j++) {
            if($inTotalIndex && !$outTotalIndex && substr($rows[5][$j], 0, strlen($totalStr)) === $totalStr) {
                $outTotalIndex = $j;
                break;
            }

            if(!$inTotalIndex && substr($rows[5][$j], 0, strlen($totalStr)) === $totalStr) {
                $inTotalIndex = $j;
            }
        }

        $inObj = [];
        for($i = 3; $i < $inTotalIndex; $i++) {
            $inObj[$i] = [
                'name' => $rows[5][$i],
                'date' => !empty($rows[6][$i]) ? date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rows[6][$i])->getTimestamp()) : '',
                'value' => ''
            ];
        }

        $outObj = [];
        for($i = ($inTotalIndex + 1); $i < $outTotalIndex; $i++) {
            $outObj[$i] = [
                'name' => $rows[5][$i],
                'date' => !empty($rows[6][$i]) ? date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rows[6][$i])->getTimestamp()) : '',
                'value' => ''
            ];
        }

        for($i = 7; $i < $rowsCount; $i++) {
            $item = $rows[$i]->toArray();
            if(empty($item[1]) || empty($item[2])) {
                break;
            }
            $goods = $goodsRepository->firstOrCreate(['name' => $item[1]]);

            if($goods->unit != $item[2]) {
                $goods->unit = $item[2];
                $goods->save();
            }

            $inTotal = 0;
            $outTotal = 0;

            for($j = 3; $j < $inTotalIndex; $j++) {
                $inObj[$j]['value'] = $item[$j];
                $inTotal += !empty($item[$j]) ? (int)$item[$j] : 0;
            }

            for($j = ($inTotalIndex + 1); $j < $outTotalIndex; $j++) {
                $outObj[$j]['value'] = $item[$j];
                $outTotal += !empty($item[$j]) ? (int)$item[$j] : 0;
            }

            $stockRepository->create([
                'user_id' => auth()->user()->id,
                'goods_id' => $goods->id,
                'wh_no' => $this->whNo,
                'in_obj' => json_encode($inObj),
                'out_obj' => json_encode($outObj),
                'in_total' => $inTotal,
                'out_total' => $outTotal,
                'remark' => $item[$outTotalIndex + 2] ?? ''
            ]);
        }
    }
}
