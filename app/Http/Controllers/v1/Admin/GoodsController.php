<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\GoodsCategoryRepository;
use App\Repositories\GoodsRepository;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    private $goodsRepository;
    private $goodsCategoryRepository;

    public function __construct(GoodsRepository $goodsRepository, GoodsCategoryRepository $goodsCategoryRepository)
    {
        $this->goodsRepository = $goodsRepository;
        $this->goodsCategoryRepository = $goodsCategoryRepository;
    }

    public function list()
    {
        $categories = [];
        $goodsCat = $this->goodsCategoryRepository->all();

        foreach($goodsCat as $item) {
            $categories[$item->id] = $item->name;
        }

        $list = $this->goodsRepository->all()->toArray();
        for($i = 0; $i < count($list); $i++) {
            $list[$i]['category'] = $categories[$list[$i]['id']];
        }

        return responseData(true, ['list' => $list]);
    }

    public function add(Request $request)
    {
        $data = $request->only(['name']);
        $this->goodsRepository->create(['user_id' => auth()->user()->id, 'name' => $data['name']]);
        return responseData(true);
    }

    public function item($id)
    {
        return responseData(true, ['item' => $this->goodsRepository->find($id)]);
    }

    public function edit($id, Request $request)
    {
        $data = $request->only(['name']);
        $this->goodsRepository->update($data, $id);
        return responseData(true);
    }

    public function delete($id)
    {
        $this->goodsRepository->delete($id);
        return responseData(true);
    }
}
