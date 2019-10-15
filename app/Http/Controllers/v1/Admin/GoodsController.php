<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\GoodsRepository;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    private $goodsRepository;

    public function __construct(GoodsRepository $goodsRepository)
    {
        $this->goodsRepository = $goodsRepository;
    }

    public function list()
    {
        return responseData(true, ['list' => $this->goodsRepository->all()]);
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
