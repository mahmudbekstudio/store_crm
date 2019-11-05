<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\GoodsRepository;
use App\Repositories\ShipmentProgressRepository;
use App\Repositories\StockRepository;
use Illuminate\Http\Request;

class ShipmentProgressController extends Controller
{
    private $shipmentProgressRepository;

    public function __construct(ShipmentProgressRepository $shipmentProgressRepository)
    {
        $this->shipmentProgressRepository = $shipmentProgressRepository;
    }

    public function list($id = 1)
    {
        $shipmentProgress = $this->shipmentProgressRepository->with(['goods'])->findWhere(['sheet_no' => $id])->toArray();
        $list = [];
        $columns = [];
        $shipment = json_decode($shipmentProgress[0]['shipment']);

        foreach($shipment as $key => $item) {
            foreach($item->columns as $subKey => $subItem) {
                $columns[] = [
                    'text' => $item->name . ' ' . $subItem,
                    'align' => 'center',
                    'value' => 'column_' . $item->values[$subKey]->index
                ];
            }
        }

        $k = 0;
        foreach ($shipmentProgress as $item) {
            $list[$k] = [
                'num' => $item['num'],
                'item' => $item['goods']['name'],
                'unit' => $item['goods']['unit'],
                'contract' => $item['contract'],
            ];
            $total = 0;
            $shipment = json_decode($item['shipment']);

            foreach($shipment as $key => $item1) {
                foreach($item1->columns as $subKey => $subItem) {
                    $list[$k]['column_' . $item1->values[$subKey]->index] = $item1->values[$subKey]->value ?? 0;
                    $total += (int)$list[$k]['column_' . $item1->values[$subKey]->index];

                    if(empty($list[$k]['column_' . $item1->values[$subKey]->index])) {
                        $list[$k]['column_' . $item1->values[$subKey]->index] = 'X';
                    }
                }
            }

            $list[$k]['total'] = $total;
            $k++;
        }

        return responseData(true, ['list' => $list, 'columns' => $columns]);
    }

    /*public function changeField(Request $request)
    {
        $data = $request->only(['id', 'key', 'val']);

        if (count($data) == 3) {
            $item = $this->stockRepository->find($data['id']);

            switch ($data['key']) {
                case 'item':
                    $regionRepository = app(GoodsRepository::class);
                    $goods = $regionRepository->find($item->goods_id);
                    $goods->name = $data['val'];
                    $goods->save();
                    break;
                case 'unit':
                    $districtRepository = app(GoodsRepository::class);
                    $goods = $districtRepository->find($item->goods_id);
                    $goods->unit = $data['val'];
                    $goods->save();
                    break;

                case 'total_a':
                    $item->total_a = $data['val'];
                    $item->save();
                    break;
                case 'total_b':
                    $item->total_b = $data['val'];
                    $item->save();
                    break;
                case 'remark':
                    $item->remark = $data['val'];
                    $item->save();
                    break;
            }
        }

        return responseData(true);
    }*/
}
