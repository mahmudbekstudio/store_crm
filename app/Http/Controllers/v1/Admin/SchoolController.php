<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\DistrictRepository;
use App\Repositories\RegionRepository;
use App\Repositories\SchoolRepository;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    private $schoolRepository;
    private $districtRepository;

    public function __construct(SchoolRepository $schoolRepository, DistrictRepository $districtRepository)
    {
        $this->schoolRepository = $schoolRepository;
        $this->districtRepository = $districtRepository;
    }

    public function list()
    {
        $list = [];
        $districts = [];
        $this->districtRepository->all()->map(function($item) use(&$districts) {
            $districts[$item->id] = $item->name;
        });

        $this->schoolRepository->all()->map(function($item) use(&$list, $districts) {
            $list[] = ['id' => $item->id, 'name' => $item->name, 'district' => $districts[$item->district_id] ?? ''];
        });

        return responseData(true, ['list' => $list]);
    }

    public function add(Request $request)
    {
        $data = $request->only(['name', 'region_id']);
        $this->schoolRepository->create(['user_id' => auth()->user()->id, 'name' => $data['name'], 'region_id' => $data['region_id']]);
        return responseData(true);
    }

    public function item($id)
    {
        return responseData(true, ['item' => $this->schoolRepository->find($id), 'district' => $this->districtRepository->all()]);
    }

    public function edit($id, Request $request)
    {
        $data = $request->only(['name', 'region_id']);
        $this->schoolRepository->update($data, $id);
        return responseData(true);
    }

    public function delete($id)
    {
        $this->schoolRepository->delete($id);
        return responseData(true);
    }
}
