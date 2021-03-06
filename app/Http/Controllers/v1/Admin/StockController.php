<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\GoodsRepository;
use App\Repositories\StockRepository;
use Illuminate\Http\Request;

class StockController extends Controller
{
    private $stockRepository;

    public function __construct(StockRepository $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    public function list()
    {
        $stocks = $this->stockRepository->with(['goods'])->all()->toArray();
        $list = [];
        $goodsList = [];

        foreach ($stocks as $item) {
            if (empty($goodsList[$item['goods_id']])) {
                $goodsList[$item['goods_id']] = [];
            }

            if (empty($goodsList[$item['goods_id']]['total'])) {
                $goodsList[$item['goods_id']]['total'] = [];
            }

            if (empty($goodsList[$item['goods_id']]['total'][$item['wh_no']])) {
                $goodsList[$item['goods_id']][$item['wh_no']] = [];
                $goodsList[$item['goods_id']]['total'][$item['wh_no']]['in'] = 0;
                $goodsList[$item['goods_id']]['total'][$item['wh_no']]['out'] = 0;
            }

            $goodsList[$item['goods_id']]['id'] = $item['id'];
            $goodsList[$item['goods_id']]['item'] = $item['goods']['name'];
            $goodsList[$item['goods_id']]['unit'] = $item['goods']['unit'];
            $goodsList[$item['goods_id']]['total'][$item['wh_no']]['in'] += (int)$item['in_total'];
            $goodsList[$item['goods_id']]['total'][$item['wh_no']]['out'] += (int)$item['out_total'];
        }


        $resList = [];
        $k = 0;
        foreach ($goodsList as $goodsId => $goods) {
            $k++;
            $resList[$goodsId] = [
                'id' => $k,
                'item' => $goods['item'],
                'unit' => $goods['unit']
            ];
            $total = 0;
            foreach ($goods['total'] as $wh_no => $item) {
                $resList[$goodsId]['wh_0' . $wh_no . '_in'] = $item['in'];
                $resList[$goodsId]['wh_0' . $wh_no . '_out'] = $item['out'];
                $resList[$goodsId]['wh_0' . $wh_no . '_total_ab'] = $item['in'] - $item['out'];
                $total += $resList[$goodsId]['wh_0' . $wh_no . '_total_ab'];
            }

            $resList[$goodsId]['total_stock'] = $total;
        }

        foreach ($resList as $item) {
            $list[] = $item;
        }

        /*$list[] = [
            'id' => $item['id'],
            'item' => $item['goods']['name'],
            'unit' => $item['goods']['unit'],
            'wh_01_in',
            'wh_01_out',
            'wh_01_total_ab',

            'wh_02_in',
            'wh_02_out',
            'wh_02_total_ab',

            'wh_03_in',
            'wh_03_out',
            'wh_03_total_ab',

            'wh_04_in',
            'wh_04_out',
            'wh_04_total_ab',

            'wh_05_in',
            'wh_05_out',
            'wh_05_total_ab',

            'wh_06_in',
            'wh_06_out',
            'wh_06_total_ab',

            'wh_07_in',
            'wh_07_out',
            'wh_07_total_ab',
        ];*/

        return responseData(true, ['list' => $list]);
    }

    public function details($id)
    {
        $stocks = $this->stockRepository->with(['goods'])->findWhere(['wh_no' => $id])->toArray();
        $list = [];
        $columns = [];

        if (empty($stocks)) {
            return responseData(true, ['list' => $list, 'columns' => $columns]);
        }

        $columns['in'] = [];
        $columns['out'] = [];
        $inObj = json_decode($stocks[0]['in_obj'], true);
        $outObj = json_decode($stocks[0]['out_obj'], true);

        $k = 0;

        $list[$k] = [
            'no' => '',
            'id' => 0,
            'item' => '',
            'unit' => '',
        ];

        foreach ($inObj as $key => $item) {
            if(!isset($item['name'])) continue;
            $columns['in'][] = [
                'text' => $item['name']/* . ' ' . $item['date']*/,
                'align' => 'center',
                'value' => 'in_column_' . $key
            ];

            $list[$k]['in_column_' . $key] = $item['name'];
        }

        $list[$k]['in_total_a'] = '';

        foreach ($outObj as $key => $item) {
            if(!isset($item['name'])) continue;
            $columns['out'][] = [
                'text' => $item['name']/* . ' ' . $item['date']*/,
                'align' => 'center',
                'width' => '115px',
                'value' => 'out_column_' . $key,
                'sortable' => false
            ];

            $list[$k]['out_column_' . $key] = $item['name'];
        }

        $list[$k]['in_total_b'] = '';
        $list[$k]['remark'] = '';

        $k++;

        $list[$k] = [
            'no' => '',
            'id' => -1,
            'item' => '',
            'unit' => '',
        ];

        foreach ($inObj as $key => $item) {
            if(!isset($item['name'])) continue;
            $list[$k]['in_column_' . $key] = $item['date'];
        }

        foreach ($outObj as $key => $item) {
            if(!isset($item['name'])) continue;
            $list[$k]['out_column_' . $key] = $item['date'];
        }

        $k++;
        foreach ($stocks as $item) {
            $inObj = json_decode($item['in_obj']);
            $outObj = json_decode($item['out_obj']);
            $list[$k] = [
                'no' => $k - 1,
                'id' => $item['id'],
                'item' => $item['goods']['name'],
                'unit' => $item['goods']['unit'],
            ];

            foreach ($inObj as $key => $subItem) {
                $list[$k]['in_column_' . $key] = $subItem->value ?? '';
            }
            $item['in_total'] = is_int((int)$item['in_total']) ? $item['in_total'] : 0;
            $list[$k]['total_a'] = (int)$item['in_total'] ?: 0;

            foreach ($outObj as $key => $subItem) {
                $list[$k]['out_column_' . $key] = $subItem->value ?? '';
            }
            $item['out_total'] = is_int((int)$item['out_total']) ? $item['out_total'] : 0;
            $list[$k]['total_b'] = (int)$item['out_total'] ?: 0;

            $list[$k]['total_a'] = is_int($list[$k]['total_a']) ? $list[$k]['total_a'] : 0;
            $list[$k]['total_b'] = is_int($list[$k]['total_b']) ? $list[$k]['total_b'] : 0;
            $list[$k]['total_ab'] = $list[$k]['total_a'] - $list[$k]['total_b'];
            $list[$k]['remark'] = $item['remark'] ?? '';
            $k++;
        }

        return responseData(true, ['list' => $list, 'columns' => $columns]);
    }

    public function changeColumn(Request $request)
    {
        $data = $request->only(['list', 'wh_no', 'isIn']);
        $stocks = $this->stockRepository->with(['goods'])->findWhere(['wh_no' => $data['wh_no']]);
        $result = [];

        foreach($stocks as $item) {
            $obj = $data['isIn'] ? json_decode($item->in_obj, true) : json_decode($item->out_obj, true);
            $lastIndex = 0;

            foreach($obj as $key => $val) {
                if($lastIndex < $key) {
                    $lastIndex = $key;
                }
            }

            foreach($data['list'] as $listItem) {
                $index = str_replace(($data['isIn'] ? 'in_column_' : 'out_column_'), '', $listItem['value']);

                if(!isset($obj[$index])) {
                    $lastIndex++;
                    $index = $lastIndex;
                    $obj[$index] = [
                        'name' => '',
                        'date' => '',
                        'value' => ''
                    ];
                }

                $result[$index] = $obj[$index];
                $result[$index]['name'] = $listItem['text'];
            }

            if($data['isIn']) {
                $item->in_obj = json_encode($result);
            } else {
                $item->out_obj = json_encode($result);
            }

            $item->save();
        }

        return responseData(true);
    }

    public function changeField(Request $request)
    {
        $data = $request->only(['id', 'key', 'val', 'no']);

        if (count($data) >= 3) {
            if($data['id'] == -1) {
                $keyArr = explode('_', $data['key']);
                $keyName = $keyArr[0];

                if(count($keyArr) == 3 && in_array($keyName, ['in', 'out'])) {
                    $keyId = $keyArr[2];
                    $item = $this->stockRepository->findWhere(['wh_no' => $data['no']])->first();

                    if($keyName == 'in') {
                        $obj = json_decode($item->in_obj, true);
                        $obj[$keyId]['date'] = $data['val'];
                        $item->in_obj = json_encode($obj);
                    } elseif($keyName == 'out') {
                        $obj = json_decode($item->out_obj, true);
                        $obj[$keyId]['date'] = $data['val'];
                        $item->out_obj = json_encode($obj);
                    }

                    $item->save();
                }

                return responseData(true);
            }
            if($data['id'] == 0) {
                $stock = $this->stockRepository->findWhere(['wh_no' => $data['no']]);
                $itemObj = $stock->first();
                $item = $itemObj->toArray();

                if(substr($data['key'], 0, 2) === 'in') {
                    $key = str_replace('in_column_', '', $data['key']);
                    $item['in_obj'] = json_decode($item['in_obj'], true);
                    $item['in_obj'][$key]['name'] = $data['val'];
                    $itemObj->in_obj = json_encode($item['in_obj']);
                } elseif(substr($data['key'], 0, 3) === 'out') {
                    $key = str_replace('out_column_', '', $data['key']);
                    $item['out_obj'] = json_decode($item['out_obj'], true);
                    $item['out_obj'][$key]['name'] = $data['val'];
                    $itemObj->out_obj = json_encode($item['out_obj']);
                }
                $itemObj->save();
                return responseData(true);
            }
            $item = $this->stockRepository->find($data['id']);

            switch ($data['key']) {
                case 'item':
                    $regionRepository = app(GoodsRepository::class);
                    $goods = $regionRepository->find($item->goods_id);

                    if(count($this->stockRepository->findWhere(['goods_id' => $item->goods_id, 'wh_no' => $data['no']])->toArray()) > 1) {
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

                    if(count($this->stockRepository->findWhere(['goods_id' => $item->goods_id, 'wh_no' => $data['no']])->toArray()) > 1) {
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

                /*case 'total_a':
                    $item->in_total = $data['val'];
                    $item->save();
                    break;
                case 'total_b':
                    $item->out_total = $data['val'];
                    $item->save();
                    break;*/
                case 'remark':
                    $item->remark = $data['val'];
                    $item->save();
                    break;
            }

            if (substr($data['key'], 0, 10) === 'in_column_') {
                $in_obj = json_decode($item->in_obj, true);
                $keyArr = explode('_', $data['key']);
                $no = $keyArr[count($keyArr) - 1];
                $in_obj[$no]['value'] = $data['val'];

                $inTotal = 0;
                foreach($in_obj as $inItem) {
                    $val = $inItem['value'] > 0 ? $inItem['value'] : 0;
                    $inTotal += $val;
                }
                $item->in_total = $inTotal;

                $item->in_obj = json_encode($in_obj);
                $item->save();
            }

            if (substr($data['key'], 0, 11) === 'out_column_') {
                $out_obj = json_decode($item->out_obj, true);
                $keyArr = explode('_', $data['key']);
                $no = $keyArr[count($keyArr) - 1];
                $out_obj[$no]['value'] = $data['val'];

                $outTotal = 0;
                foreach($out_obj as $outItem) {
                    $val = $outItem['value'] > 0 ? $outItem['value'] : 0;
                    $outTotal += $val;
                }
                $item->out_total = $outTotal;

                $item->out_obj = json_encode($out_obj);
                $item->save();
            }
        }

        return responseData(true);
    }

    public function addRecord(Request $request)
    {
        $data = $request->only(['list', 'wh_no']);
        $goodsRepository = app(GoodsRepository::class);
        $stockRepository = app(StockRepository::class);
        $goods = $this->stockRepository->with(['goods'])->findWhere(['wh_no' => $data['wh_no']])->toArray();
        $inObj = [];
        $outObj = [];
        if(!empty($goods)) {
            $stockItem = $goods[0];
            $inObj = json_decode($stockItem['in_obj'], true);
            $outObj = json_decode($stockItem['out_obj'], true);
            $listIndex = 0;
            $inTotal = 0;
            $outTotal = 0;

            foreach($inObj as $objKey => $objItem) {
                for($i = $listIndex; $i < count($data['list']); $i++) {
                    if($data['list'][$i]['label'] == $objItem['name']) {
                        $inObj[$objKey]['value'] = $data['list'][$i]['value'];
                        $listIndex = $i;
                        $inTotal += !empty($inObj[$objKey]['value']) ? (int)$inObj[$objKey]['value'] : 0;
                        break;
                    }
                }
            }

            foreach($outObj as $objKey => $objItem) {
                for($i = $listIndex; $i < count($data['list']); $i++) {
                    if($data['list'][$i]['label'] == $objItem['name']) {
                        $outObj[$objKey]['value'] = $data['list'][$i]['value'];
                        $listIndex = $i;
                        $outTotal += !empty($outObj[$objKey]['value']) ? (int)$outObj[$objKey]['value'] : 0;
                        break;
                    }
                }
            }
        }

        $goods = $goodsRepository->firstOrCreate(['name' => $data['list'][0]['value']]);

        if($goods->unit != $data['list'][1]['value']) {
            $goods->unit = $data['list'][1]['value'];
            $goods->save();
        }

        $stockRepository->create([
            'user_id' => auth()->user()->id,
            'goods_id' => $goods->id,
            'wh_no' => $data['wh_no'],
            'in_obj' => json_encode($inObj),
            'out_obj' => json_encode($outObj),
            'in_total' => 0,
            'out_total' => 0,
            'remark' => ''//$data['list'][count($data['list']) - 1]['value']
        ]);
        return responseData(true);
    }
}
