<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\RegionRepository;
use App\Repositories\SchoolRepository;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    private $schoolRepository;
    private $regionRepository;

    public function __construct(SchoolRepository $schoolRepository, RegionRepository $regionRepository)
    {
        $this->schoolRepository = $schoolRepository;
        $this->regionRepository = $regionRepository;
    }

    public function list()
    {
        $list = [];
        $regions = [];
        $this->regionRepository->all()->map(function($item) use(&$regions) {
            $regions[$item->id] = $item->name;
        });

        $this->schoolRepository->all()->map(function($item) use(&$list, $regions) {
            $list[] = ['id' => $item->id, 'name' => $item->name, 'region' => $regions[$item->region_id]];
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
        return responseData(true, ['item' => $this->schoolRepository->find($id), 'regions' => $this->regionRepository->all()]);
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
