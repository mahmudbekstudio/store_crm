<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\RegionRepository;

class RegionController extends Controller
{
	private $regionRepository;

	public function __construct(RegionRepository $regionRepository)
	{
		$this->regionRepository = $regionRepository;
	}

    public function list()
    {
    	return responseData(true, ['list' => $this->regionRepository->all()]);
    }

    public function add(Request $request)
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
    }
}
