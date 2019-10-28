<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\DistrictRepository;
use App\Repositories\GoodsCategoryRepository;
use Illuminate\Http\Request;
use App\Repositories\RegionRepository;

class CategoryController extends Controller
{
    private $goodsCategoryRepository;

    public function __construct(GoodsCategoryRepository $goodsCategoryRepository)
    {
        $this->goodsCategoryRepository = $goodsCategoryRepository;
    }

    public function list()
    {
        $list = $this->goodsCategoryRepository->all()->toArray();

        return responseData(true, ['list' => $list]);
    }
}
