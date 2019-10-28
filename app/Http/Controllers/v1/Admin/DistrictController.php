<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\DistrictRepository;
use Illuminate\Http\Request;
use App\Repositories\RegionRepository;

class DistrictController extends Controller
{
	private $districtRepository;

	public function __construct(DistrictRepository $districtRepository)
	{
		$this->districtRepository = $districtRepository;
	}

    public function list()
    {
        $list = $this->districtRepository->with(['region'])->all()->toArray();

        for($i = 0; $i < count($list); $i++) {
            $list[$i]['region'] = $list[$i]['region']['name'];
        }

    	return responseData(true, ['list' => $list]);
    }

    /*public function add(Request $request)
    {
        $data = $request->only(['name']);
        $this->regionRepository->create(['user_id' => auth()->user()->id, 'name' => $data['name']]);
        return responseData(true);
    }

    public function item($id)
    {
        return responseData(true, ['item' => $this->regionRepository->find($id)]);
    }

    public function edit($id, Request $request)
    {
    	$data = $request->only(['name']);
    	$this->regionRepository->update($data, $id);
        return responseData(true);
    }

    public function delete($id)
    {
        $this->regionRepository->delete($id);
    	return responseData(true);
    }*/
}
