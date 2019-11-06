<?php

namespace App\Imports;

use App\Models\ProgressRate;
use App\Models\ShipmentProgress;
use App\Models\Stock;
use App\Repositories\DistrictRepository;
use App\Repositories\GoodsRepository;
use App\Repositories\ProgressRateRepository;
use App\Repositories\RegionRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\ShipmentProgressRepository;
use App\Repositories\StockRepository;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ShipmentProgressSheetImport implements ToCollection
{
    private $sheet_no;
    public function __construct($sheet_no)
    {
        $this->sheet_no = $sheet_no;
    }

    public function collection(Collection $rows)
    {
        $shipments = [];
        $shipmentK = -1;
        $lastShipment = '';
        $lastColumn = '';
        for($i = 4; $i <= count($rows[3]); $i++) {
            if($rows[3][$i] === 'Total') break;
            if(!empty($rows[3][$i])) {
                if(!empty($lastShipment)) {
                    $shipments[$shipmentK]['quantity'] = 0;
                }

                $lastShipment = $rows[3][$i];
                $shipmentK++;
                $shipments[$shipmentK]['name'] = $lastShipment;
                $shipments[$shipmentK]['columns'] = [];
                $shipments[$shipmentK]['dates'] = [];
                $shipments[$shipmentK]['values'] = [];
            }

            $date = !empty($rows[5][$i]) ? date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rows[5][$i])->getTimestamp()) : '';
            $shipments[$shipmentK]['dates'][] = $date;
            $shipments[$shipmentK]['columns'][] = ($rows[4][$i] ?? $lastColumn) . ' ' . $date;
            $lastColumn = $rows[4][$i];
            $shipments[$shipmentK]['values'][] = [
                'value' => '',
                'index' => $i
            ];
        }

        ShipmentProgress::where('sheet_no', '=', $this->sheet_no)->delete();
        $shipmentProgressRepository = app(ShipmentProgressRepository::class);
        $goodsRepository = app(GoodsRepository::class);

        for($i = 6; $i <= count($rows); $i++) {
            if(!isset($rows[$i])) break;
            $item = $rows[$i]->toArray();
            if(empty($item[1])) break;
            $goods = $goodsRepository->firstOrCreate(['name' => $item[1]]);

            if($goods->unit != $item[2]) {
                $goods->unit = $item[2];
                $goods->save();
            }

            for($j = 0; $j < count($shipments); $j++) {
                for($k = 0; $k < count($shipments[$j]['values']); $k++) {
                    $shipments[$j]['values'][$k]['value'] = $item[$shipments[$j]['values'][$k]['index']] ?? '';
                    $shipments[$j]['values'][$k]['value'] = $this->checkField(str_replace('=', '', $shipments[$j]['values'][$k]['value']));
                }
            }

            $item[3] = $item[3] ?? '';
            $shipmentProgressRepository->create([
                'user_id' => auth()->user()->id,
                'sheet_no' => $this->sheet_no,
                'num' => $item[0] ?? '',
                'goods_id' => $goods->id,
                'contract' => $this->checkField(str_replace('=', '', $item[3])),
                'shipment' => json_encode($shipments),
            ]);
        }
    }

    private function checkField($val)
    {
        $op = '+';
        $valArr = explode('+', $val);

        if(count($valArr) == 1) {
            $op = '-';
            $valArr = explode('-', $val);
        }

        if(count($valArr) == 1) {
            return $val;
        }

        if($op == '+') {
            return $valArr[0] + $valArr[1];
        }

        return $valArr[0] - $valArr[1];
    }
}
