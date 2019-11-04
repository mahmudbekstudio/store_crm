<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
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
            if(empty($goodsList[$item['goods_id']])) {
                $goodsList[$item['goods_id']] = [];
            }

            if(empty($goodsList[$item['goods_id']]['total'])) {
                $goodsList[$item['goods_id']]['total'] = [];
            }

            if(empty($goodsList[$item['goods_id']]['total'][$item['wh_no']])) {
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
        foreach($goodsList as $goodsId => $goods) {
            $k++;
            $resList[$goodsId] = [
                'id' => $k,
                'item' => $goods['item'],
                'unit' => $goods['unit']
            ];
            $total = 0;
            foreach($goods['total'] as $wh_no => $item) {
                $resList[$goodsId]['wh_0' . $wh_no . '_in'] = $item['in'];
                $resList[$goodsId]['wh_0' . $wh_no . '_out'] = $item['out'];
                $resList[$goodsId]['wh_0' . $wh_no . '_total_ab'] = $item['in'] - $item['out'];
                $total += $resList[$goodsId]['wh_0' . $wh_no . '_total_ab'];
            }

            $resList[$goodsId]['total_stock'] = $total;
        }

        foreach($resList as $item) {
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

    public function details()
    {
        $stocks = $this->stockRepository->with(['goods'])->all()->toArray();
        $list = [];
        $columns = [];
        $columns['in'] = [];
        $columns['out'] = [];
        $inObj = json_decode($stocks[0]['in_obj']);
        $outObj = json_decode($stocks[0]['out_obj']);

        foreach($inObj as $key => $item) {
            $columns['in'][] = [
                'text' => $item->name . ' ' . $item->date,
                'align' => 'center',
                'value' => 'in_column_' . $key
            ];
        }

        foreach($outObj as $key => $item) {
            $columns['out'][] = [
                'text' => $item->name . ' ' . $item->date,
                'align' => 'center',
                'value' => 'out_column_' . $key
            ];
        }

        foreach ($stocks as $item) {
            $list[] = [
                'id' => $stocks['id'],
                'item',
                'unit'
            ];
        }

        return responseData(true, ['list' => $list, 'columns' => $columns]);
    }
}
