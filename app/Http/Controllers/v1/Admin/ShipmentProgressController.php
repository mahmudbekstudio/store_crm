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
        $editColumns = [];
        if(count($shipmentProgress) == 0) {
            return responseData(true, ['list' => $list, 'columns' => $columns]);
        }
        $shipment = json_decode($shipmentProgress[0]['shipment']);
        $k = 0;

        foreach($shipment as $key => $item) {
            $editColumns[$k] = [
                'shipment' => ['index' => $key, 'name' => $item->name],
                'columns' => []
            ];
            foreach($item->columns as $subKey => $subItem) {
                $columns[] = [
                    'text' => $subItem,
                    'align' => 'center',
                    'width' => '115px',
                    'sortable' => false,
                    'value' => 'column_' . $item->values[$subKey]->index
                ];

                $editColumns[$k]['columns'][] = [
                    'text' => $subItem,
                    'value' => $item->values[$subKey]->index
                ];
            }
            $k++;
        }

        $k = 0;

        $list[$k] = [
            'no' => '',
            'id' => 0,
            'num' => '',
            'item' => '',
            'unit' => '',
            'contract' => '',
        ];

        foreach($shipment as $key => $item1) {
            foreach($item1->columns as $subKey => $subItem) {
                $list[$k]['column_' . $item1->values[$subKey]->index] = $subItem;
            }
        }

        $list[$k]['total'] = '';
        $list[$k]['balance'] = '';

        $k++;

        $list[$k] = [
            'no' => '',
            'id' => -1,
            'num' => '',
            'item' => '',
            'unit' => '',
            'contract' => '',
        ];

        foreach($shipment as $key => $item1) {
            foreach($item1->columns as $subKey => $subItem) {
                $list[$k]['column_' . $item1->values[$subKey]->index] = $item1->dates[$subKey];
            }
        }

        $k++;
        foreach ($shipmentProgress as $item) {
            $list[$k] = [
                'no' => $k - 1,
                'id' => $item['id'],
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
                        $list[$k]['column_' . $item1->values[$subKey]->index] = '';
                    }
                }
            }

            $contract = $item['contract'] ?? 0;
            $list[$k]['total'] = $total;
            $list[$k]['balance'] = (int)$contract - (int)$total;
            $k++;
        }

        return responseData(true, ['list' => $list, 'columns' => $columns, 'editColumns' => $editColumns]);
    }

    public function changeField(Request $request)
    {
        $data = $request->only(['id', 'key', 'val', 'sheep_no']);

        if (count($data) >= 3) {
            if($data['id'] == -1) {
                $keyArr = explode('_', $data['key']);
                $keyName = $keyArr[0];

                if(count($keyArr) == 2 && $keyName == 'column') {
                    $keyId = $keyArr[1];
                    $item = $this->shipmentProgressRepository->findWhere(['sheet_no' => $data['sheep_no']])->first();
                    $obj = json_decode($item->shipment, true);

                    foreach($obj as $key1 => $val) {
                        foreach($val['values'] as $valKey => $valVal) {
                            if($valVal['index'] == $keyId) {
                                $obj[$key1]['dates'][$valKey] = $data['val'];
                            }
                        }
                    }

                    $item->shipment = json_encode($obj);

                    $item->save();
                }

                return responseData(true);
            }
            if($data['id'] == 0) {
                $shipmentProgress = $this->shipmentProgressRepository->findWhere(['sheet_no' => $data['sheep_no']]);
                $key = str_replace('column_', '', $data['key']);
                $shipmentItem = $shipmentProgress->first();
                $item = $shipmentItem->toArray();
                $item['shipment'] = json_decode($item['shipment'], true);
                foreach($item['shipment'] as $key1 => $val) {
                    foreach($val['values'] as $valKey => $valVal) {
                        if($valVal['index'] == $key) {
                            $item['shipment'][$key1]['columns'][$valKey] = $data['val'];
                        }
                    }
                }

                $shipmentItem->shipment = json_encode($item['shipment']);
                $shipmentItem->save();

                return responseData(true);
            }
            $item = $this->shipmentProgressRepository->find($data['id']);

            switch ($data['key']) {
                case 'num':
                    $item->tonumtal_a = $data['val'];
                    $item->save();
                    break;
                case 'item':
                    $regionRepository = app(GoodsRepository::class);
                    $goods = $regionRepository->find($item->goods_id);

                    if(count($this->shipmentProgressRepository->findWhere(['goods_id' => $item->goods_id, 'sheet_no' => $data['sheep_no']])->toArray()) > 1) {
                        $region = $regionRepository->withUser()->firstOrCreate([
                            'goods_category_id' => $goods->goods_category_id,
                            'name' => $data['val'],
                            'unit' => $goods->unit
                        ]);
                        $item->goods_id = $region->id;
                        $item->save();
                    } else {
                        $goods->name = $data['val'];
                        $goods->save();
                    }
                    break;
                case 'unit':
                    $districtRepository = app(GoodsRepository::class);
                    $goods = $districtRepository->find($item->goods_id);

                    if(count($this->shipmentProgressRepository->findWhere(['goods_id' => $item->goods_id, 'sheet_no' => $data['sheep_no']])->toArray()) > 1) {
                        $region = $districtRepository->withUser()->firstOrCreate([
                            'goods_category_id' => $goods->goods_category_id,
                            'name' => $goods->name,
                            'unit' => $data['val']
                        ]);
                        $item->goods_id = $region->id;
                        $item->save();
                    } else {
                        $goods->unit = $data['val'];
                        $goods->save();
                    }
                    break;
                case 'contract':
                    $item->contract = $data['val'];
                    $item->save();
                    break;
            }

            if(substr($data['key'], 0, 7) === 'column_') {
                $shipment = json_decode($item->shipment);
                $no = explode('_', $data['key'])[1];
                $found = false;

                foreach($shipment as $shipmentKey => $shipmentItem) {
                    foreach($shipmentItem->values as $shipmentItemKey => $shipmentItemItem) {
                        if($shipmentItemItem->index == $no) {
                            $shipment{$shipmentKey}->values{$shipmentItemKey}->value = $data['val'];
                            break;
                            $found = true;
                        }
                    }

                    if($found) {
                        break;
                    }
                }

                $item->shipment = json_encode($shipment);
                $item->save();
            }
        }

        return responseData(true);
    }

    public function addRecord(Request $request)
    {
        $data = $request->only(['list', 'sheep_no']);
        $shipmentProgressRepository = app(ShipmentProgressRepository::class);
        $firstItem = $shipmentProgressRepository->findWhere(['sheet_no' => $data['sheep_no']])[0]->toArray();
        $shipment = json_decode($firstItem['shipment'], true);
        $listIndex = 0;
        foreach($shipment as $shipKey => $shipItem) {
            foreach($shipItem['columns'] as $columnKey => $columnVal) {
                for($i = $listIndex; $i < count($data['list']); $i++) {
                    if($data['list'][$i]['label'] == $columnVal) {
                        $shipment[$shipKey]['values'][$columnKey]['value'] = $data['list'][$i]['value'];
                        $listIndex = $i;
                        break;
                    }
                }
            }
        }

        $goodsRepository = app(GoodsRepository::class);
        $goods = $goodsRepository->firstOrCreate(['name' => $data['list'][0]['value']]);

        if($goods->unit != $data['list'][1]['value']) {
            $goods->unit = $data['list'][1]['value'];
            $goods->save();
        }

        $shipmentProgressRepository->create([
            'user_id' => auth()->user()->id,
            'sheet_no' => $data['sheep_no'],
            'num' => '',
            'goods_id' => $goods->id,
            'contract' => $data['list'][2]['value'],
            'shipment' => json_encode($shipment),
        ]);

        return responseData(true);
    }

    public function changeColumn(Request $request)
    {
        $data = $request->only(['list', 'sheep_no']);

        $shipmentProgress = $this->shipmentProgressRepository->with(['goods'])->findWhere(['sheet_no' => $data['sheep_no']]);

        foreach ($shipmentProgress as $item) {
            $shipment = json_decode($item->shipment);
            $result = [];

            $columns = [];
            $dates = [];
            $values = [];
            $lastIndex = 0;
            foreach($shipment as $key => $item1) {
                foreach($item1->values as $subKey => $subItem) {
                    $columns[$subItem->index] = $item1->columns[$subKey];
                    $values[$subItem->index] = $subItem->value;
                    $dates[$subItem->index] = $item1->dates[$subKey];

                    if($lastIndex < $subItem->index) {
                        $lastIndex = $subItem->index;
                    }
                }
            }

            $result[0] = [
                'name' => '',
                'columns' => [],
                'dates' => [],
                'values' => [],
                'quantity' => 0
            ];

            foreach($data['list'] as $listItem) {
                $index = str_replace('column_', '', $listItem['value']);
                if(!isset($values[$index])) {
                    $lastIndex++;
                    $index = $lastIndex;
                }
                $result[0]['columns'][] = $listItem['text'];
                $result[0]['dates'][] = $dates[$index] ?? '';
                $result[0]['values'][] = ['value' => $values[$index] ?? '', 'index' => $index];//$values[$index] ?? '';//{"value":"","index":4},
            }

            $item->shipment = json_encode($result);
            $item->save();
        }

        return responseData(true);
    }
}
